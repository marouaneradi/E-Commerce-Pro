<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'short_description',
        'price', 'compare_price', 'stock', 'sku', 'image', 'gallery',
        'is_active', 'is_featured', 'average_rating', 'reviews_count',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'average_rating' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'gallery' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(ProductReview::class)->where('is_approved', true);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/product-placeholder.jpg');
    }

    public function getDiscountPercentageAttribute(): ?int
    {
        if ($this->compare_price && $this->compare_price > $this->price) {
            return (int) round((($this->compare_price - $this->price) / $this->compare_price) * 100);
        }
        return null;
    }

    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('sku', 'like', "%{$search}%");
        });
    }
}
