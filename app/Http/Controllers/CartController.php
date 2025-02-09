<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function add(Request $request, $id)
    {
        $product = Product::find($id);
    
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found!');
        }
    
        // Get or generate a browser session ID
        if (!session()->has('browser_id')) {
            session()->put('browser_id', md5($request->userAgent() . time()));
        }
    
        $browserId = session('browser_id');
    
        $cart = session()->get('cart', []);
    
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
        } else {
            $cart[$id] = [
                'product' => $product,
                'quantity' => 1,
                'browser_id' => $browserId, // Store browser ID with cart item
            ];
        }
    
        session()->put('cart', $cart);
    
        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }    

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);

        // Check if the cart is empty
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty, nothing to update.');
        }

        foreach ($request->quantities as $id => $quantity) {
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = max(1, intval($quantity)); // Ensure quantity is at least 1
            }
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }
}

