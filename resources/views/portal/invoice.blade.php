<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }} | PackCraft Packaging</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f9f6;
            margin: 0;
            padding: 3rem;
            color: #333;
        }
        .invoice-card {
            background-color: white;
            border-radius: 12px;
            max-width: 800px;
            margin: 0 auto;
            padding: 3rem;
            border: 1px solid #e2e6e1;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #1e382b;
            padding-bottom: 2rem;
            margin-bottom: 2rem;
        }
        .logo {
            font-size: 1.8rem;
            font-weight: 800;
            color: #1e382b;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2.5rem;
        }
        .info-section h3 {
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #1e382b;
            margin-bottom: 0.75rem;
            border-bottom: 1px solid #e2e6e1;
            padding-bottom: 0.25rem;
        }
        .info-section p {
            font-size: 0.9rem;
            line-height: 1.5;
            margin: 0 0 0.5rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2.5rem;
        }
        th, td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e6e1;
            font-size: 0.9rem;
        }
        th {
            background-color: #f6f8f5;
            color: #1e382b;
            font-weight: 700;
        }
        .total-section {
            float: right;
            width: 300px;
            font-size: 0.95rem;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }
        .grand-total {
            border-top: 2px solid #1e382b;
            padding-top: 0.75rem;
            margin-top: 0.75rem;
            font-weight: 700;
            font-size: 1.25rem;
            color: #1e382b;
        }
        .print-btn-bar {
            max-width: 800px;
            margin: 2rem auto 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
            border: 1px solid #1e382b;
        }
        .btn-print {
            background-color: #1e382b;
            color: white;
        }
        .btn-back {
            background-color: transparent;
            color: #1e382b;
        }
        @media print {
            body {
                background-color: white;
                padding: 0;
            }
            .invoice-card {
                box-shadow: none;
                border: none;
                padding: 0;
            }
            .print-btn-bar {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="invoice-card">
        
        <!-- Header -->
        <div class="header">
            <div>
                <div class="logo">PackCraft</div>
                <p style="margin: 0.25rem 0 0; opacity: 0.6; font-size: 0.85rem;">Custom Packaging Manufacturing</p>
            </div>
            <div style="text-align: right;">
                <h1 style="margin: 0; font-size: 1.8rem; color: #1e382b;">INVOICE</h1>
                <p style="margin: 0.25rem 0 0; font-weight: 700; font-size: 0.95rem;">Order #{{ $order->id }}</p>
                <p style="margin: 0.25rem 0 0; opacity: 0.6; font-size: 0.85rem;">Date: {{ $order->created_at->format('Y-m-d') }}</p>
            </div>
        </div>

        <!-- Info Section -->
        <div class="info-grid">
            <div class="info-section">
                <h3>Sold By:</h3>
                <p><strong>PackCraft Inc.</strong></p>
                <p>100 Packaging Way</p>
                <p>Box City, CA 90210</p>
                <p>Phone: +1 (555) 012-3456</p>
                <p>Email: billing@packcraft.com</p>
            </div>
            <div class="info-section">
                <h3>Bill & Ship To:</h3>
                <p><strong>{{ $order->billing_name }}</strong></p>
                <p>Email: {{ $order->billing_email }}</p>
                <p>Phone: {{ $order->billing_phone }}</p>
                <p style="white-space: pre-line;"><strong>Address:</strong><br>{{ $order->shipping_address }}</p>
            </div>
        </div>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th>Specifications</th>
                    <th style="text-align: right;">Quantity</th>
                    <th style="text-align: right;">Total Price</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $order->product_name }}</strong>
                        <p style="font-size: 0.8rem; opacity: 0.7; margin: 0.25rem 0 0;">Custom Manufactured Box</p>
                    </td>
                    <td>
                        <p style="margin: 0; font-size: 0.85rem;"><strong>Dimensions:</strong> {{ $order->length }}L x {{ $order->width }}W x {{ $order->height }}H cm</p>
                        <p style="margin: 0.25rem 0 0; font-size: 0.85rem;"><strong>Material:</strong> {{ $order->material }}</p>
                        @if($order->printing_required || $order->lamination || $order->embossing || $order->foil_stamping || $order->window_cutout)
                            <p style="margin: 0.25rem 0 0; font-size: 0.8rem; opacity: 0.7;">
                                <strong>Extras:</strong> 
                                @if($order->printing_required) Logo Print, @endif
                                @if($order->lamination) Matte Laminate, @endif
                                @if($order->embossing) Embossed, @endif
                                @if($order->foil_stamping) Gold Foil, @endif
                                @if($order->window_cutout) Die-Cut Window @endif
                            </p>
                        @endif
                    </td>
                    <td style="text-align: right; font-weight: 500;">
                        {{ number_format($order->quantity) }} units
                    </td>
                    <td style="text-align: right; font-weight: 700; color: #1e382b;">
                        ${{ number_format($order->total_price, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Totals -->
        <div style="display: flex; justify-content: flex-end;">
            <div class="total-section">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <span>${{ number_format($order->total_price, 2) }}</span>
                </div>
                <div class="total-row">
                    <span>Shipping (UPS Ground):</span>
                    <span style="color: #2e7d32; font-weight: 600;">FREE</span>
                </div>
                <div class="total-row">
                    <span>Sales Tax (8%):</span>
                    <span>$0.00 (Tax Exempt)</span>
                </div>
                <div class="total-row grand-total">
                    <span>Total Amount:</span>
                    <span>${{ number_format($order->total_price, 2) }}</span>
                </div>
            </div>
        </div>
        <div style="clear: both;"></div>

        <!-- Invoice Note Footer -->
        <div style="border-top: 1px solid #e2e6e1; padding-top: 2rem; margin-top: 4rem; text-align: center; font-size: 0.8rem; opacity: 0.5;">
            <p>Thank you for choosing PackCraft! Payment terms: Paid in full. Manufactured products will ship shortly.</p>
        </div>

    </div>

    <!-- Actions button bar -->
    <div class="print-btn-bar">
        @auth
            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.orders') }}" class="btn btn-back">&larr; Return to Orders</a>
            @else
                <a href="{{ route('portal.index') }}" class="btn btn-back">&larr; Back to Client Portal</a>
            @endif
        @else
            <a href="{{ route('home') }}" class="btn btn-back">&larr; Back to Home</a>
        @endauth
        <button onclick="window.print()" class="btn btn-print">Print Statement</button>
    </div>

</body>
</html>
