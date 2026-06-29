@extends('layouts.app')

@section('title', 'Product Catalog Manager | PackCraft Admin')

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
            <li><a href="{{ route('admin.products') }}" class="active" style="color: var(--color-accent); font-weight: 700; display: block; padding: 0.5rem 0.75rem; border-radius: 6px; background-color: rgba(255,255,255,0.05);"><i class="fa-solid fa-box-open" style="width: 20px;"></i> Product Catalog</a></li>
            <li><a href="{{ route('admin.categories') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-solid fa-tags" style="width: 20px;"></i> Categories</a></li>
            <li><a href="{{ route('admin.blogs') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-regular fa-newspaper" style="width: 20px;"></i> Blog Publisher</a></li>
            <li><a href="{{ route('admin.users') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-solid fa-users-gear" style="width: 20px;"></i> RBAC Simulator</a></li>
        </ul>
    </aside>

    <!-- Admin Products Content -->
    <section style="flex: 1; display: grid; grid-template-columns: 2.2fr 1.3fr; gap: 2rem; align-items: start;">
        
        <!-- Left: Product List -->
        <div>
            <div style="margin-bottom: 2rem;">
                <h1 style="font-family: var(--font-serif); font-size: 2.25rem; color: var(--color-primary);">Product Catalog Manager</h1>
                <p style="opacity: 0.7; margin-bottom: 0;">Add, modify, or delete custom packaging items in the frontend showroom.</p>
            </div>

            <div class="card" style="padding: 2rem;">
                <h3 style="font-size: 1.2rem; margin-bottom: 1.5rem; color: var(--color-primary);">Currently Listed Products</h3>
                
                @if($products->isEmpty())
                    <p style="opacity: 0.5; text-align: center; padding: 2rem 0;">No products cataloged.</p>
                @else
                    <div class="table-container" style="border: none; margin-top:0;">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Base Price</th>
                                    <th>Min Qty</th>
                                    <th style="text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $prod)
                                    <tr>
                                        <td>
                                            <strong>{{ $prod->name }}</strong>
                                            <span style="font-size: 0.75rem; opacity: 0.5; display: block;">/products/{{ $prod->slug }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-new" style="background-color: var(--color-bg-light); color: var(--color-primary);">{{ $prod->category->name }}</span>
                                        </td>
                                        <td style="font-weight: 700;">
                                            ${{ number_format($prod->base_price, 2) }}
                                        </td>
                                        <td>
                                            {{ $prod->min_qty }} units
                                        </td>
                                        <td style="text-align: center;">
                                            <form action="{{ route('admin.products.delete', $prod->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" style="padding: 0.35rem 0.6rem; font-size: 0.7rem; border-radius: 4px;">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right: Add Product Form -->
        <div class="card" style="padding: 2rem;">
            <h3 style="font-size: 1.15rem; margin-bottom: 1.5rem; color: var(--color-primary); border-bottom: 1px solid var(--color-border-light); padding-bottom: 0.5rem;"><i class="fa-solid fa-square-plus"></i> Add New Product</h3>
            
            <form action="{{ route('admin.products.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="category_id">Category *</label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        <option value="">-- Choose Category --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="name">Product Title *</label>
                    <input type="text" id="name" name="name" class="form-control" required placeholder="e.g. Premium Magnetic Gift Box">
                </div>

                <div class="form-group">
                    <label for="description">Product Description *</label>
                    <textarea id="description" name="description" rows="3" class="form-control" required placeholder="Describe the packaging application..."></textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                    <div class="form-group" style="margin-bottom:0;">
                        <label for="base_price">Base Price ($) *</label>
                        <input type="number" id="base_price" name="base_price" step="0.01" min="0.01" class="form-control" value="0.20" required>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label for="min_qty">Min Qty *</label>
                        <input type="number" id="min_qty" name="min_qty" min="1" class="form-control" value="100" required>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="features">Key Features (comma-separated)</label>
                    <input type="text" id="features" name="features" class="form-control" placeholder="100% Recycled, Magnetic Flap, Embossed Logo">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Create Product</button>
            </form>
        </div>

    </section>

</div>

@endsection
