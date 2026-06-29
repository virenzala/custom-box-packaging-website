@extends('layouts.app')

@section('title', 'Orders Pipeline | PackCraft Admin')

@section('content')

<div class="admin-layout container" style="margin-top: 2rem; gap: 2rem;">
    
    <!-- Admin Sidebar -->
    <aside style="background-color: var(--color-primary); color: white; border-radius: var(--border-radius); padding: 2rem 1.5rem; height: fit-content;">
        <h3 style="color: var(--color-accent); font-size: 1.15rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; font-family: var(--font-serif); font-style: italic;">
            <i class="fa-solid fa-gauge-high"></i> Control Panel
        </h3>
        <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.95rem;">
            <li><a href="{{ route('admin.dashboard') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-solid fa-chart-line" style="width: 20px;"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.leads') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-solid fa-envelopes-bulk" style="width: 20px;"></i> Leads Pipeline</a></li>
            <li><a href="{{ route('admin.orders') }}" class="active" style="color: var(--color-accent); font-weight: 700; display: block; padding: 0.5rem 0.75rem; border-radius: 6px; background-color: rgba(255,255,255,0.05);"><i class="fa-solid fa-pallet" style="width: 20px;"></i> Orders Stages</a></li>
            <li><a href="{{ route('admin.products') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-solid fa-box-open" style="width: 20px;"></i> Product Catalog</a></li>
            <li><a href="{{ route('admin.categories') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-solid fa-tags" style="width: 20px;"></i> Categories</a></li>
            <li><a href="{{ route('admin.blogs') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-regular fa-newspaper" style="width: 20px;"></i> Blog Publisher</a></li>
            <li><a href="{{ route('admin.users') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-solid fa-users-gear" style="width: 20px;"></i> RBAC Simulator</a></li>
        </ul>
    </aside>

    <!-- Admin Orders Content -->
    <section style="flex: 1;">
        
        <!-- Header -->
        <div style="margin-bottom: 2rem;">
            <h1 style="font-family: var(--font-serif); font-size: 2.25rem; color: var(--color-primary);">Orders & Manufacturing Stages</h1>
            <p style="opacity: 0.7;">View checkout payments and shift boxes from approved to manufacturing and delivery.</p>
        </div>

        <!-- Filter Form -->
        <form action="{{ route('admin.orders') }}" method="GET" style="background-color: var(--color-bg-white); border: 1px solid var(--color-border-light); border-radius: var(--border-radius); padding: 1.25rem; margin-bottom: 2rem; display: flex; flex-wrap: wrap; gap: 1rem; align-items: center;">
            <div style="flex: 1; min-width: 200px;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by order ID, billing name, email..." class="form-control">
            </div>
            
            <div style="width: 180px;">
                <select name="status" onchange="this.form.submit()" class="form-control">
                    <option value="">All Stages</option>
                    <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Processing" {{ request('status') === 'Processing' ? 'selected' : '' }}>Processing</option>
                    <option value="Approved" {{ request('status') === 'Approved' ? 'selected' : '' }}>Approved</option>
                    <option value="Manufacturing" {{ request('status') === 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                    <option value="Shipped" {{ request('status') === 'Shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="Delivered" {{ request('status') === 'Delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="Cancelled" {{ request('status') === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            @if(request()->anyFilled(['search', 'status']))
                <a href="{{ route('admin.orders') }}" class="btn btn-outline" style="padding: 0.55rem 1rem; border-radius: var(--border-radius); border-width: 1px;">Clear</a>
            @endif
        </form>

        <!-- Orders Table/Cards -->
        @if($orders->isEmpty())
            <div class="card" style="text-align: center; padding: 4rem;">
                <i class="fa-solid fa-box-open" style="font-size: 3rem; opacity: 0.15; margin-bottom: 1rem;"></i>
                <h4>No packaging orders registered yet.</h4>
            </div>
        @else
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                @foreach($orders as $order)
                    <div class="card" style="padding: 1.75rem; border-left: 5px solid #0277bd;">
                        
                        <div class="flex flex-between" style="border-bottom: 1px solid var(--color-border-light); padding-bottom: 0.75rem; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem;">
                            <div>
                                <h3 style="font-size: 1.15rem; color: var(--color-primary);">Order #{{ $order->id }}</h3>
                                <span style="font-size: 0.8rem; opacity: 0.5;">Placed: {{ $order->created_at->toDateTimeString() }}</span>
                            </div>
                            
                            <div style="display: flex; gap: 0.75rem; align-items: center;">
                                <span class="badge badge-{{ strtolower($order->status) }}">{{ $order->status }}</span>
                                <a href="{{ route('portal.invoice', $order->id) }}" target="_blank" class="btn btn-outline" style="padding: 0.25rem 0.5rem; font-size: 0.7rem; border-radius: 4px; border-width:1px;">View Statement</a>
                            </div>
                        </div>

                        <!-- Grid -->
                        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
                            
                            <!-- Left: Details -->
                            <div style="font-size: 0.9rem;">
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1rem;">
                                    <div>
                                        <span style="opacity: 0.6; display: block; font-size: 0.75rem; text-transform: uppercase;">Customer details</span>
                                        <strong>{{ $order->billing_name }}</strong>
                                        <span style="display: block; opacity: 0.85;">{{ $order->billing_email }}</span>
                                        <span style="display: block; opacity: 0.85;">{{ $order->billing_phone }}</span>
                                    </div>
                                    <div>
                                        <span style="opacity: 0.6; display: block; font-size: 0.75rem; text-transform: uppercase;">Shipping Address</span>
                                        <address style="font-style: normal; opacity: 0.85; white-space: pre-line;">{{ $order->shipping_address }}</address>
                                    </div>
                                </div>

                                <div style="background-color: var(--color-bg-light); border-radius: var(--border-radius); padding: 1rem; border: 1px solid var(--color-border-light);">
                                    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 0.5rem; border-bottom: 1px dashed var(--color-border-light); padding-bottom: 0.25rem;">
                                        <strong style="color: var(--color-primary); font-size: 0.85rem; text-transform: uppercase;">Box Configuration Summary:</strong>
                                        <strong style="color: var(--color-primary); font-size: 1.1rem;">Total: ${{ number_format($order->total_price, 2) }}</strong>
                                    </div>
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                        <div>
                                            <p style="margin:0;"><strong>Box Style:</strong> {{ $order->product_name }}</p>
                                            <p style="margin:0;"><strong>Material:</strong> {{ $order->material }}</p>
                                            <p style="margin:0;"><strong>Dimensions:</strong> {{ $order->length }} x {{ $order->width }} x {{ $order->height }} cm</p>
                                        </div>
                                        <div>
                                            <p style="margin:0;"><strong>Quantity:</strong> {{ $order->quantity }} units</p>
                                            <p style="margin:0;">
                                                <strong>Finishes:</strong> 
                                                @if($order->printing_required) Print, @endif
                                                @if($order->lamination) Matte, @endif
                                                @if($order->embossing) Embossed, @endif
                                                @if($order->foil_stamping) Foil, @endif
                                                @if($order->window_cutout) Window @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Status Shift -->
                            <div style="background-color: var(--color-bg-light); border: 1px solid var(--color-border-light); border-radius: var(--border-radius); padding: 1.25rem;">
                                <h4 style="font-size: 0.9rem; margin-bottom: 1rem; color: var(--color-primary); text-transform: uppercase; letter-spacing: 0.5px;"><i class="fa-solid fa-truck-ramp-box"></i> Order Status</h4>
                                
                                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                    @csrf
                                    
                                    <div class="form-group">
                                        <label for="status_{{ $order->id }}">Shift Stage</label>
                                        <select id="status_{{ $order->id }}" name="status" class="form-control" style="padding: 0.4rem; font-size: 0.85rem;">
                                            <option value="Pending" {{ $order->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Processing" {{ $order->status === 'Processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="Approved" {{ $order->status === 'Approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="Manufacturing" {{ $order->status === 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                                            <option value="Shipped" {{ $order->status === 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="Delivered" {{ $order->status === 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="Cancelled" {{ $order->status === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>

                                    <div class="form-group" style="margin-bottom: 1rem;">
                                        <label for="notes_{{ $order->id }}">Artisan Notes</label>
                                        <textarea id="notes_{{ $order->id }}" name="notes" rows="2" class="form-control" style="font-size: 0.85rem;" placeholder="E.g. Shipped via UPS tracking #...">{{ $order->notes }}</textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.45rem; font-size: 0.8rem; border-radius: 6px;">Update Stage</button>
                                </form>
                            </div>

                        </div>

                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="flex flex-center" style="margin-top: 1.5rem;">
                    {{ $orders->links() }}
                </div>
            </div>
        @endif

    </section>

</div>

@endsection
