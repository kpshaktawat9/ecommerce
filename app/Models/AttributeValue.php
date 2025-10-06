<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    //
    protected $fillable = ['name', 'attribute_id'];

    public function singleAttribute()
    {
        return $this->hasOne(Attribute::class,'id','attribute_id');
    }
}
