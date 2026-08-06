<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'email',
        'phone',
        'company_name',
        'product_type',
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
        'message',
        'status',
        'notes'
    ];

    protected $casts = [
        'printing_required' => 'boolean',
        'lamination' => 'boolean',
        'embossing' => 'boolean',
        'foil_stamping' => 'boolean',
        'window_cutout' => 'boolean',
        'length' => 'decimal:2',
        'width' => 'decimal:2',
        'height' => 'decimal:2',
        'quantity' => 'integer',
    ];
}
