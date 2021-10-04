<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;   
    protected $fillable = ['name', 'description','brand_id','subcategory_id', 'enabled', 'image']; 
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    } 
    public function product_options()
    {
        return $this->hasMany(ProductOption::class);
    }  
}