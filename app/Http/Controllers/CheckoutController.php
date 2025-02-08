<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $total = array_sum(array_map(fn($item) => $item['product']->price * $item['quantity'], $cart));

        return view('checkout.index', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile' => 'required',
            'address' => 'required|string',
        ]);
    
        $cart = session('cart', []);
    
        if (empty($cart)) {
            return redirect()->route('product.index')->with('error', 'Your cart is empty.');
        }
    
        $user = User::firstOrCreate(
            ['email' => $request->email],
            ['name' => $request->name, 'password' => bcrypt('123456'), 'mobile' => $request->mobile, 'address' => $request->address]
        );
    
        try {
            DB::beginTransaction();
    
            $total = 0;
            $orderIds = [];
    
            foreach ($cart as $item) {
                $order = Order::create([
                    'user_id' => $user->id,
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'total_amount' => $item['product']->price * $item['quantity'],
                    'payment_status' => 'pending',
                ]);
    
                $total += $order->total_amount;
                $orderIds[] = $order->id;
            }
    
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();
    
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('checkout.success', ['orders' => implode(',', $orderIds)]),
                    "cancel_url" => route('checkout'),
                ],
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => $total,
                        ]
                    ]
                ]
            ]);
    
            DB::commit();
    
            if (isset($response['id']) && $response['id'] !== null) {
                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        return redirect()->away($link['href']);
                    }
                }
            }
    
            return redirect()->route('checkout')->with('error', 'Something went wrong with PayPal.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout')->with('error', 'Failed to process order: ' . $e->getMessage());
        }
    }
    
    public function success(Request $request)
    {
        $orderIds = explode(',', $request->orders);
        $orders = Order::whereIn('id', $orderIds)->get();
    
        if ($orders->isEmpty()) {
            return redirect()->route('checkout')->with('error', 'Invalid order.');
        }
    
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
    
        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $orderIds = [];
        
            foreach ($orders as $order) {
                $order->update([
                    'payment_status' => 'completed',
                    'transaction_id' => $response['id'],
                ]);
                $orderIds[] = $order->id; // Collect all order IDs
            }
        
            // Store transactions for each order
    
            Transaction::create([
                'order_ids' => json_encode($orderIds), // Store as JSON
                'transaction_id' => $response['id'],
                'amount' => collect($orders)->sum('total_amount'),
                'currency' => 'USD',
                'payment_status' => 'completed',
            ]);
            
       
        
            Session::forget('cart');
        
            return redirect()->route('order.summary', ['transactionId' => $response['id']])
            ->with('success', 'Payment successful!');        
        
        }
        
        return redirect()->route('checkout')->with('error', 'Payment failed.');
    }
    
    public function orderSummary($transactionId)
    {
        try {
            // Fetch the transaction using transaction_id (throws exception if not found)
            $transaction = Transaction::where('transaction_id', $transactionId)->firstOrFail();
    
            // Decode JSON order_ids into an array
            $orderIds = json_decode($transaction->order_ids, true);
    
            // Ensure orderIds is a valid array
            if (!is_array($orderIds)) {
                $orderIds = [];
            }
    
            // Fetch the orders
            $orders = Order::with(['product', 'user'])
                ->whereIn('id', $orderIds)
                ->get();
    
            return view('checkout.summary', compact('orders', 'transaction'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('checkout')->with('error', 'No checkout summary found.');
        }
    }
        
 

}
