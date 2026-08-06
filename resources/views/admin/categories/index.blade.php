@extends('layouts.app')

@section('title', 'Categories Manager | PackCraft Admin')

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
            <li><a href="{{ route('admin.categories') }}" class="active" style="color: var(--color-accent); font-weight: 700; display: block; padding: 0.5rem 0.75rem; border-radius: 6px; background-color: rgba(255,255,255,0.05);"><i class="fa-solid fa-tags" style="width: 20px;"></i> Categories</a></li>
            <li><a href="{{ route('admin.blogs') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-regular fa-newspaper" style="width: 20px;"></i> Blog Publisher</a></li>
            <li><a href="{{ route('admin.users') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-solid fa-users-gear" style="width: 20px;"></i> RBAC Simulator</a></li>
        </ul>
    </aside>

    <!-- Admin Categories Content -->
    <section style="flex: 1; display: grid; grid-template-columns: 2.2fr 1.3fr; gap: 2rem; align-items: start;">
        
        <!-- Left: Categories List -->
        <div>
            <div style="margin-bottom: 2rem;">
                <h1 style="font-family: var(--font-serif); font-size: 2.25rem; color: var(--color-primary);">Packaging Categories</h1>
                <p style="opacity: 0.7; margin-bottom: 0;">Organize products into major packaging categories.</p>
            </div>

            <div class="card" style="padding: 2rem;">
                <h3 style="font-size: 1.2rem; margin-bottom: 1.5rem; color: var(--color-primary);">Active Categories</h3>
                
                <div class="table-container" style="border: none; margin-top:0;">
                    <table>
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Description</th>
                                <th style="text-align: center;">Listed Products</th>
                                <th style="text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $cat)
                                <tr>
                                    <td>
                                        <strong>{{ $cat->name }}</strong>
                                        <span style="font-size: 0.75rem; opacity: 0.5; display: block;">/category/{{ $cat->slug }}</span>
                                    </td>
                                    <td style="font-size: 0.85rem; opacity: 0.8;">
                                        {{ $cat->description }}
                                    </td>
                                    <td style="text-align: center; font-weight: 600;">
                                        {{ $cat->products_count }}
                                    </td>
                                    <td style="text-align: center;">
                                        <form action="{{ route('admin.categories.delete', $cat->id) }}" method="POST" onsubmit="return confirm('Deleting this category will delete all associated products. Are you sure?');" style="display: inline;">
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
            </div>
        </div>

        <!-- Right: Add Category Form -->
        <div class="card" style="padding: 2rem;">
            <h3 style="font-size: 1.15rem; margin-bottom: 1.5rem; color: var(--color-primary); border-bottom: 1px solid var(--color-border-light); padding-bottom: 0.5rem;"><i class="fa-solid fa-square-plus"></i> Add Category</h3>
            
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Category Name *</label>
                    <input type="text" id="name" name="name" class="form-control" required placeholder="e.g. Rigid Box Packaging">
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" class="form-control" placeholder="Describe this category's materials and structural design..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Create Category</button>
            </form>
        </div>

    </section>

</div>

@endsection
