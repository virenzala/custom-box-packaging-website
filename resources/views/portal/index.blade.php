@extends('layouts.app')

@section('title', 'Client Portal | PackCraft Custom Boxes')

@section('content')

<section style="padding: 3rem 0;">
    <div class="container">
        
        <!-- Welcome Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <nav style="font-size: 0.85rem; opacity: 0.6; margin-bottom: 0.5rem;">
                    <span>Client Portal</span>
                </nav>
                <h1 style="font-family: var(--font-serif); font-size: 2.25rem;">Welcome, {{ Auth::user()->name }}</h1>
                <p style="opacity: 0.7; margin-bottom: 0;">Manage your custom structural box configurations and orders.</p>
            </div>
            
            <div style="background-color: var(--color-bg-white); border: 1px solid var(--color-border-light); border-radius: var(--border-radius); padding: 0.75rem 1.5rem; display: flex; align-items: center; gap: 1rem;">
                <span style="font-size: 0.9rem; opacity: 0.7;">Account Level:</span>
                <strong style="color: var(--color-accent); text-transform: uppercase; font-size: 0.9rem;">Customer</strong>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 2.5fr; gap: 3rem; align-items: start;">
            
            <!-- Left Side: Profile info card -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div class="card" style="padding: 2rem;">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--color-primary); border-bottom: 1px solid var(--color-border-light); padding-bottom: 0.5rem;">Account Details</h3>
                    <div style="display: flex; flex-direction: column; gap: 1rem; font-size: 0.9rem;">
                        <div>
                            <span style="opacity: 0.6; display: block; font-size: 0.8rem; text-transform: uppercase;">Company/Name</span>
                            <strong>{{ Auth::user()->name }}</strong>
                        </div>
                        <div>
                            <span style="opacity: 0.6; display: block; font-size: 0.8rem; text-transform: uppercase;">Registered Email</span>
                            <strong>{{ Auth::user()->email }}</strong>
                        </div>
                        <div>
                            <span style="opacity: 0.6; display: block; font-size: 0.8rem; text-transform: uppercase;">Default Address</span>
                            <span style="opacity: 0.85; font-style: italic;">
                                @if($orders->isNotEmpty())
                                    {{ $orders->first()->shipping_address }}
                                @else
                                    No shipping address saved yet. Address will save on your first checkout.
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Call to action card -->
                <div class="card" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%); color: white; text-align: center;">
                    <i class="fa-solid fa-square-plus" style="font-size: 2.5rem; color: var(--color-accent); margin-bottom: 1rem;"></i>
                    <h3 style="color: white; font-size: 1.1rem; margin-bottom: 0.5rem;">Need More Boxes?</h3>
                    <p style="font-size: 0.85rem; opacity: 0.8; margin-bottom: 1.25rem;">Start a new custom box mockup config.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-gold" style="width:100%; padding: 0.5rem; font-size: 0.85rem; border-radius: 6px;">Configure Box</a>
                </div>
            </div>

            <!-- Right Side: Order history log -->
            <div class="card" style="padding: 2.5rem;">
                <h3 style="font-size: 1.25rem; margin-bottom: 1.5rem; color: var(--color-primary);">Your Custom Packaging Orders</h3>
                
                @if($orders->isEmpty())
                    <div style="text-align: center; padding: 3rem 0;">
                        <i class="fa-solid fa-folder-open" style="font-size: 3rem; opacity: 0.15; margin-bottom: 1rem;"></i>
                        <h4 style="opacity: 0.8;">No orders found.</h4>
                        <p style="font-size: 0.9rem; opacity: 0.6; margin-bottom: 1.5rem;">You haven't customized or placed any packaging orders yet.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">Start Customizing</a>
                    </div>
                @else
                    <div class="table-container" style="border: none; margin-top: 0;">
                        <table>
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Box Configuration</th>
                                    <th>Dimensions (cm)</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th style="text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <strong style="color: var(--color-primary);">#{{ $order->id }}</strong>
                                            <span style="font-size: 0.75rem; opacity: 0.5; display: block;">{{ $order->created_at->format('Y-m-d') }}</span>
                                        </td>
                                        <td>
                                            <strong style="font-size: 0.95rem;">{{ $order->product_name }}</strong>
                                            <span style="font-size: 0.8rem; opacity: 0.7; display: block; font-style: italic;">Material: {{ $order->material }}</span>
                                        </td>
                                        <td style="font-size: 0.85rem; opacity: 0.85;">
                                            {{ $order->length }} x {{ $order->width }} x {{ $order->height }}
                                        </td>
                                        <td style="font-weight: 500;">
                                            {{ $order->quantity }} pcs
                                        </td>
                                        <td style="font-weight: 700; color: var(--color-primary);">
                                            ${{ number_format($order->total_price, 2) }}
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ strtolower($order->status) }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td style="text-align: center;">
                                            <a href="{{ route('portal.invoice', $order->id) }}" class="btn btn-outline" style="padding: 0.35rem 0.75rem; font-size: 0.75rem; border-radius: 4px; border-width: 1px;">
                                                <i class="fa-solid fa-file-invoice" style="margin-right: 0.25rem;"></i> Invoice
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>

    </div>
</section>

@endsection
