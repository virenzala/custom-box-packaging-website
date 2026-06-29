<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Show Checkout Form with selected custom options
     */
    public function checkout(Request $request)
    {
        $product = Product::where('slug', $request->product_slug)->firstOrFail();
        
        $specs = [
            'length' => $request->length ?? 10,
            'width' => $request->width ?? 10,
            'height' => $request->height ?? 10,
            'material' => $request->material ?? 'Cardboard',
            'quantity' => $request->quantity ?? 100,
            'printing_required' => $request->boolean('printing_required'),
            'lamination' => $request->boolean('lamination'),
            'embossing' => $request->boolean('embossing'),
            'foil_stamping' => $request->boolean('foil_stamping'),
            'window_cutout' => $request->boolean('window_cutout'),
        ];

        // Dynamic price calculation on backend (security check)
        $totalPrice = $this->calculatePrice($product->base_price, $specs);

        return view('orders.checkout', compact('product', 'specs', 'totalPrice'));
    }

    /**
     * Place order
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string',
            'length' => 'required|numeric',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'material' => 'required|string',
            'quantity' => 'required|integer',
            'total_price' => 'required|numeric',
            'billing_name' => 'required|string|max:255',
            'billing_email' => 'required|email|max:255',
            'billing_phone' => 'required|string|max:50',
            'shipping_address' => 'required|string|max:1000',
        ]);

        $order = Order::create([
            'user_id' => Auth::id(), // null if guest
            'product_name' => $request->product_name,
            'length' => $request->length,
            'width' => $request->width,
            'height' => $request->height,
            'material' => $request->material,
            'quantity' => $request->quantity,
            'printing_required' => $request->boolean('printing_required'),
            'lamination' => $request->boolean('lamination'),
            'embossing' => $request->boolean('embossing'),
            'foil_stamping' => $request->boolean('foil_stamping'),
            'window_cutout' => $request->boolean('window_cutout'),
            'total_price' => $request->total_price,
            'status' => 'Pending',
            'billing_name' => $request->billing_name,
            'billing_email' => $request->billing_email,
            'billing_phone' => $request->billing_phone,
            'shipping_address' => $request->shipping_address,
        ]);

        $this->simulateOrderEmails($order);

        if (Auth::check()) {
            return redirect()->route('portal.index')->with('success', 'Order placed successfully! Order #' . $order->id);
        }

        return redirect()->route('home')->with('success', 'Order placed successfully as Guest! Your order ID is #' . $order->id . '. We will contact you at ' . $order->billing_email);
    }

    /**
     * Customer Portal Dashboard
     */
    public function portalIndex()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to access the customer portal.');
        }

        $orders = Order::where('user_id', Auth::id())->orderBy('id', 'desc')->get();
        return view('portal.index', compact('orders'));
    }

    /**
     * Download / View Invoice Layout
     */
    public function showInvoice($id)
    {
        $order = Order::findOrFail($id);
        
        // Security check
        if (!Auth::check() || ($order->user_id !== Auth::id() && Auth::user()->role === 'customer')) {
            abort(403, 'Unauthorized invoice access.');
        }

        return view('portal.invoice', compact('order'));
    }

    /**
     * Price calculator logic helper
     */
    private function calculatePrice($basePrice, $specs)
    {
        $vol = $specs['length'] * $specs['width'] * $specs['height'];
        
        // Multiplier based on box volume size
        $sizeFactor = 1.0;
        if ($vol > 10000) $sizeFactor = 2.5;
        elseif ($vol > 5000) $sizeFactor = 1.8;
        elseif ($vol > 1000) $sizeFactor = 1.3;

        // Material markup
        $materialMarkup = 0.0;
        switch ($specs['material']) {
            case 'Rigid Board': $materialMarkup = 1.50; break;
            case 'Corrugated Board': $materialMarkup = 0.50; break;
            case 'Cardboard': $materialMarkup = 0.15; break;
            case 'Kraft Paper': $materialMarkup = 0.05; break;
        }

        // Additional Finishes
        $finishCost = 0.0;
        if ($specs['printing_required']) $finishCost += 0.08;
        if ($specs['lamination']) $finishCost += 0.04;
        if ($specs['embossing']) $finishCost += 0.06;
        if ($specs['foil_stamping']) $finishCost += 0.12;
        if ($specs['window_cutout']) $finishCost += 0.05;

        // Unit Price
        $unitPrice = ($basePrice * $sizeFactor) + $materialMarkup + $finishCost;

        // Volume discounts
        $qty = $specs['quantity'];
        $discount = 0.0;
        if ($qty >= 1000) $discount = 0.25; // 25% off unit price
        elseif ($qty >= 500) $discount = 0.15; // 15% off
        elseif ($qty >= 250) $discount = 0.05; // 5% off

        $unitPrice = $unitPrice * (1 - $discount);

        return round($unitPrice * $qty, 2);
    }

    private function simulateOrderEmails(Order $order)
    {
        $mailPath = storage_path('logs/mail_simulations.log');

        $customerMail = "-----------------------------------------\n"
                      . "TIMESTAMP: " . now()->toDateTimeString() . "\n"
                      . "TO: {$order->billing_email} (Customer Confirmation)\n"
                      . "SUBJECT: Order Confirmed! PackCraft Order #{$order->id}\n"
                      . "Dear {$order->billing_name},\n\n"
                      . "Thank you for shopping with PackCraft. Your order #{$order->id} for {$order->quantity} units of '{$order->product_name}' has been successfully placed.\n"
                      . "Total Paid: $" . number_format($order->total_price, 2) . "\n"
                      . "Shipping to:\n{$order->shipping_address}\n\n"
                      . "You can track your order manufacturing stage on our website portal.\n\n"
                      . "Best regards,\nPackCraft Orders Dept\n"
                      . "-----------------------------------------\n\n";

        $adminMail    = "-----------------------------------------\n"
                      . "TIMESTAMP: " . now()->toDateTimeString() . "\n"
                      . "TO: operations@packcraft.com (Admin Alert)\n"
                      . "SUBJECT: NEW ORDER RECEIVED: #{$order->id}\n"
                      . "Order ID: #{$order->id}\n"
                      . "Product: {$order->product_name}\n"
                      . "Qty: {$order->quantity} units | Total: $" . number_format($order->total_price, 2) . "\n"
                      . "Customer: {$order->billing_name} ({$order->billing_email})\n"
                      . "Dispatch Address:\n{$order->shipping_address}\n\n"
                      . "Review details and update status in Admin: " . route('admin.orders') . "\n"
                      . "-----------------------------------------\n\n";

        @file_put_contents($mailPath, $customerMail . $adminMail, FILE_APPEND);
        Log::info("Simulated order confirmation emails logged to storage/logs/mail_simulations.log");
    }
}
