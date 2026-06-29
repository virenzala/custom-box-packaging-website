@extends('layouts.app')

@section('title', 'RBAC User Management | PackCraft Admin')

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
            <li><a href="{{ route('admin.orders') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-solid fa-pallet" style="width: 20px;"></i> Orders Stages</a></li>
            <li><a href="{{ route('admin.products') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-solid fa-box-open" style="width: 20px;"></i> Product Catalog</a></li>
            <li><a href="{{ route('admin.categories') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-solid fa-tags" style="width: 20px;"></i> Categories</a></li>
            <li><a href="{{ route('admin.blogs') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-regular fa-newspaper" style="width: 20px;"></i> Blog Publisher</a></li>
            <li><a href="{{ route('admin.users') }}" class="active" style="color: var(--color-accent); font-weight: 700; display: block; padding: 0.5rem 0.75rem; border-radius: 6px; background-color: rgba(255,255,255,0.05);"><i class="fa-solid fa-users-gear" style="width: 20px;"></i> RBAC Simulator</a></li>
        </ul>
    </aside>

    <!-- Admin Users Content -->
    <section style="flex: 1;">
        <div style="margin-bottom: 2rem;">
            <h1 style="font-family: var(--font-serif); font-size: 2.25rem; color: var(--color-primary);">Role-Based Access Control (RBAC)</h1>
            <p style="opacity: 0.7;">View registered administrative accounts, customize operational permissions, and evaluate RBAC restrictions.</p>
        </div>

        <div class="card" style="padding: 2.5rem;">
            <h3 style="font-size: 1.25rem; margin-bottom: 1.5rem; color: var(--color-primary);"><i class="fa-solid fa-users"></i> Registered Admin Accounts</h3>
            
            <div class="table-container" style="border: none; margin-top:0;">
                <table>
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Email Address</th>
                            <th>Current Role Role</th>
                            <th style="width: 240px; text-align: center;">Modify Access Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                    <span style="font-size: 0.75rem; opacity: 0.5; display: block;">Registered: {{ $user->created_at->format('Y-m-d') }}</span>
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    <span class="badge" style="background-color: var(--color-bg-light); color: var(--color-primary); font-weight: 700; text-transform: uppercase;">
                                        {{ str_replace('_', ' ', $user->role) }}
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" style="display: flex; gap: 0.5rem; justify-content: center;">
                                        @csrf
                                        <select name="role" class="form-control" style="padding: 0.35rem 0.5rem; font-size: 0.8rem; height: 32px; width: 140px;">
                                            <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                                            <option value="super_admin" {{ $user->role === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                            <option value="sales_manager" {{ $user->role === 'sales_manager' ? 'selected' : '' }}>Sales Manager</option>
                                            <option value="content_manager" {{ $user->role === 'content_manager' ? 'selected' : '' }}>Content Manager</option>
                                            <option value="staff" {{ $user->role === 'staff' ? 'selected' : '' }}>Staff</option>
                                        </select>
                                        <button type="submit" class="btn btn-secondary" style="padding: 0 0.5rem; font-size: 0.75rem; border-radius: 4px; height: 32px;">Update</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- RBAC Middleware Explanatory Alert -->
        <div style="background-color: var(--color-info-bg); color: var(--color-info); padding: 1.5rem; border-radius: var(--border-radius); border-left: 5px solid var(--color-info); margin-top: 2rem; display: flex; align-items: start; gap: 1rem;">
            <i class="fa-solid fa-circle-info" style="font-size: 1.5rem; margin-top: 0.15rem;"></i>
            <div>
                <h4 style="margin: 0 0 0.5rem; font-size: 1.05rem;">Access Control Levels:</h4>
                <ul style="margin: 0; padding-left: 1.25rem; font-size: 0.9rem; line-height: 1.5;">
                    <li><strong>Super Admin / Admin</strong>: Full access to the dashboard, catalog manager, leads, orders, blogs, and RBAC configs.</li>
                    <li><strong>Sales Manager</strong>: Permitted to access Leads and Orders pipelines, but blocked from editing products, categories, blogs, or user roles.</li>
                    <li><strong>Content Manager</strong>: Permitted to access Blog publishing, but blocked from viewing leads, orders, catalog, or user settings.</li>
                    <li><strong>Staff</strong>: Restricted read-only view of leads and orders pipelines for status logging.</li>
                </ul>
            </div>
        </div>

    </section>

</div>

@endsection
