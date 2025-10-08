<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = [
        'name',
        'slug',
        'image',
        'parent_category_id',
    ];

    public function parentCategory()
    {
        return $this->hasOne(Category::class,'id','parent_category_id');
    }

    // A category can have many category attributes
    public function categoryAttributes()
    {
        return $this->hasMany(CategoryAttribute::class, 'category_id');
    }
}
