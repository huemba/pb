<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'search_key','order_index','show_in_list'];
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
