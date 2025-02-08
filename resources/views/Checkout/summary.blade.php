@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Order Summary</h2>

    <div class="card p-4">
        @if ($orders->isNotEmpty())
            <h4>Customer: {{ $orders->first()->user->name }}</h4>
            <p><strong>Email:</strong> {{ $orders->first()->user->email }}</p>
            <p><strong>Mobile:</strong> {{ $orders->first()->user->mobile }}</p>
            <p><strong>Address:</strong> {{ $orders->first()->user->address }}</p>

            <h5 class="mt-4">Purchased Products</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp
                    @foreach ($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->product->title }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>${{ number_format($order->product->price, 2) }}</td>
                            <td>${{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                        @php $grandTotal += $order->total_amount; @endphp
                    @endforeach
                </tbody>
            </table>

            <h4 class="mt-3">Total Amount: ${{ number_format($grandTotal, 2) }}</h4>

            @if($transaction)
                <h5 class="mt-4">Transaction Details</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Amount</th>
                            <th>Currency</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $transaction->transaction_id }}</td>
                            <td>${{ number_format($transaction->amount, 2) }}</td>
                            <td>{{ strtoupper($transaction->currency) }}</td>
                            <td>
                                <span class="badge {{ $transaction->payment_status === 'success' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($transaction->payment_status) }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif
        @else
            <p class="text-danger">No orders found for this transaction.</p>
        @endif

        <a href="{{ route('product.index') }}" class="btn btn-primary mt-3">Continue Shopping</a>
    </div>
</div>
@endsection
