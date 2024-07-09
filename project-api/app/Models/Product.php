<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'product_category_id',
        'price',
        'description',
    ];

    /**
     * @return HasOne<ProductCategory>
     */
    public function category(): HasOne
    {
        return $this->hasOne(ProductCategory::class, 'id', 'product_category_id');
    }
}
