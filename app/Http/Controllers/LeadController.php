<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
    /**
     * Show general quote request page
     */
    public function showQuoteForm()
    {
        $captcha = $this->generateCaptcha();
        return view('pages.quote', compact('captcha'));
    }

    /**
     * Submit a Custom Quote Request
     */
    public function submitQuote(Request $request)
    {
        // 1. Validate Form & Math CAPTCHA
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'company_name' => 'nullable|string|max:255',
            'product_type' => 'required|string',
            'length' => 'required|numeric|min:1',
            'width' => 'required|numeric|min:1',
            'height' => 'required|numeric|min:1',
            'material' => 'required|string',
            'quantity' => 'required|integer|min:100',
            'captcha_answer' => 'required|integer',
            'message' => 'nullable|string|max:2000',
        ];

        $request->validate($rules);

        // CAPTCHA verification
        $num1 = session('captcha_num1');
        $num2 = session('captcha_num2');
        if ($request->captcha_answer != ($num1 + $num2)) {
            return back()->withErrors(['captcha_answer' => 'Incorrect security CAPTCHA answer. Please try again.'])->withInput();
        }

        // 2. Save Lead to Database
        $lead = Lead::create([
            'type' => 'quote',
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company_name' => $request->company_name,
            'product_type' => $request->product_type,
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
            'message' => $request->message,
            'status' => 'New',
        ]);

        // 3. Trigger Simulated Notification Emails
        $this->simulateQuoteNotifications($lead);

        // 4. Return Success
        return redirect()->back()->with('success', 'Thank you! Your custom packaging quote request has been received. Our sales team will email you shortly.');
    }

    /**
     * Submit a general Contact Form
     */
    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'captcha_answer' => 'required|integer',
        ]);

        // CAPTCHA verification
        $num1 = session('captcha_num1');
        $num2 = session('captcha_num2');
        if ($request->captcha_answer != ($num1 + $num2)) {
            return back()->withErrors(['captcha_answer' => 'Incorrect security CAPTCHA answer. Please try again.'])->withInput();
        }

        $lead = Lead::create([
            'type' => 'contact',
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'product_type' => $request->subject, // map subject to product_type for general leads
            'message' => $request->message,
            'status' => 'New',
        ]);

        $this->simulateContactNotifications($lead);

        return redirect()->back()->with('success', 'Thank you! Your message has been sent. We will get back to you soon.');
    }

    /**
     * Generate simple math puzzle and store numbers in session
     */
    private function generateCaptcha()
    {
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        session(['captcha_num1' => $num1, 'captcha_num2' => $num2]);
        return "{$num1} + {$num2}";
    }

    /**
     * Simulated Email Logs (for verification)
     */
    private function simulateQuoteNotifications(Lead $lead)
    {
        $mailPath = storage_path('logs/mail_simulations.log');
        
        $customerMail = "-----------------------------------------\n"
                      . "TIMESTAMP: " . now()->toDateTimeString() . "\n"
                      . "TO: {$lead->email} (Customer Confirmation)\n"
                      . "SUBJECT: PackCraft Custom Quote Request Received!\n"
                      . "Dear {$lead->name},\n\n"
                      . "We have received your custom quote request for: {$lead->product_type}.\n"
                      . "Specs: {$lead->length}x{$lead->width}x{$lead->height}cm | Material: {$lead->material} | Qty: {$lead->quantity} units.\n"
                      . "Our design specialists are reviewing your configuration and will send a detailed PDF estimate within 1 business day.\n\n"
                      . "Kind regards,\nPackCraft Sales Team\n"
                      . "-----------------------------------------\n\n";

        $adminMail    = "-----------------------------------------\n"
                      . "TIMESTAMP: " . now()->toDateTimeString() . "\n"
                      . "TO: admin@packcraft.com (Admin Notification)\n"
                      . "SUBJECT: NEW LEAD RECEIVED: Custom Quote #{$lead->id}\n"
                      . "A new packaging quote has been requested by:\n"
                      . "Name: {$lead->name}\n"
                      . "Email: {$lead->email}\n"
                      . "Phone: {$lead->phone}\n"
                      . "Company: {$lead->company_name}\n"
                      . "Product: {$lead->product_type}\n"
                      . "Dimensions: {$lead->length} x {$lead->width} x {$lead->height} cm\n"
                      . "Material: {$lead->material} | Qty: {$lead->quantity} units\n"
                      . "Message: {$lead->message}\n\n"
                      . "Manage this lead in the Admin panel: " . route('admin.leads') . "\n"
                      . "-----------------------------------------\n\n";

        @file_put_contents($mailPath, $customerMail . $adminMail, FILE_APPEND);
        Log::info("Simulated quote notification emails logged to storage/logs/mail_simulations.log");
    }

    private function simulateContactNotifications(Lead $lead)
    {
        $mailPath = storage_path('logs/mail_simulations.log');

        $customerMail = "-----------------------------------------\n"
                      . "TIMESTAMP: " . now()->toDateTimeString() . "\n"
                      . "TO: {$lead->email} (Customer Confirmation)\n"
                      . "SUBJECT: PackCraft Contact Inquiry Received\n"
                      . "Hello {$lead->name},\n\n"
                      . "Thank you for contacting PackCraft. We have received your message regarding '{$lead->product_type}' and will respond within 24 hours.\n\n"
                      . "Best,\nCustomer Service\n"
                      . "-----------------------------------------\n\n";

        $adminMail    = "-----------------------------------------\n"
                      . "TIMESTAMP: " . now()->toDateTimeString() . "\n"
                      . "TO: info@packcraft.com (Admin Alert)\n"
                      . "SUBJECT: NEW MESSAGE: {$lead->product_type} from {$lead->name}\n"
                      . "From: {$lead->name} ({$lead->email})\n"
                      . "Message:\n{$lead->message}\n"
                      . "-----------------------------------------\n\n";

        @file_put_contents($mailPath, $customerMail . $adminMail, FILE_APPEND);
        Log::info("Simulated contact notification emails logged to storage/logs/mail_simulations.log");
    }
}
