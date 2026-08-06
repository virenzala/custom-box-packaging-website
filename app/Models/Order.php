<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_name',
        'length',
        'width',
        'height',
        'material',
        'quantity',
        'printing_required',
        'lamination',
        'embossing',
        'foil_stamping',
        'window_cutout',
        'total_price',
        'status',
        'notes',
        'billing_name',
        'billing_email',
        'billing_phone',
        'shipping_address'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'length' => 'decimal:2',
        'width' => 'decimal:2',
        'height' => 'decimal:2',
        'quantity' => 'integer',
        'printing_required' => 'boolean',
        'lamination' => 'boolean',
        'embossing' => 'boolean',
        'foil_stamping' => 'boolean',
        'window_cutout' => 'boolean',
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
