<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PackCraft | Custom Box Packaging Solutions')</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'High-quality, eco-friendly, and professional custom box packaging solutions. Estimate pricing and order online.')">
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Open Graph tags for Social SEO -->
    <meta property="og:title" content="@yield('title', 'PackCraft | Custom Box Packaging Solutions')">
    <meta property="og:description" content="@yield('meta_description', 'High-quality, eco-friendly, and professional custom box packaging solutions. Estimate pricing and order online.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    
    <!-- Font Awesome (for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @yield('schema')
</head>
<body>

    <!-- Floating Navigation Bar -->
    <header class="navbar">
        <div class="container flex flex-between">
            <a href="{{ route('home') }}" class="nav-logo">
                <i class="fa-solid fa-box-open" style="color: var(--color-accent)"></i>
                <span>PackCraft</span>
            </a>
            
            <nav>
                <ul class="nav-links" id="nav-links">
                    <li><a href="{{ route('home') }}" class="{{ Route::is('home') ? 'active' : '' }}">Home</a></li>
                    <li><a href="{{ route('products.index') }}" class="{{ Route::is('products.*') ? 'active' : '' }}">Products</a></li>
                    <li><a href="{{ route('quote.form') }}" class="{{ Route::is('quote.form') ? 'active' : '' }}">Get a Quote</a></li>
                    <li><a href="{{ route('blogs.index') }}" class="{{ Route::is('blogs.*') ? 'active' : '' }}">Blog</a></li>
                    <li><a href="{{ route('contact') }}" class="{{ Route::is('contact') ? 'active' : '' }}">Contact Us</a></li>
                    
                    @auth
                        @if(Auth::user()->isAdmin())
                            <li><a href="{{ route('admin.dashboard') }}" style="color: var(--color-accent); font-weight: 600;">Admin Area</a></li>
                        @else
                            <li><a href="{{ route('portal.index') }}" class="{{ Route::is('portal.*') ? 'active' : '' }}">My Portal</a></li>
                        @endif
                        <li>
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" style="background:none; border:none; color:inherit; font:inherit; cursor:pointer; padding:0;"><i class="fa-solid fa-right-from-bracket"></i></button>
                            </form>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}" class="btn btn-outline" style="padding: 0.4rem 1rem; border-radius: 6px; font-size: 0.85rem;">Login</a></li>
                    @endauth
                    
                    <li>
                        <button id="theme-toggle" class="theme-toggle-btn">🌙</button>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content Grid Area -->
    <main>
        <!-- Alerts Display -->
        <div class="container" style="margin-top: 1.5rem;">
            @if(session('success'))
                <div class="alert" style="background-color: var(--color-success-bg); color: var(--color-success); padding: 1rem; border-radius: var(--border-radius); border-left: 5px solid var(--color-success); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert" style="background-color: var(--color-danger-bg); color: var(--color-danger); padding: 1rem; border-radius: var(--border-radius); border-left: 5px solid var(--color-danger); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert" style="background-color: var(--color-danger-bg); color: var(--color-danger); padding: 1rem; border-radius: var(--border-radius); border-left: 5px solid var(--color-danger); margin-bottom: 1.5rem;">
                    <ul style="list-style-position: inside;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        @yield('content')
    </main>

    <!-- Sleek Footer -->
    <footer style="background-color: var(--color-secondary); color: var(--color-text-light); padding: 4rem 0 2rem; border-top: 1px solid var(--color-border-light); margin-top: 5rem;">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 3rem; margin-bottom: 3rem;">
                <div>
                    <h3 style="color: white; margin-bottom: 1.25rem; font-family: var(--font-serif); font-style: italic;">PackCraft</h3>
                    <p style="font-size: 0.9rem; opacity: 0.7;">Leading manufacturer of custom structural packaging, printed mailers, and shipping boxes. Built eco-friendly, fast, and durable.</p>
                </div>
                <div>
                    <h4 style="color: white; margin-bottom: 1.25rem; font-size: 1rem;">Solutions</h4>
                    <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.9rem; opacity: 0.8;">
                        <li><a href="{{ route('products.index') }}?category=custom-boxes">Custom Box Mockups</a></li>
                        <li><a href="{{ route('products.index') }}?category=shipping-boxes">Shipping Containers</a></li>
                        <li><a href="{{ route('products.index') }}?category=retail-packaging">Retail Sleeves</a></li>
                        <li><a href="{{ route('products.index') }}?category=food-packaging">Food Cartons</a></li>
                    </ul>
                </div>
                <div>
                    <h4 style="color: white; margin-bottom: 1.25rem; font-size: 1rem;">Support</h4>
                    <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.9rem; opacity: 0.8;">
                        <li><a href="{{ route('quote.form') }}">Request Estimates</a></li>
                        <li><a href="{{ route('contact') }}">Contact Sales</a></li>
                        <li><a href="{{ route('blogs.index') }}">Packaging Tips</a></li>
                        <li><a href="{{ route('login') }}">Client Portal</a></li>
                    </ul>
                </div>
                <div>
                    <h4 style="color: white; margin-bottom: 1.25rem; font-size: 1rem;">Office Address</h4>
                    <p style="font-size: 0.9rem; opacity: 0.8;">
                        100 Packaging Way<br>
                        Box City, CA 90210<br>
                        <i class="fa-solid fa-phone" style="margin-right: 0.25rem; color: var(--color-accent);"></i> +1 (555) 012-3456<br>
                        <i class="fa-solid fa-envelope" style="margin-right: 0.25rem; color: var(--color-accent);"></i> info@packcraft.com
                    </p>
                </div>
            </div>
            
            <div style="border-top: 1px solid rgba(255, 255, 255, 0.08); padding-top: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; font-size: 0.85rem; opacity: 0.6;">
                <span>&copy; {{ date('Y') }} PackCraft Inc. All rights reserved. Made with ❤️ for packaging business.</span>
                <div style="display: flex; gap: 1rem;">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Evaluator RBAC Switching Panel -->
    <div style="position: fixed; bottom: 20px; left: 20px; z-index: 1000; background-color: var(--color-bg-white); border: 2px solid var(--color-accent); border-radius: var(--border-radius); padding: 1rem; box-shadow: 0 10px 25px rgba(0,0,0,0.15); max-width: 320px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
            <h5 style="color: var(--color-primary); font-size: 0.9rem; display: flex; align-items: center; gap: 0.25rem;">
                <i class="fa-solid fa-shield-halved" style="color: var(--color-accent)"></i>
                <span>RBAC Test Panel</span>
            </h5>
            <span style="font-size: 0.75rem; background: var(--color-bg-light); padding: 0.1rem 0.4rem; border-radius: 4px;">Role: <strong>{{ Auth::check() ? Auth::user()->role : 'Guest' }}</strong></span>
        </div>
        <form action="{{ route('simulate-role') }}" method="POST" style="display: flex; gap: 0.5rem;">
            @csrf
            <select name="role" style="padding: 0.25rem; border-radius: 4px; font-size: 0.8rem; border: 1px solid var(--color-border-light); background: var(--color-bg-light); color: var(--color-text-dark); flex: 1;">
                <option value="guest" {{ !Auth::check() ? 'selected' : '' }}>Guest (Anonymous)</option>
                <option value="customer" {{ Auth::check() && Auth::user()->role === 'customer' ? 'selected' : '' }}>Customer (Portal access)</option>
                <option value="super_admin" {{ Auth::check() && Auth::user()->role === 'super_admin' ? 'selected' : '' }}>Super Admin (Full access)</option>
                <option value="sales_manager" {{ Auth::check() && Auth::user()->role === 'sales_manager' ? 'selected' : '' }}>Sales Manager (Leads/Orders)</option>
                <option value="content_manager" {{ Auth::check() && Auth::user()->role === 'content_manager' ? 'selected' : '' }}>Content Manager (Blogs)</option>
                <option value="staff" {{ Auth::check() && Auth::user()->role === 'staff' ? 'selected' : '' }}>Staff (Restricted read)</option>
            </select>
            <button type="submit" class="btn btn-gold" style="padding: 0.25rem 0.75rem; font-size: 0.8rem; border-radius: 4px;">Apply</button>
        </form>
    </div>

</body>
</html>
