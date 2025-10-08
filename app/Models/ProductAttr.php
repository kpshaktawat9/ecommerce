<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttr extends Model
{
    //
    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'price',
        'mrp',
        'qty',
        'sku',
        'length',
        'weight',
        'height',
        'width',
        'breadth',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}
