@extends('layouts.app')

@section('title', 'Product Catalog | PackCraft Custom Boxes')
@section('meta_description', 'Browse and customize our collection of mailers, shipping boxes, food-safe folding cartons, and rigid box packages.')

@section('content')

<style>
    .product-card-image-container {
        height: 200px;
        background-color: #f1f3f0;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    .product-card-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .card:hover .product-card-image {
        transform: scale(1.08);
    }
</style>

<section style="padding: 3rem 0;">
    <div class="container">
        
        <!-- Breadcrumbs & Heading -->
        <div style="margin-bottom: 2rem;">
            <nav style="font-size: 0.85rem; opacity: 0.6; margin-bottom: 0.5rem;">
                <a href="{{ route('home') }}">Home</a> &gt; <span>Products</span>
            </nav>
            <h1 style="font-family: var(--font-serif); font-size: 2.25rem;">Our Packaging Catalog</h1>
        </div>

        <!-- Catalog Filter Bar (Horizontal / Flex) -->
        <form action="{{ route('products.index') }}" method="GET" style="background-color: var(--color-bg-white); border: 1px solid var(--color-border-light); border-radius: var(--border-radius); padding: 1.25rem; margin-bottom: 2rem; display: flex; flex-wrap: wrap; gap: 1.5rem; align-items: center; justify-content: space-between;">
            <!-- Category and search inputs -->
            <div style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: center; flex: 1;">
                <div style="min-width: 200px; flex: 1;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="form-control" style="padding: 0.6rem 1rem;">
                </div>
                
                <div style="min-width: 180px;">
                    <select name="category" onchange="this.form.submit()" class="form-control" style="padding: 0.6rem 1rem;">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Sorting options -->
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <label style="font-size: 0.85rem; font-weight: 600; opacity: 0.7; white-space: nowrap;">Sort By:</label>
                <select name="sort" onchange="this.form.submit()" class="form-control" style="padding: 0.6rem 1rem; width: 160px;">
                    <option value="">Latest</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Alphabetical (A-Z)</option>
                </select>
                @if(request()->anyFilled(['search', 'category', 'sort']))
                    <a href="{{ route('products.index') }}" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: var(--border-radius); border-width: 1px;">Clear</a>
                @endif
            </div>
        </form>

        <!-- Main Product Grid & Sidebar -->
        <div style="display: grid; grid-template-columns: 240px 1fr; gap: 2.5rem;">
            <!-- Sidebar Navigation -->
            <aside style="background-color: var(--color-bg-white); border: 1px solid var(--color-border-light); border-radius: var(--border-radius); padding: 1.5rem; height: fit-content; position: sticky; top: 100px;">
                <h3 style="font-size: 1rem; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 1px; padding-bottom: 0.5rem; border-bottom: 1px solid var(--color-border-light);">Filter Categories</h3>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.75rem;">
                    <li>
                        <a href="{{ route('products.index') }}" style="font-size: 0.95rem; font-weight: {{ !request('category') ? '700' : '400' }}; color: {{ !request('category') ? 'var(--color-accent)' : 'inherit' }};">
                            All Packaging ({{ \App\Models\Product::count() }})
                        </a>
                    </li>
                    @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('products.index') }}?category={{ $cat->slug }}" style="font-size: 0.95rem; font-weight: {{ request('category') === $cat->slug ? '700' : '400' }}; color: {{ request('category') === $cat->slug ? 'var(--color-accent)' : 'inherit' }};">
                                {{ $cat->name }} ({{ $cat->products()->count() }})
                            </a>
                        </li>
                    @endforeach
                </ul>
            </aside>

            <!-- Product Grid -->
            <div>
                @if($products->isEmpty())
                    <div style="background-color: var(--color-bg-white); border: 1px solid var(--color-border-light); border-radius: var(--border-radius); padding: 4rem; text-align: center;">
                        <i class="fa-solid fa-box-open" style="font-size: 3rem; opacity: 0.2; margin-bottom: 1.5rem;"></i>
                        <h3>No products found matching filters.</h3>
                        <p style="opacity: 0.7; margin-bottom: 1.5rem;">Try modifying your search query or choosing another category.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">View All Products</a>
                    </div>
                @else
                    <div class="grid grid-3" style="gap: 1.5rem; margin-bottom: 3rem;">
                        @foreach($products as $prod)
                            <div class="card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between;">
                                <div>
                                    <div class="product-card-image-container">
                                        @if($prod->image)
                                            <img src="{{ asset('images/products/' . $prod->image) }}" alt="{{ $prod->name }}" class="product-card-image">
                                        @else
                                            <!-- Interactive SVG preview of box -->
                                            <svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                                <polygon points="50,28 75,40 50,52 25,40" fill="none" stroke="var(--color-primary)" stroke-width="0.8"/>
                                                <polygon points="25,40 50,52 50,75 25,63" fill="none" stroke="var(--color-primary)" stroke-width="0.8"/>
                                                <polygon points="50,52 75,40 75,63 50,75" fill="none" stroke="var(--color-primary)" stroke-width="0.8"/>
                                            </svg>
                                        @endif
                                        <span style="position: absolute; top: 12px; left: 12px; font-size: 0.75rem; font-weight: 600; background: var(--color-primary); color: white; padding: 0.2rem 0.6rem; border-radius: 4px;">{{ $prod->category->name }}</span>
                                    </div>
                                    <div style="padding: 1.5rem;">
                                        <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem; color: var(--color-primary);">{{ $prod->name }}</h3>
                                        <p style="font-size: 0.85rem; opacity: 0.7; margin-bottom: 0;">{{ Str::limit($prod->description, 100) }}</p>
                                    </div>
                                </div>
                                <div style="padding: 1.5rem; border-top: 1px solid var(--color-border-light); display: flex; align-items: center; justify-content: space-between;">
                                    <div>
                                        <span style="font-size: 0.75rem; opacity: 0.6; display: block; text-transform: uppercase;">Wholesale Price</span>
                                        <strong style="color: var(--color-primary); font-size: 1.05rem;">From ${{ number_format($prod->base_price, 2) }}</strong>
                                    </div>
                                    <a href="{{ route('products.show', $prod->slug) }}" class="btn btn-gold" style="padding: 0.45rem 1.15rem; border-radius: 6px; font-size: 0.8rem;">Configure</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Custom Pagination Rendering -->
                    <div class="flex flex-center" style="margin-top: 2rem;">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</section>

@endsection
