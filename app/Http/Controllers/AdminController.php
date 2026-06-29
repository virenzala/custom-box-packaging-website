<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Dashboard Overview Metrics
     */
    public function dashboard()
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'Pending')->count();
        $newLeads = Lead::where('status', 'New')->count();
        $revenue = Order::whereNotIn('status', ['Cancelled'])->sum('total_price');
        
        $recentOrders = Order::orderBy('id', 'desc')->take(5)->get();
        $recentLeads = Lead::orderBy('id', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('totalOrders', 'pendingOrders', 'newLeads', 'revenue', 'recentOrders', 'recentLeads'));
    }

    /**
     * Leads Module (list, search, filter)
     */
    public function leads(Request $request)
    {
        $query = Lead::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('product_type', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $leads = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();
        
        return view('admin.leads.index', compact('leads'));
    }

    /**
     * Update Lead status or add Admin notes
     */
    public function updateLead(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);
        
        $request->validate([
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $lead->status = $request->status;
        $lead->notes = $request->notes;
        $lead->save();

        return redirect()->back()->with('success', 'Lead #' . $id . ' updated successfully.');
    }

    /**
     * Export Leads to CSV
     */
    public function exportLeads()
    {
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=leads_export_" . date('Y-m-d') . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'ID', 'Type', 'Name', 'Email', 'Phone', 'Company', 'Product Type', 
                'Length', 'Width', 'Height', 'Material', 'Quantity', 
                'Printing Required', 'Lamination', 'Embossing', 'Foil Stamping', 'Window Cutout', 
                'Status', 'Admin Notes', 'Submitted At'
            ]);

            $leads = Lead::all();
            foreach ($leads as $lead) {
                fputcsv($file, [
                    $lead->id,
                    $lead->type,
                    $lead->name,
                    $lead->email,
                    $lead->phone,
                    $lead->company_name,
                    $lead->product_type,
                    $lead->length ?? '',
                    $lead->width ?? '',
                    $lead->height ?? '',
                    $lead->material ?? '',
                    $lead->quantity ?? '',
                    $lead->printing_required ? 'Yes' : 'No',
                    $lead->lamination ? 'Yes' : 'No',
                    $lead->embossing ? 'Yes' : 'No',
                    $lead->foil_stamping ? 'Yes' : 'No',
                    $lead->window_cutout ? 'Yes' : 'No',
                    $lead->status,
                    $lead->notes ?? '',
                    $lead->created_at->toDateTimeString()
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Orders Module
     */
    public function orders(Request $request)
    {
        $query = Order::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('billing_name', 'like', "%{$search}%")
                  ->orWhere('billing_email', 'like', "%{$search}%")
                  ->orWhere('product_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Update Order Manufacturing Stage and dispatch simulated email
     */
    public function updateOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $oldStatus = $order->status;
        $order->status = $request->status;
        $order->notes = $request->notes;
        $order->save();

        // If status changed, log a mock email update to the user
        if ($oldStatus !== $request->status) {
            $this->simulateOrderStatusEmail($order);
        }

        return redirect()->back()->with('success', 'Order #' . $id . ' updated successfully.');
    }

    /**
     * Products Catalog Admin CRUD
     */
    public function products()
    {
        $products = Product::with('category')->orderBy('id', 'desc')->get();
        $categories = Category::all();
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'base_price' => 'required|numeric|min:0.01',
            'min_qty' => 'required|integer|min:1',
            'features' => 'nullable|string', // comma-separated strings
        ]);

        $features = $request->features ? array_map('trim', explode(',', $request->features)) : [];

        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'features' => $features,
            'base_price' => $request->base_price,
            'min_qty' => $request->min_qty,
            'image' => Str::slug($request->name) . '.jpg',
        ]);

        return redirect()->back()->with('success', 'Product created successfully.');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    /**
     * Categories Admin CRUD
     */
    public function categories()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'image' => Str::slug($request->name) . '.jpg',
        ]);

        return redirect()->back()->with('success', 'Category created successfully.');
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }

    /**
     * Blogs Admin CRUD
     */
    public function blogs()
    {
        $blogs = Blog::orderBy('id', 'desc')->get();
        return view('admin.blogs.index', compact('blogs'));
    }

    public function storeBlog(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);

        Blog::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'category' => $request->category,
            'status' => $request->status,
            'published_at' => $request->status === 'published' ? now() : null,
            'image' => 'blog-default.jpg',
        ]);

        return redirect()->back()->with('success', 'Blog article saved successfully.');
    }

    public function deleteBlog($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return redirect()->back()->with('success', 'Blog article deleted successfully.');
    }

    /**
     * RBAC Users List Simulator
     */
    public function users()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function updateUserRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate(['role' => 'required|string']);
        
        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', "User '{$user->name}' role updated to '{$user->role}'.");
    }

    private function simulateOrderStatusEmail(Order $order)
    {
        $mailPath = storage_path('logs/mail_simulations.log');

        $statusUpdateMail = "-----------------------------------------\n"
                          . "TIMESTAMP: " . now()->toDateTimeString() . "\n"
                          . "TO: {$order->billing_email} (Customer Order Alert)\n"
                          . "SUBJECT: PackCraft Order #{$order->id} Status Updated to [{$order->status}]\n"
                          . "Dear {$order->billing_name},\n\n"
                          . "Your custom packaging order #{$order->id} ({$order->quantity}x {$order->product_name}) has updated to: [{$order->status}].\n"
                          . "Details: {$order->notes}\n\n"
                          . "View and track your order live: " . route('portal.index') . "\n\n"
                          . "Thank you for choosing PackCraft!\n"
                          . "-----------------------------------------\n\n";

        @file_put_contents($mailPath, $statusUpdateMail, FILE_APPEND);
    }
}
