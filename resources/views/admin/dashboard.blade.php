@extends('layouts.app')

@section('title', 'Admin Overview | PackCraft Control Panel')

@section('content')

<div class="admin-layout container" style="margin-top: 2rem; gap: 2rem;">
    
    <!-- Admin Navigation Sidebar -->
    <aside style="background-color: var(--color-primary); color: white; border-radius: var(--border-radius); padding: 2rem 1.5rem; height: fit-content;">
        <h3 style="color: var(--color-accent); font-size: 1.15rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; font-family: var(--font-serif); font-style: italic;">
            <i class="fa-solid fa-gauge-high"></i> Control Panel
        </h3>
        <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.95rem;">
            <li><a href="{{ route('admin.dashboard') }}" class="active" style="color: var(--color-accent); font-weight: 700; display: block; padding: 0.5rem 0.75rem; border-radius: 6px; background-color: rgba(255,255,255,0.05);"><i class="fa-solid fa-chart-line" style="width: 20px;"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.leads') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-solid fa-envelopes-bulk" style="width: 20px;"></i> Leads Pipeline</a></li>
            <li><a href="{{ route('admin.orders') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-solid fa-pallet" style="width: 20px;"></i> Orders Stages</a></li>
            <li><a href="{{ route('admin.products') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-solid fa-box-open" style="width: 20px;"></i> Product Catalog</a></li>
            <li><a href="{{ route('admin.categories') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-solid fa-tags" style="width: 20px;"></i> Categories</a></li>
            <li><a href="{{ route('admin.blogs') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-regular fa-newspaper" style="width: 20px;"></i> Blog Publisher</a></li>
            <li><a href="{{ route('admin.users') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-solid fa-users-gear" style="width: 20px;"></i> RBAC Simulator</a></li>
        </ul>
    </aside>

    <!-- Admin Content Area -->
    <section style="flex: 1;">
        <div style="margin-bottom: 2rem;">
            <h1 style="font-family: var(--font-serif); font-size: 2.25rem; color: var(--color-primary);">Operations Dashboard</h1>
            <p style="opacity: 0.7;">Centralized overview of recent sales, inquiries, and manufacturing progress.</p>
        </div>

        <!-- Metrics widgets grid -->
        <div class="grid grid-4" style="margin-bottom: 3rem; gap: 1.25rem;">
            <!-- Revenue widget -->
            <div class="card" style="padding: 1.5rem; border-left: 4px solid var(--color-accent); display: flex; align-items: center; gap: 1rem;">
                <div style="width: 45px; height: 45px; background-color: rgba(212, 175, 55, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: var(--color-accent);">
                    <i class="fa-solid fa-dollar-sign"></i>
                </div>
                <div>
                    <span style="font-size: 0.8rem; opacity: 0.6; display: block; text-transform: uppercase;">Total Revenue</span>
                    <strong style="font-size: 1.35rem; color: var(--color-primary);">${{ number_format($revenue, 2) }}</strong>
                </div>
            </div>

            <!-- Leads widget -->
            <div class="card" style="padding: 1.5rem; border-left: 4px solid var(--color-primary); display: flex; align-items: center; gap: 1rem;">
                <div style="width: 45px; height: 45px; background-color: rgba(30, 56, 43, 0.08); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: var(--color-primary);">
                    <i class="fa-solid fa-envelopes-bulk"></i>
                </div>
                <div>
                    <span style="font-size: 0.8rem; opacity: 0.6; display: block; text-transform: uppercase;">New Leads</span>
                    <strong style="font-size: 1.35rem; color: var(--color-primary);">{{ $newLeads }}</strong>
                </div>
            </div>

            <!-- Orders widget -->
            <div class="card" style="padding: 1.5rem; border-left: 4px solid #0277bd; display: flex; align-items: center; gap: 1rem;">
                <div style="width: 45px; height: 45px; background-color: #e1f5fe; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: #0277bd;">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <div>
                    <span style="font-size: 0.8rem; opacity: 0.6; display: block; text-transform: uppercase;">Total Orders</span>
                    <strong style="font-size: 1.35rem; color: var(--color-primary);">{{ $totalOrders }}</strong>
                </div>
            </div>

            <!-- Pending Orders widget -->
            <div class="card" style="padding: 1.5rem; border-left: 4px solid var(--color-warning); display: flex; align-items: center; gap: 1rem;">
                <div style="width: 45px; height: 45px; background-color: var(--color-warning-bg); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: var(--color-warning);">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div>
                    <span style="font-size: 0.8rem; opacity: 0.6; display: block; text-transform: uppercase;">Pending Orders</span>
                    <strong style="font-size: 1.35rem; color: var(--color-primary);">{{ $pendingOrders }}</strong>
                </div>
            </div>
        </div>

        <!-- Recent Leads & Orders Columns -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            
            <!-- Column 1: Recent Inquiries -->
            <div class="card" style="padding: 1.75rem;">
                <div class="flex flex-between" style="margin-bottom: 1.25rem; border-bottom: 1px solid var(--color-border-light); padding-bottom: 0.5rem;">
                    <h3 style="font-size: 1.1rem; color: var(--color-primary);"><i class="fa-solid fa-list-check" style="margin-right: 0.25rem;"></i> Recent Leads</h3>
                    <a href="{{ route('admin.leads') }}" style="font-size: 0.8rem; color: var(--color-accent); font-weight: 600;">View All</a>
                </div>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @forelse($recentLeads as $lead)
                        <div style="border-bottom: 1px dashed var(--color-border-light); padding-bottom: 0.75rem;">
                            <div class="flex flex-between">
                                <strong style="font-size: 0.95rem;">{{ $lead->name }}</strong>
                                <span class="badge badge-new" style="font-size: 0.7rem;">{{ $lead->status }}</span>
                            </div>
                            <span style="font-size: 0.8rem; opacity: 0.7; display: block; margin-top: 0.1rem;">
                                {{ $lead->type === 'quote' ? 'Quote for ' . $lead->product_type : 'Contact form' }}
                            </span>
                        </div>
                    @empty
                        <p style="font-size: 0.9rem; opacity: 0.5; text-align: center;">No leads received yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Column 2: Recent Orders -->
            <div class="card" style="padding: 1.75rem;">
                <div class="flex flex-between" style="margin-bottom: 1.25rem; border-bottom: 1px solid var(--color-border-light); padding-bottom: 0.5rem;">
                    <h3 style="font-size: 1.1rem; color: var(--color-primary);"><i class="fa-solid fa-basket-shopping" style="margin-right: 0.25rem;"></i> Recent Orders</h3>
                    <a href="{{ route('admin.orders') }}" style="font-size: 0.8rem; color: var(--color-accent); font-weight: 600;">View All</a>
                </div>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @forelse($recentOrders as $order)
                        <div style="border-bottom: 1px dashed var(--color-border-light); padding-bottom: 0.75rem;">
                            <div class="flex flex-between">
                                <strong style="font-size: 0.95rem;">#{{ $order->id }} - {{ $order->billing_name }}</strong>
                                <span class="badge badge-{{ strtolower($order->status) }}" style="font-size: 0.7rem;">{{ $order->status }}</span>
                            </div>
                            <span style="font-size: 0.8rem; opacity: 0.7; display: block; margin-top: 0.1rem;">
                                {{ $order->product_name }} ({{ $order->quantity }} pcs) - <strong>${{ number_format($order->total_price, 2) }}</strong>
                            </span>
                        </div>
                    @empty
                        <p style="font-size: 0.9rem; opacity: 0.5; text-align: center;">No orders received yet.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </section>

</div>

@endsection
