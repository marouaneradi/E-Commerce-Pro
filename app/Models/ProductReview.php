<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'user_id', 'rating', 'title', 'body', 'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'rating' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($review) {
            $review->updateProductRating();
        });

        static::deleted(function ($review) {
            $review->updateProductRating();
        });
    }

    protected function updateProductRating(): void
    {
        $product = $this->product;
        if ($product) {
            $avg = ProductReview::where('product_id', $this->product_id)
                ->where('is_approved', true)
                ->avg('rating');
            $count = ProductReview::where('product_id', $this->product_id)
                ->where('is_approved', true)
                ->count();
            $product->update(['average_rating' => round($avg ?? 0, 2), 'reviews_count' => $count]);
        }
    }
}
