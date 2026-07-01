@extends('layouts.app')

@section('title', 'PackCraft | Custom Box Packaging Solutions')

@section('content')

<!-- Hero Banner Section -->
<section class="hero">
    <div class="container flex flex-between" style="flex-wrap: wrap; gap: 3rem;">
        <div class="hero-content animate-fade-in-up">
            <span style="color: var(--color-accent); font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 2px; display: inline-block; margin-bottom: 0.75rem;">Premium Manufacturing</span>
            <h1>Tailored Packaging Solutions For Your Brand</h1>
            <p>Elevate your customer unboxing experience with custom mailer boxes, folding cartons, and shipping containers built exactly to your sizes. Fast delivery, low minimum quantities, and eco-friendly boards.</p>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="{{ route('products.index') }}" class="btn btn-gold">Shop Products</a>
                <a href="{{ route('quote.form') }}" class="btn btn-outline" style="color: white; border-color: white;">Get a Quote</a>
            </div>
        </div>
        
        <div class="animate-fade-in-up" style="flex: 1; display: flex; justify-content: center; align-items: center; min-width: 300px;">
            <!-- Render a beautiful default packaging box SVG with realistic lighting -->
            <svg class="box-svg" width="320" height="320" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <!-- Isometric projection helper of a premium box -->
                <polygon points="50,15 85,32 50,50 15,32" fill="url(#topGrad)" stroke="#1e382b" stroke-width="0.3"/>
                <polygon points="15,32 50,50 50,85 15,67" fill="url(#leftGrad)" stroke="#1e382b" stroke-width="0.3"/>
                <polygon points="50,50 85,32 85,67 50,85" fill="url(#rightGrad)" stroke="#1e382b" stroke-width="0.3"/>
                
                <!-- Gold Accent Box Strip -->
                <polygon points="45,47.5 55,52.5 55,87.5 45,82.5" fill="#d4af37" opacity="0.85"/>
                
                <defs>
                    <linearGradient id="topGrad" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0%" stop-color="#2c4d3d"/>
                        <stop offset="100%" stop-color="#1e382b"/>
                    </linearGradient>
                    <linearGradient id="leftGrad" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="#1e382b"/>
                        <stop offset="100%" stop-color="#0e1110"/>
                    </linearGradient>
                    <linearGradient id="rightGrad" x1="1" y1="0" x2="1" y2="1">
                        <stop offset="0%" stop-color="#192e23"/>
                        <stop offset="100%" stop-color="#0a0c0b"/>
                    </linearGradient>
                </defs>
            </svg>
        </div>
    </div>
</section>

