<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Lead;
use App\Models\Order;
use App\Models\Blog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Users (RBAC Demonstration)
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@packcraft.com',
            'password' => Hash::make('admin123'),
            'role' => 'super_admin'
        ]);

        User::create([
            'name' => 'Sarah Connor (Sales Manager)',
            'email' => 'sales@packcraft.com',
            'password' => Hash::make('sales123'),
            'role' => 'sales_manager'
        ]);

        User::create([
            'name' => 'John Doe (Content Editor)',
            'email' => 'content@packcraft.com',
            'password' => Hash::make('content123'),
            'role' => 'content_manager'
        ]);

        User::create([
            'name' => 'Standard Customer',
            'email' => 'customer@packcraft.com',
            'password' => Hash::make('customer123'),
            'role' => 'customer'
        ]);

        // 2. Seed Categories
        $cats = [
            ['name' => 'Custom Boxes', 'desc' => 'Tailored box solutions built exactly to your dimension and styling requirements.'],
            ['name' => 'Shipping Boxes', 'desc' => 'Sturdy, protective cardboard shippers built to withstand postal transit.'],
            ['name' => 'Food Packaging', 'desc' => 'Food-grade, eco-friendly folding cartons for confectionery, bakery, and takeaway.'],
            ['name' => 'Corrugated Boxes', 'desc' => 'Multi-layered heavy-duty corrugated board packaging for bulk cargo shipping.'],
            ['name' => 'Printed Boxes', 'desc' => 'High-fidelity full-color litho-laminated or digitally printed boxes for retail presence.'],
            ['name' => 'Retail Packaging', 'desc' => 'Premium boxes featuring window cut-outs, sleeves, and hangers to maximize shelf appeal.'],
            ['name' => 'Kraft Boxes', 'desc' => 'Natural, rustic kraft paper boxes offering an organic, eco-friendly presentation.'],
            ['name' => 'Product Packaging', 'desc' => 'Snug fitting folding cartons designed for cosmetics, electronics, and retail goods.']
        ];

        $categoryModels = [];
        foreach ($cats as $cat) {
            $categoryModels[$cat['name']] = Category::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'description' => $cat['desc'],
                'image' => Str::slug($cat['name']) . '.jpg'
            ]);
        }

        // 3. Seed Products
        $products = [
            [
                'cat' => 'Custom Boxes',
                'name' => 'Custom Mailer Boxes',
                'desc' => 'The ultimate e-commerce box. Self-locking, elegant, and secure.',
                'features' => ['Self-locking design', 'Double-sided printing option', 'Perfect for e-commerce subscription boxes'],
                'price' => 0.45
            ],
            [
                'cat' => 'Kraft Boxes',
                'name' => 'Natural Kraft Folding Cartons',
                'desc' => 'Minimalist brown kraft folding boxes. Organic look and feel.',
                'features' => ['100% Recycled content', 'Bio-degradable inks', 'Highly tactile textured finish'],
                'price' => 0.25
            ],
            [
                'cat' => 'Retail Packaging',
                'name' => 'Rigid Presentation Gift Boxes',
                'desc' => 'Heavy-board luxurious boxes for cosmetics, watches, and premium hampers.',
                'features' => ['Rigid chipboard base', 'Magnetic flap closures', 'Custom foam insert templates available'],
                'price' => 2.50
            ],
            [
                'cat' => 'Food Packaging',
                'name' => 'Premium Window Bakery Boxes',
                'desc' => 'Food-safe folding board with high-clarity plant-based PLA viewing windows.',
                'features' => ['Greaseproof clay coating', 'Pop-up assembly tab locks', 'Recyclable window film'],
                'price' => 0.35
            ],
            [
                'cat' => 'Shipping Boxes',
                'name' => 'Heavy Duty RSC Shipping Box',
                'desc' => 'Standard Regular Slotted Carton (RSC) cardboard boxes for heavy cargo shipping.',
                'features' => ['32 ECT Single Wall Kraft', '100% recyclable material', 'Shipped flat for storage efficiency'],
                'price' => 0.85
            ],
            [
                'cat' => 'Product Packaging',
                'name' => 'Cosmetic Tuck Top Boxes',
                'desc' => 'Perfect fits for skincare bottles, tubes, and make-up kits with premium foil accents.',
                'features' => ['SBS bleached sulfate board', 'Soft-touch matte lamination', 'Metallic foil stamp outline'],
                'price' => 0.18
            ]
        ];

        foreach ($products as $p) {
            Product::create([
                'category_id' => $categoryModels[$p['cat']]->id,
                'name' => $p['name'],
                'slug' => Str::slug($p['name']),
                'description' => $p['desc'],
                'features' => $p['features'],
                'image' => Str::slug($p['name']) . '.png',
                'base_price' => $p['price'],
                'min_qty' => 100
            ]);
        }

        // 4. Seed Leads
        Lead::create([
            'type' => 'quote',
            'name' => 'Alex Mercer',
            'email' => 'alex@mercerdesign.com',
            'phone' => '+1 (555) 019-2834',
            'company_name' => 'Mercer Apparel',
            'product_type' => 'Custom Mailer Boxes',
            'length' => 20.00,
            'width' => 15.00,
            'height' => 8.00,
            'material' => 'Kraft Paper',
            'quantity' => 500,
            'printing_required' => true,
            'lamination' => false,
            'embossing' => true,
            'foil_stamping' => false,
            'window_cutout' => false,
            'message' => 'Looking for organic brown mailer boxes with black ink logo printed on top lid.',
            'status' => 'New',
            'notes' => null
        ]);

        Lead::create([
            'type' => 'quote',
            'name' => 'Julia Roberts',
            'email' => 'julia@glambeauty.com',
            'phone' => '+1 (555) 043-9218',
            'company_name' => 'GlamBeauty Cosmetics',
            'product_type' => 'Cosmetic Tuck Top Boxes',
            'length' => 5.00,
            'width' => 5.00,
            'height' => 15.00,
            'material' => 'Cardboard',
            'quantity' => 2500,
            'printing_required' => true,
            'lamination' => true,
            'embossing' => false,
            'foil_stamping' => true,
            'window_cutout' => true,
            'message' => 'Need a circular window cutout on the front face and gold foil embossing on our logo.',
            'status' => 'Contacted',
            'notes' => 'Sent initial quote proposal of $0.32/unit. Waiting on artwork upload.'
        ]);

        Lead::create([
            'type' => 'contact',
            'name' => 'Robert Vance',
            'email' => 'rvance@vancerefrigeration.com',
            'phone' => '+1 (555) 098-7654',
            'company_name' => 'Vance Refrigeration',
            'message' => 'Do you ship custom pallets or heavy duty crates to Pennsylvania area?',
            'status' => 'Follow-Up',
            'notes' => 'Sales team needs to call him back to discuss freight pricing.'
        ]);

        // 5. Seed Orders
        Order::create([
            'user_id' => 4, // Customer account
            'product_name' => 'Custom Mailer Boxes',
            'length' => 25.00,
            'width' => 20.00,
            'height' => 10.00,
            'material' => 'Corrugated Board',
            'quantity' => 250,
            'printing_required' => true,
            'lamination' => true,
            'embossing' => false,
            'foil_stamping' => false,
            'window_cutout' => false,
            'total_price' => 387.50,
            'status' => 'Manufacturing',
            'notes' => 'Cardboard plates loaded. Press run scheduled for Monday morning.',
            'billing_name' => 'Standard Customer',
            'billing_email' => 'customer@packcraft.com',
            'billing_phone' => '+1 (555) 012-3456',
            'shipping_address' => '100 Packaging Way, Suite A, Box City, CA 90210'
        ]);

        Order::create([
            'user_id' => 4,
            'product_name' => 'Natural Kraft Folding Cartons',
            'length' => 10.00,
            'width' => 10.00,
            'height' => 4.00,
            'material' => 'Kraft Paper',
            'quantity' => 1000,
            'printing_required' => false,
            'lamination' => false,
            'embossing' => false,
            'foil_stamping' => false,
            'window_cutout' => false,
            'total_price' => 210.00,
            'status' => 'Shipped',
            'notes' => 'Shipped via UPS Freight. Tracking number: 1Z999AA10123456784.',
            'billing_name' => 'Standard Customer',
            'billing_email' => 'customer@packcraft.com',
            'billing_phone' => '+1 (555) 012-3456',
            'shipping_address' => '100 Packaging Way, Suite A, Box City, CA 90210'
        ]);

        // 6. Seed Blogs
        Blog::create([
            'title' => '5 Tips for Choosing Sustainable Packaging',
            'slug' => '5-tips-for-choosing-sustainable-packaging',
            'excerpt' => 'Eco-friendly boxes are no longer just a trend – they are a customer expectation. Here is how to make the transition.',
            'content' => 'In today’s consumer market, sustainability is a key decision factor. Choosing eco-friendly packaging does not mean you have to sacrifice durability or premium feel. 
            
            1. **Select Kraft Board**: Natural kraft cardboard is unbleached and highly recyclable. It communicates organic value immediately.
            2. **Watch Your Ink Choices**: Water-based or soy-based inks are much easier to process during recycling and contain lower VOCs.
            3. **Optimize Dimension Ratios**: Custom sizing reduces the need for bubble wrap or plastic void fill, saving shipping cost and waste.
            4. **Promote Reusability**: Design boxes that customers want to keep (such as rigid gift boxes with magnetic lids).
            5. **Educate Your Customers**: Print a small recycle logo or instructions on the box tab to encourage green disposal.',
            'image' => 'sustainable-packaging.jpg',
            'category' => 'Sustainable Packaging',
            'status' => 'published',
            'published_at' => now()
        ]);

        Blog::create([
            'title' => 'How to Measure Your Box for Custom Manufacturing',
            'slug' => 'how-to-measure-your-box-for-custom-manufacturing',
            'excerpt' => 'Avoid loose fits and damaged items. Learn how the packaging industry specifies length, width, and depth.',
            'content' => 'When specifying dimensions for custom box manufacturing, the industry standard is to measure **internal dimensions**. This ensures that your products fit snuggly and safely.

            Measurements must always be stated in this sequence:
            
            * **Length (L)**: The longer dimension of the box opening.
            * **Width (W)**: The shorter dimension of the box opening.
            * **Height (H)**: The vertical dimension from the bottom to the top opening.
            
            Using sliders on our platform, you can customize dimensions in centimeters down to decimal points. Remember to allow a 2mm tolerance buffer for wrapping tissue or cards!',
            'image' => 'box-measurements.jpg',
            'category' => 'Custom Packaging Guides',
            'status' => 'published',
            'published_at' => now()->subDays(2)
        ]);
    }
}
