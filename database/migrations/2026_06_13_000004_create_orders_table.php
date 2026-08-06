<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('product_name');
            
            // Box customization details
            $table->decimal('length', 8, 2);
            $table->decimal('width', 8, 2);
            $table->decimal('height', 8, 2);
            $table->string('material');
            $table->integer('quantity');
            
            // Finishings
            $table->boolean('printing_required')->default(false);
            $table->boolean('lamination')->default(false);
            $table->boolean('embossing')->default(false);
            $table->boolean('foil_stamping')->default(false);
            $table->boolean('window_cutout')->default(false);
            
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('Pending'); // Pending, Processing, Approved, Manufacturing, Shipped, Delivered, Cancelled
            $table->text('notes')->nullable();
            
            // Customer Info
            $table->string('billing_name');
            $table->string('billing_email');
            $table->string('billing_phone');
            $table->text('shipping_address');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
