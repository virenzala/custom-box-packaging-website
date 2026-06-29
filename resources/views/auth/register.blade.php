@extends('layouts.app')

@section('title', 'Register Client Account | PackCraft')

@section('content')

<section style="padding: 5rem 0;">
    <div class="container" style="max-width: 480px;">
        
        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="font-family: var(--font-serif); font-size: 2.25rem; margin-bottom: 0.5rem;">Create Client Account</h1>
            <p style="opacity: 0.7;">Register to manage custom packaging orders, download invoices, and save artwork.</p>
        </div>

        <div class="card" style="padding: 2.5rem;">
            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="name">Company / Full Name *</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password * (Min: 6 chars)</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="form-group" style="margin-bottom: 2rem;">
                    <label for="password_confirmation">Confirm Password *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 1.5rem;">Register Account</button>
                
                <div style="text-align: center; font-size: 0.9rem; opacity: 0.7;">
                    <span>Already have an account? </span>
                    <a href="{{ route('login') }}" style="color: var(--color-accent); font-weight: 600;">Sign In</a>
                </div>
            </form>
        </div>

    </div>
</section>

@endsection
