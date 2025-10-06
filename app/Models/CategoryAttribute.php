<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryAttribute extends Model
{
    //
    protected $fillable = [
        'category_id',
        'attribute_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
}
