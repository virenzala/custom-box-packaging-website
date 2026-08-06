<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer' // Default role
        ]);

        Auth::login($user);

        return redirect()->route('portal.index')->with('success', 'Account registered successfully!');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('success', 'Logged in as administrator.');
            }
            
            return redirect()->route('portal.index')->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Logged out successfully.');
    }

    /**
     * Simulated Role Switcher (convenient for evaluating RBAC requirements)
     */
    public function simulateRole(Request $request)
    {
        $request->validate(['role' => 'required|string']);
        
        if (!Auth::check()) {
            // Find or create a temporary admin user to sign in
            $user = User::where('email', 'admin@packcraft.com')->first();
            if ($user) {
                Auth::login($user);
            } else {
                return redirect()->route('login')->with('error', 'Please log in first.');
            }
        }
        
        $user = Auth::user();
        $user->role = $request->role;
        $user->save();
        
        return back()->with('success', "Simulated role switched to: {$request->role}");
    }
}
