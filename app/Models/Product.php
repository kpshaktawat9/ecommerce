<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'name',
        'slug',
        'sku',
        'item_code',
        'keywords',
        'description',
        'image',
        'category_id',
        'brand_id',
        'tex_id',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tex_id');
    }

    public function productAttrs()
    {
        return $this->hasMany(ProductAttr::class);
    }

    
}