<!-- Product Categories Grid Section -->
<section style="padding: 5rem 0;">
    <div class="container">
        <div style="text-align: center; max-width: 600px; margin: 0 auto 3.5rem;">
            <h2 style="font-family: var(--font-serif); font-size: 2.25rem; margin-bottom: 1rem;">Browse Packaging Categories</h2>
            <p style="opacity: 0.7;">Select a packaging style to configure dimensions, choose materials, calculate prices, and submit orders.</p>
        </div>
        
        <div class="grid grid-4">
            @foreach($categories as $cat)
                <a href="{{ route('products.index') }}?category={{ $cat->slug }}" class="category-card" style="background-image: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.4)), url('https://picsum.photos/seed/{{ $cat->id }}/400/300');">
                    <div class="category-card-content">
                        <h3>{{ $cat->name }}</h3>
                        <span style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; color: var(--color-accent);">Configure <i class="fa-solid fa-arrow-right"></i></span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section style="background-color: var(--color-bg-white); padding: 5rem 0; border-top: 1px solid var(--color-border-light); border-bottom: 1px solid var(--color-border-light);">
    <div class="container">
        <div style="text-align: center; max-width: 600px; margin: 0 auto 3.5rem;">
            <h2 style="font-family: var(--font-serif); font-size: 2.25rem; margin-bottom: 1rem;">Why Businesses Trust PackCraft</h2>
            <p style="opacity: 0.7;">We combine engineering expertise with state-of-the-art manufacturing to deliver superior box customisation.</p>
        </div>
        
        <div class="grid grid-3">
            <div class="card" style="text-align: center;">
                <div style="width: 60px; height: 60px; background-color: rgba(30, 56, 43, 0.08); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.5rem; color: var(--color-primary);">
                    <i class="fa-solid fa-leaf"></i>
                </div>
                <h3 style="margin-bottom: 0.75rem; font-size: 1.2rem;">Eco-Friendly Materials</h3>
                <p style="font-size: 0.95rem; opacity: 0.7;">We use FSC certified kraft papers, biodegradable cardboard layers, and non-toxic water-based inks.</p>
            </div>
            
            <div class="card" style="text-align: center;">
                <div style="width: 60px; height: 60px; background-color: rgba(30, 56, 43, 0.08); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.5rem; color: var(--color-primary);">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <h3 style="margin-bottom: 0.75rem; font-size: 1.2rem;">Fast Delivery Timelines</h3>
                <p style="font-size: 0.95rem; opacity: 0.7;">Standard production ships in 8-10 business days. Expedited rush tooling runs in 5 days.</p>
            </div>
            
            <div class="card" style="text-align: center;">
                <div style="width: 60px; height: 60px; background-color: rgba(30, 56, 43, 0.08); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.5rem; color: var(--color-primary);">
                    <i class="fa-solid fa-sliders"></i>
                </div>
                <h3 style="margin-bottom: 0.75rem; font-size: 1.2rem;">Custom Sizing Engine</h3>
                <p style="font-size: 0.95rem; opacity: 0.7;">No expensive layout fees. Type in the exact height, width, and length you need for your product.</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section style="padding: 5rem 0;">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3.5rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h2 style="font-family: var(--font-serif); font-size: 2.25rem; margin-bottom: 0.5rem;">Popular Packaging Styles</h2>
                <p style="opacity: 0.7; max-width: 500px;">Our most requested box configurations, suitable for startup retail and bulk e-commerce shippers.</p>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-outline">View Catalog <i class="fa-solid fa-angle-right" style="margin-left: 0.25rem;"></i></a>
        </div>
        
        <div class="grid grid-3">
            @foreach($featuredProducts as $prod)
                <div class="card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;">
                    <div style="height: 220px; background-color: #f1f3f0; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                        @if($prod->image)
                            <img src="{{ asset('images/products/' . $prod->image) }}" alt="{{ $prod->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <!-- Rendering box wireframe layout -->
                            <svg width="120" height="120" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" style="opacity: 0.85;">
                                <polygon points="50,25 80,40 50,55 20,40" fill="none" stroke="var(--color-primary)" stroke-width="1"/>
                                <polygon points="20,40 50,55 50,80 20,65" fill="none" stroke="var(--color-primary)" stroke-width="1"/>
                                <polygon points="50,55 80,40 80,65 50,80" fill="none" stroke="var(--color-primary)" stroke-width="1"/>
                            </svg>
                        @endif
                    </div>
                    <div style="padding: 1.5rem; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <h3 style="font-size: 1.15rem; margin-bottom: 0.5rem;">{{ $prod->name }}</h3>
                            <p style="font-size: 0.9rem; opacity: 0.7; margin-bottom: 1.25rem; min-height: 40px;">{{ Str::limit($prod->description, 70) }}</p>
                        </div>
                        <div class="flex flex-between">
                            <span style="font-weight: 700; color: var(--color-primary);">From ${{ number_format($prod->base_price, 2) }}/unit</span>
                            <a href="{{ route('products.show', $prod->slug) }}" class="btn btn-gold" style="padding: 0.4rem 1rem; border-radius: 6px; font-size: 0.8rem;">Customize</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Industries Served Section -->
