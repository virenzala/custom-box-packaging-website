<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('quote'); // 'quote' or 'contact'
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company_name')->nullable();
            $table->string('product_type')->nullable(); // e.g. Mailer Box, Kraft Box, etc.
            
            // Box customization dimensions
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->string('material')->nullable(); // Corrugated, Kraft, Cardboard, Rigid
            $table->integer('quantity')->nullable();
            
            // Additional Options
            $table->boolean('printing_required')->default(false);
            $table->boolean('lamination')->default(false);
            $table->boolean('embossing')->default(false);
            $table->boolean('foil_stamping')->default(false);
            $table->boolean('window_cutout')->default(false);
            
            $table->text('message')->nullable();
            $table->string('status')->default('New'); // New, Contacted, Follow-Up, Converted, Closed
            $table->text('notes')->nullable(); // Admin annotations
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
