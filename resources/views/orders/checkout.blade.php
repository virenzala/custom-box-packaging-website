@extends('layouts.app')

@section('title', 'Secure Checkout | PackCraft Custom Boxes')

@section('content')

<section style="padding: 3rem 0;">
    <div class="container">
        
        <div style="margin-bottom: 2.5rem;">
            <h1 style="font-family: var(--font-serif); font-size: 2.25rem;">Secure Checkout</h1>
            <p style="opacity: 0.7;">Complete your contact and delivery details to submit your customized box order.</p>
        </div>

        <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 3rem; align-items: start;">
            
            <!-- Left Side: Shipping / Billing Form -->
            <div class="card" style="padding: 2.5rem;">
                <h3 style="font-size: 1.25rem; margin-bottom: 1.5rem; color: var(--color-primary); border-bottom: 1px solid var(--color-border-light); padding-bottom: 0.5rem;"><i class="fa-regular fa-address-card" style="margin-right: 0.5rem;"></i> Billing & Shipping Address</h3>
                
                <form action="{{ route('place-order') }}" method="POST">
                    @csrf
                    
                    <!-- Hidden inputs preserving configuration -->
                    <input type="hidden" name="product_name" value="{{ $product->name }}">
                    <input type="hidden" name="length" value="{{ $specs['length'] }}">
                    <input type="hidden" name="width" value="{{ $specs['width'] }}">
                    <input type="hidden" name="height" value="{{ $specs['height'] }}">
                    <input type="hidden" name="material" value="{{ $specs['material'] }}">
                    <input type="hidden" name="quantity" value="{{ $specs['quantity'] }}">
                    <input type="hidden" name="printing_required" value="{{ $specs['printing_required'] ? 1 : 0 }}">
                    <input type="hidden" name="lamination" value="{{ $specs['lamination'] ? 1 : 0 }}">
                    <input type="hidden" name="embossing" value="{{ $specs['embossing'] ? 1 : 0 }}">
                    <input type="hidden" name="foil_stamping" value="{{ $specs['foil_stamping'] ? 1 : 0 }}">
                    <input type="hidden" name="window_cutout" value="{{ $specs['window_cutout'] ? 1 : 0 }}">
                    <input type="hidden" name="total_price" value="{{ $totalPrice }}">

                    <div class="form-group">
                        <label for="billing_name">Full / Company Name *</label>
                        <input type="text" id="billing_name" name="billing_name" class="form-control" value="{{ Auth::check() ? Auth::user()->name : old('billing_name') }}" required>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                        <div class="form-group">
                            <label for="billing_email">Email Address *</label>
                            <input type="email" id="billing_email" name="billing_email" class="form-control" value="{{ Auth::check() ? Auth::user()->email : old('billing_email') }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="billing_phone">Phone Number *</label>
                            <input type="text" id="billing_phone" name="billing_phone" class="form-control" value="{{ old('billing_phone') }}" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 2rem;">
                        <label for="shipping_address">Delivery Shipping Address *</label>
                        <textarea id="shipping_address" name="shipping_address" rows="3" class="form-control" placeholder="123 Manufacturing Blvd, Suite 10, Box City, CA 90210" required>{{ old('shipping_address') }}</textarea>
                    </div>

                    <!-- Payment Section Mock -->
                    <h3 style="font-size: 1.25rem; margin-bottom: 1.5rem; color: var(--color-primary); border-bottom: 1px solid var(--color-border-light); padding-bottom: 0.5rem;"><i class="fa-solid fa-credit-card" style="margin-right: 0.5rem;"></i> Payment Details (Demo Integration)</h3>
                    
                    <div class="form-group">
                        <label for="card_num">Card Number</label>
                        <input type="text" id="card_num" class="form-control" placeholder="4111 2222 3333 4444" value="4111 2222 3333 4444" disabled>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 2rem;">
                        <div class="form-group">
                            <label for="card_expiry">Expiration Date</label>
                            <input type="text" id="card_expiry" class="form-control" placeholder="MM/YY" value="12/28" disabled>
                        </div>
                        <div class="form-group">
                            <label for="card_cvc">Security Code (CVC)</label>
                            <input type="text" id="card_cvc" class="form-control" placeholder="123" value="123" disabled>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">Authorize Payment & Place Order</button>
                </form>
            </div>

            <!-- Right Side: Order Summary Card -->
            <div class="card" style="padding: 2rem; background-color: var(--color-bg-white);">
                <h3 style="font-size: 1.15rem; margin-bottom: 1.25rem; border-bottom: 1px solid var(--color-border-light); padding-bottom: 0.5rem; color: var(--color-primary);"><i class="fa-solid fa-file-invoice" style="margin-right: 0.5rem;"></i> Order Summary</h3>
                
                <div style="display: flex; flex-direction: column; gap: 1rem; font-size: 0.95rem; margin-bottom: 1.5rem;">
                    <div class="flex flex-between">
                        <strong>Box Style:</strong>
                        <span>{{ $product->name }}</span>
                    </div>
                    <div class="flex flex-between">
                        <strong>Dimensions:</strong>
                        <span>{{ $specs['length'] }}L x {{ $specs['width'] }}W x {{ $specs['height'] }}H cm</span>
                    </div>
                    <div class="flex flex-between">
                        <strong>Selected Material:</strong>
                        <span>{{ $specs['material'] }}</span>
                    </div>
                    <div class="flex flex-between">
                        <strong>Quantity:</strong>
                        <span>{{ $specs['quantity'] }} units</span>
                    </div>
                    
                    @if($specs['printing_required'] || $specs['lamination'] || $specs['embossing'] || $specs['foil_stamping'] || $specs['window_cutout'])
                        <div style="border-top: 1px dashed var(--color-border-light); padding-top: 0.75rem;">
                            <strong style="display:block; margin-bottom:0.25rem;">Finishing Specifications:</strong>
                            <ul style="list-style-position: inside; font-size: 0.85rem; opacity: 0.8; display: grid; gap: 0.25rem;">
                                @if($specs['printing_required']) <li>Custom Logo Printing</li> @endif
                                @if($specs['lamination']) <li>Matte Finish Lamination</li> @endif
                                @if($specs['embossing']) <li>Text Embossing</li> @endif
                                @if($specs['foil_stamping']) <li>Gold Metallic Foil Stamping</li> @endif
                                @if($specs['window_cutout']) <li>Front Face Window Cut-Out</li> @endif
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- Price display -->
                <div style="background-color: var(--color-bg-light); border-radius: var(--border-radius); padding: 1.25rem; border: 1px solid var(--color-border-light);">
                    <div class="flex flex-between" style="margin-bottom: 0.5rem; font-size: 0.9rem;">
                        <span>Shipping Cost:</span>
                        <span style="color: var(--color-success); font-weight: 600;">FREE (Standard)</span>
                    </div>
                    <div class="flex flex-between" style="font-size: 1.25rem; font-weight: 700; color: var(--color-primary); border-top: 1px solid var(--color-border-light); padding-top: 0.75rem; margin-top: 0.5rem;">
                        <span>Total Price:</span>
                        <span>${{ number_format($totalPrice, 2) }}</span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

@endsection
