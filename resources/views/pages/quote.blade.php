@extends('layouts.app')

@section('title', 'Request a Custom Quote | PackCraft Custom Packaging')
@section('meta_description', 'Configure your custom sizes, materials, and quantities to submit a request for quotation (RFQ). Instant response within 24 hours.')

@section('content')

<section style="padding: 3rem 0;">
    <div class="container" style="max-width: 800px;">
        
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-family: var(--font-serif); font-size: 2.5rem; margin-bottom: 0.5rem;">Request a Custom Packaging Quote</h1>
            <p style="opacity: 0.7;">Submit your box dimensions and requirements below. Our structural designers will create a tailored proposal for your review.</p>
        </div>

        <div class="card" style="padding: 2.5rem;">
            <form action="{{ route('quote.submit') }}" method="POST">
                @csrf

                <!-- Section A: Contact Info -->
                <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; border-bottom: 1px solid var(--color-border-light); padding-bottom: 0.5rem; color: var(--color-primary);"><i class="fa-regular fa-user" style="margin-right: 0.5rem;"></i> Contact Details</h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                    <div class="form-group">
                        <label for="name">Your Name *</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 2rem;">
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="company_name">Company Name</label>
                        <input type="text" id="company_name" name="company_name" class="form-control" value="{{ old('company_name') }}">
                    </div>
                </div>

                <!-- Section B: Product Specs -->
                <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; border-bottom: 1px solid var(--color-border-light); padding-bottom: 0.5rem; color: var(--color-primary);"><i class="fa-solid fa-sliders" style="margin-right: 0.5rem;"></i> Box Specifications</h3>

                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label for="product_type">Packaging Style *</label>
                    <select id="product_type" name="product_type" class="form-control" required>
                        <option value="">-- Select Packaging Box Style --</option>
                        <option value="Custom Mailer Boxes" {{ old('product_type') === 'Custom Mailer Boxes' ? 'selected' : '' }}>Custom Mailer Boxes</option>
                        <option value="Natural Kraft Folding Cartons" {{ old('product_type') === 'Natural Kraft Folding Cartons' ? 'selected' : '' }}>Natural Kraft Folding Cartons</option>
                        <option value="Rigid Presentation Gift Boxes" {{ old('product_type') === 'Rigid Presentation Gift Boxes' ? 'selected' : '' }}>Rigid Presentation Gift Boxes</option>
                        <option value="Premium Window Bakery Boxes" {{ old('product_type') === 'Premium Window Bakery Boxes' ? 'selected' : '' }}>Premium Window Bakery Boxes</option>
                        <option value="Heavy Duty RSC Shipping Box" {{ old('product_type') === 'Heavy Duty RSC Shipping Box' ? 'selected' : '' }}>Heavy Duty RSC Shipping Box</option>
                        <option value="Cosmetic Tuck Top Boxes" {{ old('product_type') === 'Cosmetic Tuck Top Boxes' ? 'selected' : '' }}>Cosmetic Tuck Top Boxes</option>
                        <option value="Other / Custom Layout" {{ old('product_type') === 'Other / Custom Layout' ? 'selected' : '' }}>Other / Custom Layout</option>
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                    <div class="form-group">
                        <label for="length">Length (cm) *</label>
                        <input type="number" id="length" name="length" step="0.1" min="1" class="form-control" value="{{ old('length') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="width">Width (cm) *</label>
                        <input type="number" id="width" name="width" step="0.1" min="1" class="form-control" value="{{ old('width') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="height">Height (cm) *</label>
                        <input type="number" id="height" name="height" step="0.1" min="1" class="form-control" value="{{ old('height') }}" required>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 2rem;">
                    <div class="form-group">
                        <label for="material">Material Selection *</label>
                        <select id="material" name="material" class="form-control" required>
                            <option value="Cardboard" {{ old('material') === 'Cardboard' ? 'selected' : '' }}>White Cardboard</option>
                            <option value="Kraft Paper" {{ old('material') === 'Kraft Paper' ? 'selected' : '' }}>Kraft Paper (Brown)</option>
                            <option value="Corrugated Board" {{ old('material') === 'Corrugated Board' ? 'selected' : '' }}>Corrugated Cardboard</option>
                            <option value="Rigid Board" {{ old('material') === 'Rigid Board' ? 'selected' : '' }}>Rigid Chipboard</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="quantity">Order Quantity * (Min: 100)</label>
                        <input type="number" id="quantity" name="quantity" min="100" class="form-control" value="{{ old('quantity', 100) }}" required>
                    </div>
                </div>

                <!-- Section C: Extras -->
                <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; border-bottom: 1px solid var(--color-border-light); padding-bottom: 0.5rem; color: var(--color-primary);"><i class="fa-regular fa-square-plus" style="margin-right: 0.5rem;"></i> Finishing Options</h3>
                
                <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; margin-bottom: 2rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="printing_required" value="1" {{ old('printing_required') ? 'checked' : '' }}>
                        <span>Custom Printing</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="lamination" value="1" {{ old('lamination') ? 'checked' : '' }}>
                        <span>Lamination</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="embossing" value="1" {{ old('embossing') ? 'checked' : '' }}>
                        <span>Embossing</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="foil_stamping" value="1" {{ old('foil_stamping') ? 'checked' : '' }}>
                        <span>Foil Stamping</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="window_cutout" value="1" {{ old('window_cutout') ? 'checked' : '' }}>
                        <span>Window Cut-Out</span>
                    </label>
                </div>

                <!-- Section D: Message & Captcha -->
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="message">Describe Your Artwork or Requirements</label>
                    <textarea id="message" name="message" rows="4" class="form-control" placeholder="Add details about interior colors, logo positioning, or delivery deadlines...">{{ old('message') }}</textarea>
                </div>

                <!-- Custom Math CAPTCHA -->
                <div class="form-group" style="background-color: var(--color-bg-light); padding: 1.25rem; border-radius: var(--border-radius); border: 1px solid var(--color-border-light); margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <span style="font-size: 1.2rem; font-weight: 700; color: var(--color-primary); background: var(--color-bg-white); padding: 0.25rem 0.75rem; border-radius: 4px; border: 1px solid var(--color-border-light);">
                            {{ $captcha }}
                        </span>
                        <label for="captcha_answer" style="margin-bottom:0; font-weight: 600;">Prove you are human: What is the sum? *</label>
                    </div>
                    <input type="number" id="captcha_answer" name="captcha_answer" class="form-control" style="width: 100px;" required>
                </div>

                <div style="text-align: center;">
                    <button type="submit" class="btn btn-primary" style="width: 100%; max-width: 300px;">Submit Quote Request</button>
                </div>
            </form>
        </div>

    </div>
</section>

@endsection
