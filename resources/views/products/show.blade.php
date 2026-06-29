@extends('layouts.app')

@section('title', $product->name . ' | Customizer | PackCraft')
@section('meta_description', $product->description)

@section('content')

<section style="padding: 3rem 0;">
    <div class="container">
        
        <!-- Breadcrumbs -->
        <nav style="font-size: 0.85rem; opacity: 0.6; margin-bottom: 1.5rem;">
            <a href="{{ route('home') }}">Home</a> &gt; 
            <a href="{{ route('products.index') }}">Products</a> &gt; 
            <span>{{ $product->name }}</span>
        </nav>

        <div class="configurator-grid">
            
            <!-- Left Column: Live Visualizer SVG Canvas & Toggle -->
            <div class="canvas-container" style="height: auto; padding: 1.5rem; justify-content: flex-start; gap: 1rem;">
                
                <!-- View Toggle Buttons -->
                <div class="view-toggle-container" style="display: flex; gap: 0.5rem; width: 100%; background-color: var(--color-bg-light); padding: 0.25rem; border-radius: 8px; border: 1px solid var(--color-border-light);">
                    <button type="button" id="btn-view-3d" class="btn btn-gold" style="flex: 1; padding: 0.4rem 0.75rem; font-size: 0.8rem; border: none; border-radius: 6px; display: flex; align-items: center; justify-content: center; gap: 0.25rem; font-weight: 600; cursor: pointer;">
                        <i class="fa-solid fa-cube"></i> 3D Preview
                    </button>
                    <button type="button" id="btn-view-dieline" class="btn btn-outline" style="flex: 1; padding: 0.4rem 0.75rem; font-size: 0.8rem; border: none; border-radius: 6px; display: flex; align-items: center; justify-content: center; gap: 0.25rem; cursor: pointer; background: transparent; color: var(--color-text-dark);">
                        <i class="fa-solid fa-scissors"></i> 2D Dieline Template
                    </button>
                </div>
                
                <!-- Container wrapping both canvases -->
                <div style="width: 280px; height: 280px; position: relative; display: flex; align-items: center; justify-content: center; background-color: var(--color-bg-white);">
                    <!-- Scaling Isometric 3D SVG Box -->
                    <svg id="box-visual-canvas" width="280" height="280" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="box-svg" style="position: absolute; top: 0; left: 0;">
                        <!-- Definitions for gradients, filters, textures -->
                        <defs>
                            <!-- Kraft Base Colors -->
                            <linearGradient id="kraft-top" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#d9b48f"/>
                                <stop offset="100%" stop-color="#b88f68"/>
                            </linearGradient>
                            <linearGradient id="kraft-left" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#b88f68"/>
                                <stop offset="100%" stop-color="#805d3b"/>
                            </linearGradient>
                            <linearGradient id="kraft-right" x1="1" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#a37d57"/>
                                <stop offset="100%" stop-color="#6e4d2d"/>
                            </linearGradient>

                            <!-- Gold Foil Stamp Metallic Gradient -->
                            <linearGradient id="gold-foil-grad" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#c59f4e"/>
                                <stop offset="25%" stop-color="#fef1c9"/>
                                <stop offset="50%" stop-color="#b98a32"/>
                                <stop offset="75%" stop-color="#fef1c9"/>
                                <stop offset="100%" stop-color="#9a6b1f"/>
                            </linearGradient>

                            <!-- Die-cut Window Glass Interior Gradient -->
                            <linearGradient id="glass-grad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#12241e" stop-opacity="0.8"/>
                                <stop offset="100%" stop-color="#07100d" stop-opacity="0.95"/>
                            </linearGradient>

                            <!-- Die-cut Window Glossy Glare Gradient -->
                            <linearGradient id="gloss-grad" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#ffffff" stop-opacity="0.6"/>
                                <stop offset="35%" stop-color="#ffffff" stop-opacity="0.08"/>
                                <stop offset="100%" stop-color="#ffffff" stop-opacity="0"/>
                            </linearGradient>

                            <!-- Blurred Ground Shadow Filter -->
                            <filter id="shadow-blur" x="-20%" y="-20%" width="140%" height="140%">
                                <feGaussianBlur stdDeviation="3.5" />
                            </filter>

                            <!-- Cardboard Material Noise Texture Filter -->
                            <filter id="paper-texture" x="0%" y="0%" width="100%" height="100%">
                                <feTurbulence type="fractalNoise" baseFrequency="0.04" numOctaves="3" result="noise" />
                                <feColorMatrix type="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 0.08 0" />
                                <feComposite in="SourceGraphic" in2="noise" operator="over" />
                            </filter>
                        </defs>

                        <!-- 1. Ambient Drop Shadow (rendered behind the box) -->
                        <polygon id="box-shadow" points="50,55 80,45 50,35 20,45" fill="rgba(0,0,0,0.18)" filter="url(#shadow-blur)"/>

                        <!-- 2. Textured Box Face Group -->
                        <g filter="url(#paper-texture)">
                            <!-- Isometric Box Polygons -->
                            <polygon id="face-top" points="50,25 75,37.5 50,50 25,37.5" fill="url(#kraft-top)" stroke="rgba(0,0,0,0.12)" stroke-width="0.3"/>
                            <polygon id="face-left" points="25,37.5 50,50 50,80 25,67.5" fill="url(#kraft-left)" stroke="rgba(0,0,0,0.12)" stroke-width="0.3"/>
                            <polygon id="face-right" points="50,50 75,37.5 75,67.5 50,80" fill="url(#kraft-right)" stroke="rgba(0,0,0,0.12)" stroke-width="0.3"/>

                            <!-- Structural Creases & Flap Lines (Dashed fold markings) -->
                            <path id="crease-top-fold" d="M 25,37.5 L 75,37.5" stroke="rgba(255,255,255,0.2)" stroke-width="0.35" stroke-dasharray="1 1" fill="none" />
                            <path id="crease-left-tuck" d="M 25,37.5 L 50,50" stroke="rgba(0,0,0,0.1)" stroke-width="0.3" stroke-dasharray="0.5 0.5" fill="none" />
                            <path id="crease-right-tuck" d="M 75,37.5 L 50,50" stroke="rgba(0,0,0,0.1)" stroke-width="0.3" stroke-dasharray="0.5 0.5" fill="none" />
                        </g>

                        <!-- 3. Stylized Printed Logo Group (Rendered on top face) -->
                        <g id="logo-group" opacity="0">
                            <polygon id="logo-outer" points="50,30 60,35 50,40 40,35" fill="none" stroke="#1e382b" stroke-width="0.3" />
                            <polygon id="logo-inner" points="50,32 57,35 50,38 43,35" fill="none" stroke="#1e382b" stroke-width="0.15" />
                            <polygon id="logo-center" points="50,33.5 53,35 50,36.5 47,35" fill="#1e382b" />
                        </g>

                        <!-- 4. Gold Foil stamp (Rendered on front-left face) -->
                        <polygon id="foil-overlay" points="35,50 42,53 42,68 35,65" fill="url(#gold-foil-grad)" opacity="0" stroke="rgba(212,175,55,0.4)" stroke-width="0.25"/>

                        <!-- 5. Interactive Die-Cut Window (Rendered on front-right face) -->
                        <g id="window-group" opacity="0">
                            <polygon id="window-overlay" points="58,52 68,47 68,62 58,67" fill="url(#glass-grad)" stroke="rgba(255,255,255,0.35)" stroke-width="0.3" />
                            <polygon id="window-gloss" points="59,51.5 64,49 61,64 59,62" fill="url(#gloss-grad)" />
                        </g>

                        <!-- 6. Technical Dimension Callouts -->
                        <g id="dimensions-group" stroke-linecap="round">
                            <!-- Length Line (L) -->
                            <path id="dim-length-line" d="M 22,69 L 47,82.5" stroke="#78909c" stroke-width="0.3" />
                            <path id="dim-length-tick-start" d="M 20,68 L 24,70" stroke="#78909c" stroke-width="0.3" />
                            <path id="dim-length-tick-end" d="M 45,81.5 L 49,83.5" stroke="#78909c" stroke-width="0.3" />
                            <text id="dim-length-text" x="33" y="78.5" fill="var(--color-primary)" font-size="2.6" font-family="Courier New, monospace" font-weight="bold" text-anchor="middle">L: 20 cm</text>

                            <!-- Width Line (W) -->
                            <path id="dim-width-line" d="M 53,82.5 L 78,69" stroke="#78909c" stroke-width="0.3" />
                            <path id="dim-width-tick-start" d="M 51,83.5 L 55,81.5" stroke="#78909c" stroke-width="0.3" />
                            <path id="dim-width-tick-end" d="M 76,70 L 80,68" stroke="#78909c" stroke-width="0.3" />
                            <text id="dim-width-text" x="67" y="78.5" fill="var(--color-primary)" font-size="2.6" font-family="Courier New, monospace" font-weight="bold" text-anchor="middle">W: 15 cm</text>

                            <!-- Height Line (H) -->
                            <path id="dim-height-line" d="M 17,29.5 L 17,59" stroke="#78909c" stroke-width="0.3" />
                            <path id="dim-height-tick-start" d="M 15,29.5 L 19,29.5" stroke="#78909c" stroke-width="0.3" />
                            <path id="dim-height-tick-end" d="M 15,59 L 19,59" stroke="#78909c" stroke-width="0.3" />
                            <text id="dim-height-text" x="9" y="45.5" fill="var(--color-primary)" font-size="2.6" font-family="Courier New, monospace" font-weight="bold" text-anchor="middle">H: 8 cm</text>
                        </g>
                    </svg>

                    <!-- Scaling 2D Dieline Canvas (Industrial drawing) -->
                    <svg id="box-dieline-canvas" width="280" height="280" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="box-svg" style="position: absolute; top: 0; left: 0; display: none; border: 1px dashed var(--color-border-light); border-radius: 4px; background-color: #fafafa;">
                        <!-- Outer profile cuts (red) -->
                        <path id="dieline-cut" fill="none" stroke="#d32f2f" stroke-width="0.35" />
                        
                        <!-- Internal fold creases (blue) -->
                        <path id="dieline-crease" fill="none" stroke="#1976d2" stroke-width="0.35" stroke-dasharray="0.8 0.8" />

                        <!-- Window cutout (dashed red) -->
                        <rect id="dieline-window" fill="none" stroke="#d32f2f" stroke-width="0.35" stroke-dasharray="0.8 0.5" rx="1" ry="1" opacity="0" />

                        <!-- Brand Logo Print representation -->
                        <g id="dieline-logo" opacity="0">
                            <!-- Outer shield logo stamp -->
                            <polygon id="dieline-logo-poly" points="50,28 53,31 50,34 47,31" fill="none" stroke="#2e1b0e" stroke-width="0.2" />
                            <text x="50" y="32" font-size="0.8" font-family="sans-serif" text-anchor="middle" fill="#2e1b0e" font-weight="bold">LOGO</text>
                        </g>

                        <!-- Engineering dimensions annotations -->
                        <g id="dieline-dimensions">
                            <!-- Length Indicator -->
                            <line id="dl-len-line" stroke="#607d8b" stroke-width="0.15" />
                            <line id="dl-len-tick-start" stroke="#607d8b" stroke-width="0.15" />
                            <line id="dl-len-tick-end" stroke="#607d8b" stroke-width="0.15" />
                            <text id="dl-len-text" fill="#455a64" font-size="2.2" font-family="Courier New, monospace" font-weight="bold" text-anchor="middle">L: 20cm</text>
                            
                            <!-- Width Indicator -->
                            <line id="dl-wid-line" stroke="#607d8b" stroke-width="0.15" />
                            <line id="dl-wid-tick-start" stroke="#607d8b" stroke-width="0.15" />
                            <line id="dl-wid-tick-end" stroke="#607d8b" stroke-width="0.15" />
                            <text id="dl-wid-text" fill="#455a64" font-size="2.2" font-family="Courier New, monospace" font-weight="bold" text-anchor="middle">W: 15cm</text>

                            <!-- Height Indicator -->
                            <line id="dl-hgt-line" stroke="#607d8b" stroke-width="0.15" />
                            <line id="dl-hgt-tick-start" stroke="#607d8b" stroke-width="0.15" />
                            <line id="dl-hgt-tick-end" stroke="#607d8b" stroke-width="0.15" />
                            <text id="dl-hgt-text" fill="#455a64" font-size="2.2" font-family="Courier New, monospace" font-weight="bold" text-anchor="middle">H: 8cm</text>
                        </g>

                        <!-- Micro-Legend -->
                        <g transform="translate(3, 94)" font-size="1.2" font-family="Courier New, monospace" font-weight="bold">
                            <line x1="0" y1="1" x2="6" y2="1" stroke="#d32f2f" stroke-width="0.5" />
                            <text x="8" y="2.2" fill="#d32f2f" font-size="1.6">Cut</text>
                            
                            <line x1="25" y1="1" x2="31" y2="1" stroke="#1976d2" stroke-width="0.5" stroke-dasharray="0.8 0.8" />
                            <text x="33" y="2.2" fill="#1976d2" font-size="1.6">Fold</text>
                        </g>
                    </svg>
                </div>

                <div style="margin-top: 0.5rem; text-align: center; font-size: 0.8rem; opacity: 0.6;">
                    <span>Adjust sliders in the configuration panel to update in real-time.</span>
                </div>

                <!-- Export Dieline Trigger Button -->
                <button type="button" id="btn-download-dieline" class="btn btn-outline" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem; font-size: 0.85rem; padding: 0.55rem 1rem; border-radius: 6px; cursor: pointer; border-color: var(--color-border-dark);">
                    <i class="fa-solid fa-file-arrow-down" style="color: var(--color-accent);"></i> 
                    <span>Export CAD Dieline (SVG)</span>
                </button>
            </div>

            <!-- Right Column: Configurator Editor -->
            <div class="editor-container">
                <div>
                    <h1 style="font-family: var(--font-serif); font-size: 2.25rem; margin-bottom: 0.5rem; color: var(--color-primary);">{{ $product->name }}</h1>
                    <p style="opacity: 0.8; margin-bottom: 1.5rem;">{{ $product->description }}</p>
                </div>

                <!-- Product Specifications Checklist -->
                <div style="background-color: var(--color-bg-white); border: 1px solid var(--color-border-light); border-radius: var(--border-radius); padding: 1.5rem;">
                    <h3 style="font-size: 1rem; margin-bottom: 1rem; color: var(--color-primary);">Default Specifications</h3>
                    <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.9rem; opacity: 0.8;">
                        @if($product->features)
                            @foreach($product->features as $feature)
                                <li><i class="fa-solid fa-circle-check" style="color: var(--color-success); margin-right: 0.5rem;"></i> {{ $feature }}</li>
                            @endforeach
                        @endif
                        <li><i class="fa-solid fa-circle-check" style="color: var(--color-success); margin-right: 0.5rem;"></i> Min Quantity: {{ $product->min_qty }} units</li>
                    </ul>
                </div>

                <!-- Customizer Interactive Form -->
                <form id="customizer-form" action="{{ route('checkout') }}" method="GET">
                    <input type="hidden" name="product_slug" value="{{ $product->slug }}">
                    
                    <!-- 1. Dimensions Settings -->
                    <div style="margin-bottom: 2rem;">
                        <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; border-bottom: 1px solid var(--color-border-light); padding-bottom: 0.5rem;">1. Configure Box Dimensions</h3>
                        
                        <div class="form-group">
                            <div class="flex flex-between" style="margin-bottom: 0.25rem;">
                                <label for="length">Length (L) - longer side: <span id="val-length">20</span> cm</label>
                            </div>
                            <input type="range" id="length" name="length" min="10" max="60" value="20" class="form-control" style="padding: 0; cursor: pointer;">
                        </div>

                        <div class="form-group">
                            <div class="flex flex-between" style="margin-bottom: 0.25rem;">
                                <label for="width">Width (W) - shorter side: <span id="val-width">15</span> cm</label>
                            </div>
                            <input type="range" id="width" name="width" min="10" max="50" value="15" class="form-control" style="padding: 0; cursor: pointer;">
                        </div>

                        <div class="form-group">
                            <div class="flex flex-between" style="margin-bottom: 0.25rem;">
                                <label for="height">Height (H) - depth: <span id="val-height">8</span> cm</label>
                            </div>
                            <input type="range" id="height" name="height" min="5" max="40" value="8" class="form-control" style="padding: 0; cursor: pointer;">
                        </div>
                    </div>

                    <!-- 2. Material Select -->
                    <div style="margin-bottom: 2rem;">
                        <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; border-bottom: 1px solid var(--color-border-light); padding-bottom: 0.5rem;">2. Choose Box Material</h3>
                        <div class="form-group">
                            <select id="material" name="material" class="form-control">
                                <option value="Kraft Paper">Kraft Paper (Recycled, Brown Organic Look)</option>
                                <option value="Cardboard" selected>White Cardboard (Premium Printing Surface)</option>
                                <option value="Corrugated Board">Corrugated Board (Thick layers, Shipping-ready)</option>
                                <option value="Rigid Board">Rigid Board (Ultra luxury magnetic hampers)</option>
                            </select>
                        </div>
                    </div>

                    <!-- 3. Finishes Checkbox buttons -->
                    <div style="margin-bottom: 2rem;">
                        <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; border-bottom: 1px solid var(--color-border-light); padding-bottom: 0.5rem;">3. Luxury Finishes & Extras</h3>
                        <div class="checkbox-group">
                            <label class="checkbox-btn" id="lbl-printing">
                                <input type="checkbox" id="printing_required" name="printing_required" value="1" style="display: none;">
                                <i class="fa-regular fa-square" id="icon-printing"></i>
                                <span>Logo Printing</span>
                            </label>
                            <label class="checkbox-btn" id="lbl-lamination">
                                <input type="checkbox" id="lamination" name="lamination" value="1" style="display: none;">
                                <i class="fa-regular fa-square" id="icon-lamination"></i>
                                <span>Matte Lamination</span>
                            </label>
                            <label class="checkbox-btn" id="lbl-embossing">
                                <input type="checkbox" id="embossing" name="embossing" value="1" style="display: none;">
                                <i class="fa-regular fa-square" id="icon-embossing"></i>
                                <span>Embossing</span>
                            </label>
                            <label class="checkbox-btn" id="lbl-foil">
                                <input type="checkbox" id="foil_stamping" name="foil_stamping" value="1" style="display: none;">
                                <i class="fa-regular fa-square" id="icon-foil"></i>
                                <span>Gold Foil Stamp</span>
                            </label>
                            <label class="checkbox-btn" id="lbl-window">
                                <input type="checkbox" id="window_cutout" name="window_cutout" value="1" style="display: none;">
                                <i class="fa-regular fa-square" id="icon-window"></i>
                                <span>Window Cut</span>
                            </label>
                        </div>
                    </div>

                    <!-- 4. Quantity selection -->
                    <div style="margin-bottom: 2rem;">
                        <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; border-bottom: 1px solid var(--color-border-light); padding-bottom: 0.5rem;">4. Order Quantity</h3>
                        <div style="display: flex; gap: 0.75rem; margin-bottom: 1rem; flex-wrap: wrap;">
                            <button type="button" class="btn btn-outline qty-preset" data-qty="100" style="padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.85rem;">100</button>
                            <button type="button" class="btn btn-outline qty-preset" data-qty="250" style="padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.85rem;">250</button>
                            <button type="button" class="btn btn-outline qty-preset active" data-qty="500" style="padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.85rem;">500</button>
                            <button type="button" class="btn btn-outline qty-preset" data-qty="1000" style="padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.85rem;">1000</button>
                        </div>
                        <div class="form-group" style="display: flex; align-items: center; gap: 1rem;">
                            <label for="quantity" style="white-space: nowrap; margin-bottom:0;">Custom Quantity:</label>
                            <input type="number" id="quantity" name="quantity" min="100" value="500" class="form-control" style="width: 120px;">
                        </div>
                    </div>

                    <!-- Real-Time Pricing Summary Board -->
                    <div class="pricing-board">
                        <div class="pricing-item">
                            <span>Box Unit Price:</span>
                            <span>$<span id="price-unit">0.00</span></span>
                        </div>
                        <div class="pricing-item">
                            <span>Quantity Volume Discount:</span>
                            <span><span id="price-discount">0</span>% Off</span>
                        </div>
                        <div class="pricing-item">
                            <span>Setup/Tooling Cost:</span>
                            <span style="color: var(--color-accent); font-weight: 600;">FREE</span>
                        </div>
                        <div class="pricing-item pricing-total">
                            <span>Estimated Total:</span>
                            <span>$<span id="price-total">0.00</span></span>
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1.5rem;">
                        <button type="submit" class="btn btn-gold"><i class="fa-solid fa-cart-shopping" style="margin-right: 0.5rem;"></i> Order Box</button>
                        <a href="{{ route('quote.form') }}" class="btn btn-outline"><i class="fa-regular fa-envelope" style="margin-right: 0.5rem;"></i> Custom RFQ</a>
                    </div>
                </form>

            </div>
        </div>

    </div>
