@extends('layouts.app')

@section('title', 'Login | PackCraft Custom Packaging')

@section('content')

<section style="padding: 5rem 0;">
    <div class="container" style="max-width: 480px;">
        
        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="font-family: var(--font-serif); font-size: 2.25rem; margin-bottom: 0.5rem;">Welcome Back</h1>
            <p style="opacity: 0.7;">Sign in to track orders, download invoices, and save your packaging addresses.</p>
        </div>

        <div class="card" style="padding: 2.5rem;">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                </div>
                
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="form-group" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; cursor: pointer; margin-bottom: 0;">
                        <input type="checkbox" name="remember" value="1">
                        <span>Remember Me</span>
                    </label>
                    <a href="#" style="font-size: 0.85rem; color: var(--color-accent); font-weight: 500;">Forgot Password?</a>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 1.5rem;">Sign In</button>
                
                <div style="text-align: center; font-size: 0.9rem; opacity: 0.7;">
                    <span>Don't have an account? </span>
                    <a href="{{ route('register') }}" style="color: var(--color-accent); font-weight: 600;">Register Here</a>
                </div>
            </form>
        </div>

    </div>
</section>

@endsection
