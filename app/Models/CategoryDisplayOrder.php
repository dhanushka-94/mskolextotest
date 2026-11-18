<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryDisplayOrder extends Model
{
    protected $table = 'category_display_orders';

    protected $fillable = [
        'category_id',
        'parent_id',
        'sort_order',
    ];

    protected $casts = [
        'category_id' => 'integer',
        'parent_id' => 'integer',
        'sort_order' => 'integer',
    ];
}