</section>

<!-- Customizer Interactive JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Elements
    const lengthInput = document.getElementById('length');
    const widthInput = document.getElementById('width');
    const heightInput = document.getElementById('height');
    const materialSelect = document.getElementById('material');
    const quantityInput = document.getElementById('quantity');
    const qtyPresets = document.querySelectorAll('.qty-preset');

    const valLength = document.getElementById('val-length');
    const valWidth = document.getElementById('val-width');
    const valHeight = document.getElementById('val-height');

    const priceUnitSpan = document.getElementById('price-unit');
    const priceDiscountSpan = document.getElementById('price-discount');
    const priceTotalSpan = document.getElementById('price-total');

    // Checkboxes
    const finishes = [
        { id: 'printing_required', lbl: 'lbl-printing', icon: 'icon-printing' },
        { id: 'lamination', lbl: 'lbl-lamination', icon: 'icon-lamination' },
        { id: 'embossing', lbl: 'lbl-embossing', icon: 'icon-embossing' },
        { id: 'foil_stamping', lbl: 'lbl-foil', icon: 'icon-foil' },
        { id: 'window_cutout', lbl: 'lbl-window', icon: 'icon-window' }
    ];

    // Toggle view buttons & canvases
    const btnView3d = document.getElementById('btn-view-3d');
    const btnViewDieline = document.getElementById('btn-view-dieline');
    const visualCanvas = document.getElementById('box-visual-canvas');
    const dielineCanvas = document.getElementById('box-dieline-canvas');
    const btnDownloadDieline = document.getElementById('btn-download-dieline');

    // 3D SVG elements
    const boxShadow = document.getElementById('box-shadow');
    const faceTop = document.getElementById('face-top');
    const faceLeft = document.getElementById('face-left');
    const faceRight = document.getElementById('face-right');
    
    const creaseTopFold = document.getElementById('crease-top-fold');
    const creaseLeftTuck = document.getElementById('crease-left-tuck');
    const creaseRightTuck = document.getElementById('crease-right-tuck');

    const logoGroup = document.getElementById('logo-group');
    const logoOuter = document.getElementById('logo-outer');
    const logoInner = document.getElementById('logo-inner');
    const logoCenter = document.getElementById('logo-center');

    const foilOverlay = document.getElementById('foil-overlay');
    
    const windowGroup = document.getElementById('window-group');
    const windowOverlay = document.getElementById('window-overlay');
    const windowGloss = document.getElementById('window-gloss');

    // 3D Dimension lines & text elements
    const dimLengthLine = document.getElementById('dim-length-line');
    const dimLengthTickStart = document.getElementById('dim-length-tick-start');
    const dimLengthTickEnd = document.getElementById('dim-length-tick-end');
    const dimLengthText = document.getElementById('dim-length-text');

    const dimWidthLine = document.getElementById('dim-width-line');
    const dimWidthTickStart = document.getElementById('dim-width-tick-start');
    const dimWidthTickEnd = document.getElementById('dim-width-tick-end');
    const dimWidthText = document.getElementById('dim-width-text');

    const dimHeightLine = document.getElementById('dim-height-line');
    const dimHeightTickStart = document.getElementById('dim-height-tick-start');
    const dimHeightTickEnd = document.getElementById('dim-height-tick-end');
    const dimHeightText = document.getElementById('dim-height-text');

    // 2D Dieline elements
    const dielineCut = document.getElementById('dieline-cut');
    const dielineCrease = document.getElementById('dieline-crease');
    const dielineWindow = document.getElementById('dieline-window');
    const dielineLogo = document.getElementById('dieline-logo');
    const dielineLogoPoly = document.getElementById('dieline-logo-poly');

    const dlLenLine = document.getElementById('dl-len-line');
    const dlLenTickStart = document.getElementById('dl-len-tick-start');
    const dlLenTickEnd = document.getElementById('dl-len-tick-end');
    const dlLenText = document.getElementById('dl-len-text');

    const dlWidLine = document.getElementById('dl-wid-line');
    const dlWidTickStart = document.getElementById('dl-wid-tick-start');
    const dlWidTickEnd = document.getElementById('dl-wid-tick-end');
    const dlWidText = document.getElementById('dl-wid-text');

    const dlHgtLine = document.getElementById('dl-hgt-line');
    const dlHgtTickStart = document.getElementById('dl-hgt-tick-start');
    const dlHgtTickEnd = document.getElementById('dl-hgt-tick-end');
    const dlHgtText = document.getElementById('dl-hgt-text');

    // Industrial Specs Elements
    const specMatName = document.getElementById('spec-mat-name');
    const specMatThick = document.getElementById('spec-mat-thick');
    const specMatGrade = document.getElementById('spec-mat-grade');
    const specMfgFoil = document.getElementById('spec-mfg-foil');
    const specMfgWindow = document.getElementById('spec-mfg-window');

    const basePrice = {{ $product->base_price }};

    // 2. Setup Checkbox Visual states
    finishes.forEach(item => {
        const checkbox = document.getElementById(item.id);
        const label = document.getElementById(item.lbl);
        const icon = document.getElementById(item.icon);

        label.addEventListener('click', (e) => {
            e.preventDefault();
            checkbox.checked = !checkbox.checked;
            
            if (checkbox.checked) {
                label.classList.add('active');
                icon.className = 'fa-regular fa-square-check';
            } else {
                label.classList.remove('active');
                icon.className = 'fa-regular fa-square';
            }
            updateConfigurator();
        });
    });

    // 3. Setup Qty Presets
    qtyPresets.forEach(btn => {
        btn.addEventListener('click', () => {
            qtyPresets.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            quantityInput.value = btn.dataset.qty;
            updateConfigurator();
        });
    });

    quantityInput.addEventListener('input', () => {
        qtyPresets.forEach(b => {
            if (b.dataset.qty === quantityInput.value) {
                b.classList.add('active');
            } else {
                b.classList.remove('active');
            }
        });
        updateConfigurator();
    });

    // 4. Sliders Event Listeners
    [lengthInput, widthInput, heightInput, materialSelect].forEach(input => {
        input.addEventListener('input', updateConfigurator);
    });

    // 5. Main Configurator function
    function updateConfigurator() {
        const L = parseFloat(lengthInput.value);
        const W = parseFloat(widthInput.value);
        const H = parseFloat(heightInput.value);
        const qty = parseInt(quantityInput.value) || 100;
        const material = materialSelect.value;

        // Update Text displays
        valLength.textContent = L;
        valWidth.textContent = W;
        valHeight.textContent = H;

        // 6. SVG Render Updates (Interactive scaling)
        // Convert input numbers to normalized scale mapping
        const lScale = 15 + (L - 10) * (20 / 50); // maps 10-60 to 15-35
        const wScale = 12 + (W - 10) * (18 / 40); // maps 10-50 to 12-30
        const hScale = 10 + (H - 5) * (20 / 35);   // maps 5-40 to 10-30

        const hOffset = hScale;

        // Ground shadow coordinates
        boxShadow.setAttribute('points', `50,${50 + 5} ${50 + lScale + 4},${50 - wScale/2 + 2} 50,${50 - wScale - 4} ${50 - lScale - 4},${50 - wScale/2 + 2}`);

        // Face TOP coordinates
        const top_pt0 = `50,${50 - hOffset}`;
        const top_pt1 = `${50 + lScale},${50 - hOffset - wScale/2}`;
        const top_pt2 = `50,${50 - hOffset - wScale}`;
        const top_pt3 = `${50 - lScale},${50 - hOffset - wScale/2}`;
        faceTop.setAttribute('points', `${top_pt0} ${top_pt1} ${top_pt2} ${top_pt3}`);

        // Face LEFT coordinates
        const left_pt0 = `${50 - lScale},${50 - hOffset - wScale/2}`;
        const left_pt1 = `50,${50 - hOffset}`;
        const left_pt2 = `50,50`;
        const left_pt3 = `${50 - lScale},${50 - wScale/2}`;
        faceLeft.setAttribute('points', `${left_pt0} ${left_pt1} ${left_pt2} ${left_pt3}`);

        // Face RIGHT coordinates
        const right_pt0 = `50,${50 - hOffset}`;
        const right_pt1 = `${50 + lScale},${50 - hOffset - wScale/2}`;
        const right_pt2 = `${50 + lScale},${50 - wScale/2}`;
        const right_pt3 = `50,50`;
        faceRight.setAttribute('points', `${right_pt0} ${right_pt1} ${right_pt2} ${right_pt3}`);

        // Crease overlay paths
        creaseTopFold.setAttribute('d', `M ${50 - lScale},${50 - hOffset - wScale/2} L ${50 + lScale},${50 - hOffset - wScale/2}`);
        creaseLeftTuck.setAttribute('d', `M ${50 - lScale},${50 - hOffset - wScale/2} L 50,${50 - hOffset}`);
        creaseRightTuck.setAttribute('d', `M 50,${50 - hOffset} L ${50 + lScale},${50 - hOffset - wScale/2}`);

        // 7. Render Material Palette Colors in SVG
        let svgDefColors = '';
        switch (material) {
            case 'Kraft Paper':
                svgDefColors = { top: ['#d9b48f', '#b88f68'], left: ['#b88f68', '#805d3b'], right: ['#a37d57', '#6e4d2d'] };
                break;
            case 'Cardboard':
                svgDefColors = { top: ['#fbfcfb', '#e2e6e1'], left: ['#e2e6e1', '#b2b8b0'], right: ['#d4dad2', '#9ea49b'] };
                break;
            case 'Corrugated Board':
                svgDefColors = { top: ['#c39c73', '#a37c53'], left: ['#a37c53', '#73512b'], right: ['#8c6841', '#5e3f1d'] };
                break;
            case 'Rigid Board':
                svgDefColors = { top: ['#424845', '#2a2e2c'], left: ['#2a2e2c', '#151716'], right: ['#1d211f', '#0c0e0d'] };
                break;
        }

        // Apply gradients
        updateSVGGradient('kraft-top', svgDefColors.top[0], svgDefColors.top[1]);
        updateSVGGradient('kraft-left', svgDefColors.left[0], svgDefColors.left[1]);
        updateSVGGradient('kraft-right', svgDefColors.right[0], svgDefColors.right[1]);

        // Toggle visual overlays
        const logoChecked = document.getElementById('printing_required').checked;
        const foilChecked = document.getElementById('foil_stamping').checked;
        const windowChecked = document.getElementById('window_cutout').checked;

        // Brand Logo Printing updates
        if (logoChecked) {
            const cy = 50 - hOffset - wScale/2;
            logoOuter.setAttribute('points', `50,${cy - wScale/4} ${50 + lScale/4},${cy} 50,${cy + wScale/4} ${50 - lScale/4},${cy}`);
            logoInner.setAttribute('points', `50,${cy - wScale/6} ${50 + lScale/6},${cy} 50,${cy + wScale/6} ${50 - lScale/6},${cy}`);
            logoCenter.setAttribute('points', `50,${cy - wScale/12} ${50 + lScale/12},${cy} 50,${cy + wScale/12} ${50 - lScale/12},${cy}`);
            
            // Adapt ink color to material texture
            let logoColor = '#1e382b';
            if (material === 'Kraft Paper') logoColor = '#2b170c';
            else if (material === 'Corrugated Board') logoColor = '#1c120a';
            else if (material === 'Rigid Board') logoColor = 'url(#gold-foil-grad)';

            logoOuter.setAttribute('stroke', logoColor);
            logoInner.setAttribute('stroke', logoColor);
            logoCenter.setAttribute('fill', logoColor);
            logoGroup.setAttribute('opacity', '0.8');
        } else {
            logoGroup.setAttribute('opacity', '0');
        }

        // Gold Foil Stamping updates
        if (foilChecked) {
            foilOverlay.setAttribute('points', `${50 - lScale * 0.6},${50 - hOffset * 0.65 - wScale * 0.3} ${50 - lScale * 0.3},${50 - hOffset * 0.65 - wScale * 0.15} ${50 - lScale * 0.3},${50 - hOffset * 0.35 - wScale * 0.15} ${50 - lScale * 0.6},${50 - hOffset * 0.35 - wScale * 0.3}`);
            foilOverlay.setAttribute('opacity', '0.9');
        } else {
            foilOverlay.setAttribute('opacity', '0');
        }

        // Die-cut Window updates
        if (windowChecked) {
            windowOverlay.setAttribute('points', `${50 + lScale * 0.3},${50 - hOffset * 0.7 - wScale * 0.15} ${50 + lScale * 0.7},${50 - hOffset * 0.7 - wScale * 0.35} ${50 + lScale * 0.7},${50 - hOffset * 0.3 - wScale * 0.35} ${50 + lScale * 0.3},${50 - hOffset * 0.3 - wScale * 0.15}`);
            windowGloss.setAttribute('points', `${50 + lScale * 0.3},${50 - hOffset * 0.7 - wScale * 0.15} ${50 + lScale * 0.5},${50 - hOffset * 0.7 - wScale * 0.25} ${50 + lScale * 0.4},${50 - hOffset * 0.3 - wScale * 0.2} ${50 + lScale * 0.3},${50 - hOffset * 0.3 - wScale * 0.15}`);
            windowGroup.setAttribute('opacity', '1');
        } else {
            windowGroup.setAttribute('opacity', '0');
        }

        // Technical Dimension Indicators updates
        // 1. Length Line & Text
        dimLengthLine.setAttribute('d', `M ${50 - lScale - 3},${50 - wScale/2 + 6} L ${50 - 3},${50 + 6}`);
        dimLengthTickStart.setAttribute('d', `M ${50 - lScale - 5},${50 - wScale/2 + 5} L ${50 - lScale - 1},${50 - wScale/2 + 7}`);
        dimLengthTickEnd.setAttribute('d', `M ${50 - 5},${50 + 5} L ${50 - 1},${50 + 7}`);
        dimLengthText.setAttribute('x', 50 - lScale/2 - 3);
        dimLengthText.setAttribute('y', 50 - wScale/4 + 11.5);
        dimLengthText.textContent = `L: ${L} cm`;

        // 2. Width Line & Text
        dimWidthLine.setAttribute('d', `M ${50 + 3},${50 + 6} L ${50 + lScale + 3},${50 - wScale/2 + 6}`);
        dimWidthTickStart.setAttribute('d', `M ${50 + 1},${50 + 7} L ${50 + 5},${50 + 5}`);
        dimWidthTickEnd.setAttribute('d', `M ${50 + lScale + 1},${50 - wScale/2 + 7} L ${50 + lScale + 5},${50 - wScale/2 + 5}`);
        dimWidthText.setAttribute('x', 50 + lScale/2 + 3);
        dimWidthText.setAttribute('y', 50 - wScale/4 + 11.5);
        dimWidthText.textContent = `W: ${W} cm`;

        // 3. Height Line & Text
        dimHeightLine.setAttribute('d', `M ${50 - lScale - 8},${50 - hOffset - wScale/2} L ${50 - lScale - 8},${50 - wScale/2}`);
        dimHeightTickStart.setAttribute('d', `M ${50 - lScale - 10},${50 - hOffset - wScale/2} L ${50 - lScale - 6},${50 - hOffset - wScale/2}`);
        dimHeightTickEnd.setAttribute('d', `M ${50 - lScale - 10},${50 - wScale/2} L ${50 - lScale - 6},${50 - wScale/2}`);
        dimHeightText.setAttribute('x', 50 - lScale - 14);
        dimHeightText.setAttribute('y', 50 - hOffset/2 - wScale/2 + 1);
        dimHeightText.textContent = `H: ${H} cm`;

        // 7.5. 2D Dieline Drawing Calculation
        const totalW = L + 2 * H;
        const totalH = 2 * W + 2 * H;
        const s_dl = 70 / Math.max(totalW, totalH);

        const L_s = L * s_dl;
        const W_s = W * s_dl;
        const H_s = H * s_dl;

        // Bottom panel boundaries (centered at 50, 50)
        const x1 = 50 - L_s/2;
        const x2 = 50 + L_s/2;
        const y1 = 50 - W_s/2;
        const y2 = 50 + W_s/2;

        const bk_y1 = y1 - H_s;
        const bk_y2 = y1;
        const lid_y1 = bk_y1 - W_s;
        const lid_y2 = bk_y1;
        
        const ff_y1 = y2;
        const ff_y2 = y2 + H_s;

        // Crease Lines (dashed blue)
        const creasePath = `
            M ${x1},${y1} L ${x1},${y2} 
            M ${x2},${y1} L ${x2},${y2} 
            M ${x1},${y1} L ${x2},${y1} 
            M ${x1},${y2} L ${x2},${y2} 
            M ${x1},${bk_y1} L ${x2},${bk_y1} 
            M ${x1},${lid_y1} L ${x2},${lid_y1}
        `;
        dielineCrease.setAttribute('d', creasePath);

        // Cut Profile (solid red)
        const cutPath = `
            M ${x1 + L_s*0.08},${lid_y1 - H_s*0.3} 
            L ${x2 - L_s*0.08},${lid_y1 - H_s*0.3} 
            L ${x2},${lid_y1} 
            L ${x2 + H_s*0.4},${lid_y1 + W_s*0.25} 
            L ${x2 + H_s*0.4},${lid_y2 - W_s*0.25} 
            L ${x2},${lid_y2} 
            L ${x2},${y1} 
            L ${x2 + H_s},${y1} 
            L ${x2 + H_s},${y2} 
            L ${x2},${y2} 
            L ${x2},${ff_y2} 
            L ${x2 - L_s*0.08},${ff_y2 + H_s*0.3} 
            L ${x1 + L_s*0.08},${ff_y2 + H_s*0.3} 
            L ${x1},${ff_y2} 
            L ${x1},${y2} 
            L ${x1 - H_s},${y2} 
            L ${x1 - H_s},${y1} 
            L ${x1},${y1} 
            L ${x1},${lid_y2} 
            L ${x1 - H_s*0.4},${lid_y2 - W_s*0.25} 
            L ${x1 - H_s*0.4},${lid_y1 + W_s*0.25} 
            L ${x1},${lid_y1} 
            Z
        `;
        dielineCut.setAttribute('d', cutPath);

        // Dieline Window placement
        if (windowChecked) {
            dielineWindow.setAttribute('x', 50 - L_s*0.2);
            dielineWindow.setAttribute('y', y2 + H_s*0.25);
            dielineWindow.setAttribute('width', L_s*0.4);
            dielineWindow.setAttribute('height', H_s*0.5);
            dielineWindow.setAttribute('opacity', '1');
        } else {
            dielineWindow.setAttribute('opacity', '0');
        }

        // Dieline Logo placement
        if (logoChecked) {
            const cy = lid_y1 + W_s/2;
            dielineLogoPoly.setAttribute('points', `50,${cy - W_s*0.12} ${50 + L_s*0.08},${cy} 50,${cy + W_s*0.12} ${50 - L_s*0.08},${cy}`);
            
            const txt = dielineLogo.querySelector('text');
            txt.setAttribute('x', 50);
            txt.setAttribute('y', cy + 0.6);
            txt.setAttribute('font-size', Math.max(1.1, W_s*0.06));

            let logoColor = '#1e382b';
            if (material === 'Kraft Paper') logoColor = '#2b170c';
            else if (material === 'Corrugated Board') logoColor = '#1c120a';
            else if (material === 'Rigid Board') logoColor = '#c59f4e';

            dielineLogoPoly.setAttribute('stroke', logoColor);
            txt.setAttribute('fill', logoColor);
            dielineLogo.setAttribute('opacity', '0.7');
        } else {
            dielineLogo.setAttribute('opacity', '0');
        }

        // Dieline Dimensions Annotations
        // 1. Length indicator (bottom panel horizontal)
        dlLenLine.setAttribute('d', `M ${x1 + 1},${50} L ${x2 - 1},${50}`);
        dlLenTickStart.setAttribute('d', `M ${x1 + 1},${48} L ${x1 + 1},${52}`);
        dlLenTickEnd.setAttribute('d', `M ${x2 - 1},${48} L ${x2 - 1},${52}`);
        dlLenText.setAttribute('x', 50);
        dlLenText.setAttribute('y', 47);
        dlLenText.textContent = `${L} cm`;

        // 2. Width indicator (bottom panel vertical)
        dlWidLine.setAttribute('d', `M ${50},${y1 + 1} L ${50},${y2 - 1}`);
        dlWidTickStart.setAttribute('d', `M ${48},${y1 + 1} L ${52},${y1 + 1}`);
        dlWidTickEnd.setAttribute('d', `M ${48},${y2 - 1} L ${52},${y2 - 1}`);
        dlWidText.setAttribute('x', 52);
        dlWidText.setAttribute('y', 50.5);
        dlWidText.textContent = `${W} cm`;

        // 3. Height indicator (side panel horizontal)
        dlHgtLine.setAttribute('d', `M ${x2 + 1},${50} L ${x2 + H_s - 1},${50}`);
        dlHgtTickStart.setAttribute('d', `M ${x2 + 1},${48} L ${x2 + 1},${52}`);
        dlHgtTickEnd.setAttribute('d', `M ${x2 + H_s - 1},${48} L ${x2 + H_s - 1},${52}`);
        dlHgtText.setAttribute('x', x2 + H_s/2);
        dlHgtText.setAttribute('y', 47);
        dlHgtText.textContent = `${H} cm`;

        // 8. Update Industrial Tech Specs Sheet
        specMatName.textContent = material;
        
        let thicknessText = '';
        let gradeText = '';
        switch (material) {
            case 'Kraft Paper':
                thicknessText = '18 pt (0.45 mm)';
                gradeText = 'Natural Recycled Kraft Linerboard';
                break;
            case 'Cardboard':
                thicknessText = '24 pt (0.60 mm)';
                gradeText = 'Premium Solid Bleached Sulfate (SBS)';
                break;
            case 'Corrugated Board':
                thicknessText = '120 pt (3.0 mm)';
                gradeText = 'Single Wall ECT-32 E-Flute';
                break;
            case 'Rigid Board':
                thicknessText = '80 pt (2.0 mm)';
                gradeText = 'Luxury Greyboard / Chipboard core';
                break;
        }
        specMatThick.textContent = thicknessText;
        specMatGrade.textContent = gradeText;

        specMfgFoil.textContent = foilChecked ? 'Reflective Gold Foil Stamp' : 'None';
        specMfgWindow.textContent = windowChecked ? 'PET Plastic Window Die-Cut' : 'None';

        // 8.5. Math Pricing Logic
        const volume = L * W * H;
        let sizeFactor = 1.0;
        if (volume > 10000) sizeFactor = 2.5;
        else if (volume > 5000) sizeFactor = 1.8;
        else if (volume > 1000) sizeFactor = 1.3;

        // Material Markup
        let materialMarkup = 0.0;
        switch (material) {
            case 'Rigid Board': materialMarkup = 1.50; break;
            case 'Corrugated Board': materialMarkup = 0.50; break;
            case 'Cardboard': materialMarkup = 0.15; break;
            case 'Kraft Paper': materialMarkup = 0.05; break;
        }

        // Finishes markup
        let finishCost = 0.0;
        if (document.getElementById('printing_required').checked) finishCost += 0.08;
        if (document.getElementById('lamination').checked) finishCost += 0.04;
        if (document.getElementById('embossing').checked) finishCost += 0.06;
        if (document.getElementById('foil_stamping').checked) finishCost += 0.12;
        if (document.getElementById('window_cutout').checked) finishCost += 0.05;

        // Calculate Unit price before discount
        let unitPrice = (basePrice * sizeFactor) + materialMarkup + finishCost;

        // Calculate Discount
        let discount = 0;
        if (qty >= 1000) discount = 25;
        else if (qty >= 500) discount = 15;
        else if (qty >= 250) discount = 5;

        unitPrice = unitPrice * (1 - (discount / 100));
        const totalPrice = unitPrice * qty;

        // 9. Update UI Price Outputs
        priceUnitSpan.textContent = unitPrice.toFixed(2);
        priceDiscountSpan.textContent = discount;
        priceTotalSpan.textContent = totalPrice.toFixed(2);
    }

    function updateSVGGradient(gradId, color1, color2) {
        const grad = document.getElementById(gradId);
        if (grad) {
            grad.children[0].setAttribute('stop-color', color1);
            grad.children[1].setAttribute('stop-color', color2);
        }
    }

    // 10. View Toggling Event Listeners (3D vs 2D Dieline)
    btnView3d.addEventListener('click', () => {
        btnView3d.className = 'btn btn-gold';
        btnView3d.style.background = 'var(--color-primary)';
        btnView3d.style.color = 'white';
        btnView3d.style.fontWeight = '600';
        
        btnViewDieline.className = 'btn btn-outline';
        btnViewDieline.style.background = 'transparent';
        btnViewDieline.style.color = 'var(--color-text-dark)';
        btnViewDieline.style.fontWeight = 'normal';

        visualCanvas.style.display = 'block';
        dielineCanvas.style.display = 'none';
    });

    btnViewDieline.addEventListener('click', () => {
        btnViewDieline.className = 'btn btn-gold';
        btnViewDieline.style.background = 'var(--color-primary)';
        btnViewDieline.style.color = 'white';
        btnViewDieline.style.fontWeight = '600';

        btnView3d.className = 'btn btn-outline';
        btnView3d.style.background = 'transparent';
        btnView3d.style.color = 'var(--color-text-dark)';
        btnView3d.style.fontWeight = 'normal';

        visualCanvas.style.display = 'none';
        dielineCanvas.style.display = 'block';
    });

    // 11. Dieline SVG Exporter Link Downloader
    btnDownloadDieline.addEventListener('click', () => {
        const L = parseFloat(lengthInput.value);
        const W = parseFloat(widthInput.value);
        const H = parseFloat(heightInput.value);
        const material = materialSelect.value;

        // Clone dieline canvas
        const clonedDieline = dielineCanvas.cloneNode(true);
        clonedDieline.style.display = 'block';
        clonedDieline.setAttribute('width', '800');
        clonedDieline.setAttribute('height', '800');
        clonedDieline.style.backgroundColor = '#ffffff'; // export with white background
        
        // Add styling elements so it renders beautifully outside the browser
        const styleEl = document.createElementNS('http://www.w3.org/2000/svg', 'style');
        styleEl.textContent = `
            #dieline-cut { stroke: #d32f2f; stroke-width: 0.5px; fill: none; }
            #dieline-crease { stroke: #1976d2; stroke-width: 0.5px; stroke-dasharray: 2 2; fill: none; }
            #dieline-window { stroke: #d32f2f; stroke-width: 0.5px; stroke-dasharray: 2 1; fill: none; }
            text { font-family: monospace; font-size: 2.5px; fill: #37474f; font-weight: bold; }
            line { stroke: #607d8b; stroke-width: 0.2px; }
        `;
        clonedDieline.insertBefore(styleEl, clonedDieline.firstChild);

        const serializer = new XMLSerializer();
        const svgStr = serializer.serializeToString(clonedDieline);
        
        const blob = new Blob([svgStr], { type: 'image/svg+xml;charset=utf-8' });
        const blobUrl = URL.createObjectURL(blob);
        
        const downloadLink = document.createElement('a');
        downloadLink.href = blobUrl;
        downloadLink.download = `packcraft-dieline-${L}x${W}x${H}-${material.replace(/\s+/g, '-').toLowerCase()}.svg`;
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
        URL.revokeObjectURL(blobUrl);
    });

    // Initialize
    updateConfigurator();
});
</script>

@endsection

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "Product",
  "name": "{{ $product->name }}",
  "description": "{{ $product->description }}",
  "offers": {
    "@type": "AggregateOffer",
    "lowPrice": "{{ $product->base_price }}",
    "priceCurrency": "USD"
  }
}
</script>
@endsection