<section style="background-color: var(--color-primary); color: white; padding: 5rem 0;">
    <div class="container">
        <div style="text-align: center; max-width: 600px; margin: 0 auto 3.5rem;">
            <h2 style="color: white; font-family: var(--font-serif); font-size: 2.25rem; margin-bottom: 1rem;">Packaging For Every Industry</h2>
            <p style="opacity: 0.8;">We manufacture customized containment boards tailored for specific niche sectors.</p>
        </div>
        
        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 2rem;">
            <div style="background-color: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: var(--border-radius); padding: 1.5rem 2rem; text-align: center; min-width: 180px;">
                <i class="fa-solid fa-mug-hot" style="font-size: 2rem; color: var(--color-accent); margin-bottom: 0.75rem;"></i>
                <h4 style="color: white;">Food & Beverage</h4>
            </div>
            <div style="background-color: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: var(--border-radius); padding: 1.5rem 2rem; text-align: center; min-width: 180px;">
                <i class="fa-solid fa-bag-shopping" style="font-size: 2rem; color: var(--color-accent); margin-bottom: 0.75rem;"></i>
                <h4 style="color: white;">E-commerce</h4>
            </div>
            <div style="background-color: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: var(--border-radius); padding: 1.5rem 2rem; text-align: center; min-width: 180px;">
                <i class="fa-solid fa-sparkles" style="font-size: 2rem; color: var(--color-accent); margin-bottom: 0.75rem;"></i>
                <h4 style="color: white;">Cosmetics</h4>
            </div>
            <div style="background-color: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: var(--border-radius); padding: 1.5rem 2rem; text-align: center; min-width: 180px;">
                <i class="fa-solid fa-laptop" style="font-size: 2rem; color: var(--color-accent); margin-bottom: 0.75rem;"></i>
                <h4 style="color: white;">Electronics</h4>
            </div>
            <div style="background-color: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: var(--border-radius); padding: 1.5rem 2rem; text-align: center; min-width: 180px;">
                <i class="fa-solid fa-store" style="font-size: 2rem; color: var(--color-accent); margin-bottom: 0.75rem;"></i>
                <h4 style="color: white;">Retail Goods</h4>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section style="padding: 5rem 0;">
    <div class="container">
        <div style="text-align: center; max-width: 600px; margin: 0 auto 3.5rem;">
            <h2 style="font-family: var(--font-serif); font-size: 2.25rem; margin-bottom: 1rem;">What Our Clients Say</h2>
            <p style="opacity: 0.7;">We ship custom orders globally for hundreds of active cosmetic, food, and electronics brands.</p>
        </div>
        
        <div class="grid grid-3">
            <div class="card" style="display: flex; flex-direction: column; justify-content: space-between;">
                <p style="font-style: italic; opacity: 0.85;">"The online customizer computed our exact prices instantly! We placed an order of 500 mailer boxes and they arrived in 9 days. Brilliant print quality."</p>
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-top: 1.5rem;">
                    <div style="width: 40px; height: 40px; background-color: var(--color-primary); border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; font-weight: 700;">H</div>
                    <div>
                        <h4 style="font-size: 0.95rem;">Helen Carter</h4>
                        <span style="font-size: 0.8rem; opacity: 0.6;">CEO, Bloom Cosmetics</span>
                    </div>
                </div>
            </div>
            
            <div class="card" style="display: flex; flex-direction: column; justify-content: space-between;">
                <p style="font-style: italic; opacity: 0.85;">"PackCraft custom RSC cartons saved our warehouse shipping team hours. Dimensions are exact down to millimeter, and board fits perfectly on standard transit pallets."</p>
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-top: 1.5rem;">
                    <div style="width: 40px; height: 40px; background-color: var(--color-primary); border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; font-weight: 700;">G</div>
                    <div>
                        <h4 style="font-size: 0.95rem;">Gary Vance</h4>
                        <span style="font-size: 0.8rem; opacity: 0.6;">Operations, Vance Logistics</span>
                    </div>
                </div>
            </div>
            
            <div class="card" style="display: flex; flex-direction: column; justify-content: space-between;">
                <p style="font-style: italic; opacity: 0.85;">"Outstanding sustainable boxes. Our customers really appreciate that we ship in natural kraft boxes that are fully recyclable and bio-degradable."</p>
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-top: 1.5rem;">
                    <div style="width: 40px; height: 40px; background-color: var(--color-primary); border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; font-weight: 700;">M</div>
                    <div>
                        <h4 style="font-size: 0.95rem;">Marcus Aureli</h4>
                        <span style="font-size: 0.8rem; opacity: 0.6;">Owner, Green Bites Bakery</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Lead Generation Call-to-Action -->
<section style="background-color: var(--color-bg-white); border-top: 1px solid var(--color-border-light); padding: 5rem 0;">
    <div class="container">
        <div style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%); border-radius: var(--border-radius); padding: 4rem; text-align: center; color: white;">
            <h2 style="color: white; font-family: var(--font-serif); font-size: 2.25rem; margin-bottom: 1rem;">Ready to Elevate Your Branding?</h2>
            <p style="opacity: 0.85; max-width: 600px; margin: 0 auto 2rem;">Submit custom dimensions or speak to our technical packaging consultants for custom wholesale pricing on bulk orders.</p>
            <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                <a href="{{ route('quote.form') }}" class="btn btn-gold">Request Custom Quote</a>
                <a href="{{ route('contact') }}" class="btn btn-outline" style="color: white; border-color: white;">Speak with Sales</a>
            </div>
        </div>
    </div>
</section>

@endsection

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "PackCraft Custom Packaging",
  "image": "http://127.0.0.1:8000/favicon.ico",
  "telephone": "+1 (555) 012-3456",
  "email": "info@packcraft.com",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "100 Packaging Way",
    "addressLocality": "Box City",
    "addressRegion": "CA",
    "postalCode": "90210",
    "addressCountry": "US"
  },
  "url": "http://127.0.0.1:8000/"
}
</script>
@endsection
