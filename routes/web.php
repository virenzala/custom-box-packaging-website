<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Models\Category;
use App\Models\Product;
use App\Models\Blog;

// 1. Public Frontend Routes
Route::get('/', function () {
    $categories = Category::take(8)->get();
    $featuredProducts = Product::take(4)->get();
    $recentBlogs = Blog::where('status', 'published')->orderBy('published_at', 'desc')->take(3)->get();
    return view('home', compact('categories', 'featuredProducts', 'recentBlogs'));
})->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/quote', [LeadController::class, 'showQuoteForm'])->name('quote.form');
Route::post('/quote', [LeadController::class, 'submitQuote'])->name('quote.submit');

Route::get('/contact', function () {
    // Generate a quick mathematical CAPTCHA and store in session
    $num1 = rand(1, 9);
    $num2 = rand(1, 9);
    session(['captcha_num1' => $num1, 'captcha_num2' => $num2]);
    $captcha = "{$num1} + {$num2}";
    return view('pages.contact', compact('captcha'));
})->name('contact');

Route::post('/contact', [LeadController::class, 'submitContact'])->name('contact.submit');

Route::get('/blog', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blogs.show');

// 2. Authentication Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/simulate-role', [AuthController::class, 'simulateRole'])->name('simulate-role');

// 3. Checkout & Ordering Routes
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [OrderController::class, 'placeOrder'])->name('place-order');

// 4. Customer Portal (Requires Auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/portal', [OrderController::class, 'portalIndex'])->name('portal.index');
    Route::get('/portal/invoice/{id}', [OrderController::class, 'showInvoice'])->name('portal.invoice');
});

// 5. Admin Panel (Requires Auth and Staff Roles)
Route::middleware(['auth', 'role:super_admin,admin,sales_manager,content_manager,staff'])->group(function () {
    
    // Admin Dashboard Overview
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Leads Module (Read & Update Status)
    Route::get('/admin/leads', [AdminController::class, 'leads'])->name('admin.leads');
    Route::post('/admin/leads/{id}', [AdminController::class, 'updateLead'])->name('admin.leads.update');
    Route::get('/admin/leads/export', [AdminController::class, 'exportLeads'])->name('admin.leads.export');

    // Orders Module (Update Manufacturing Stages)
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::post('/admin/orders/{id}', [AdminController::class, 'updateOrder'])->name('admin.orders.update');

    // Catalog Management CRUD
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::post('/admin/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::delete('/admin/products/{id}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');
    
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::post('/admin/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::delete('/admin/categories/{id}', [AdminController::class, 'deleteCategory'])->name('admin.categories.delete');

    // Blog Management CRUD
    Route::get('/admin/blogs', [AdminController::class, 'blogs'])->name('admin.blogs');
    Route::post('/admin/blogs', [AdminController::class, 'storeBlog'])->name('admin.blogs.store');
    Route::delete('/admin/blogs/{id}', [AdminController::class, 'deleteBlog'])->name('admin.blogs.delete');

    // RBAC Simulation User Panel
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin/users/{id}', [AdminController::class, 'updateUserRole'])->name('admin.users.update');
});
