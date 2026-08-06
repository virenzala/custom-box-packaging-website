@extends('layouts.app')

@section('title', 'Contact Us | PackCraft Custom Packaging')
@section('meta_description', 'Have questions about materials, shipping rates, or design files? Contact the PackCraft team today.')

@section('content')

<section style="padding: 3rem 0;">
    <div class="container">
        
        <div style="text-align: center; margin-bottom: 3.5rem;">
            <h1 style="font-family: var(--font-serif); font-size: 2.5rem; margin-bottom: 0.5rem;">Contact Our Office</h1>
            <p style="opacity: 0.7; max-width: 600px; margin: 0 auto;">Reach out to our sales department, structural engineering team, or customer support desk. We are here to help.</p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 3rem; align-items: start;">
            
            <!-- Left Side: Contact Information Cards -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div class="card" style="padding: 1.5rem; display: flex; align-items: flex-start; gap: 1rem;">
                    <div style="width: 45px; height: 45px; background-color: rgba(30, 56, 43, 0.08); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: var(--color-primary); flex-shrink: 0;">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div>
                        <h3 style="font-size: 1.05rem; margin-bottom: 0.25rem;">Call Our Team</h3>
                        <p style="font-size: 0.9rem; margin-bottom: 0.25rem; opacity: 0.85;">Mon-Fri from 9am to 6pm PST.</p>
                        <strong style="color: var(--color-primary);">+1 (555) 012-3456</strong>
                    </div>
                </div>

                <div class="card" style="padding: 1.5rem; display: flex; align-items: flex-start; gap: 1rem;">
                    <div style="width: 45px; height: 45px; background-color: rgba(30, 56, 43, 0.08); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: var(--color-primary); flex-shrink: 0;">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div>
                        <h3 style="font-size: 1.05rem; margin-bottom: 0.25rem;">Email Inquiry</h3>
                        <p style="font-size: 0.9rem; margin-bottom: 0.25rem; opacity: 0.85;">Our sales desk responds in 1 hour.</p>
                        <strong style="color: var(--color-primary);">info@packcraft.com</strong>
                    </div>
                </div>

                <div class="card" style="padding: 1.5rem; display: flex; align-items: flex-start; gap: 1rem;">
                    <div style="width: 45px; height: 45px; background-color: rgba(30, 56, 43, 0.08); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: var(--color-primary); flex-shrink: 0;">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <h3 style="font-size: 1.05rem; margin-bottom: 0.25rem;">Headquarters</h3>
                        <p style="font-size: 0.9rem; margin-bottom: 0.25rem; opacity: 0.85;">Visit our factory display showroom.</p>
                        <address style="font-style: normal; font-size: 0.9rem; opacity: 0.7;">100 Packaging Way, Box City, CA 90210</address>
                    </div>
                </div>
            </div>

            <!-- Right Side: Contact Form -->
            <div class="card" style="padding: 2.5rem;">
                <h3 style="font-size: 1.25rem; margin-bottom: 1.5rem; color: var(--color-primary);">Send Us a Message</h3>
                
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    
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

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Subject *</label>
                            <input type="text" id="subject" name="subject" class="form-control" placeholder="e.g., Cargo crates, Custom quote query" value="{{ old('subject') }}" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" rows="5" class="form-control" placeholder="Write your message here..." required>{{ old('message') }}</textarea>
                    </div>

                    <!-- CAPTCHA -->
                    <div class="form-group" style="background-color: var(--color-bg-light); padding: 1.25rem; border-radius: var(--border-radius); border: 1px solid var(--color-border-light); margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <span style="font-size: 1.2rem; font-weight: 700; color: var(--color-primary); background: var(--color-bg-white); padding: 0.25rem 0.75rem; border-radius: 4px; border: 1px solid var(--color-border-light);">
                                {{ $captcha }}
                            </span>
                            <label for="captcha_answer" style="margin-bottom:0; font-weight: 600;">What is the sum? *</label>
                        </div>
                        <input type="number" id="captcha_answer" name="captcha_answer" class="form-control" style="width: 100px;" required>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">Send Message</button>
                </form>
            </div>

        </div>

    </div>
</section>

@endsection
