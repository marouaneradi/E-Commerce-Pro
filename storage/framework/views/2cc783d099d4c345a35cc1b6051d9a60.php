<?php
    $discount = $product->discount_percentage;
?>

<div class="product-card">
    <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="product-image-wrap">
        <?php if($product->image): ?>
            <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->name); ?>" loading="lazy">
        <?php else: ?>
            <div class="product-placeholder">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                </svg>
            </div>
        <?php endif; ?>

        <?php if($product->is_featured): ?>
            <span class="product-badge badge-featured">⭐ Featured</span>
        <?php elseif($discount): ?>
            <span class="product-badge badge-sale">-<?php echo e($discount); ?>%</span>
        <?php elseif($product->created_at->isAfter(now()->subDays(7))): ?>
            <span class="product-badge badge-new">New</span>
        <?php endif; ?>

        <?php if(!$product->isInStock()): ?>
            <span class="product-badge badge-out" style="top:auto;bottom:.75rem;left:.75rem;">Out of Stock</span>
        <?php endif; ?>
    </a>

    <div class="product-info">
        <div class="product-category"><?php echo e($product->category->name ?? ''); ?></div>
        <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="product-name"><?php echo e($product->name); ?></a>

        <?php if($product->reviews_count > 0): ?>
        <div class="product-rating">
            <span class="stars">
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <?php echo e($i <= round($product->average_rating) ? '★' : '☆'); ?>

                <?php endfor; ?>
            </span>
            <span class="rating-count">(<?php echo e($product->reviews_count); ?>)</span>
        </div>
        <?php endif; ?>

        <div class="product-price-row">
            <span class="price-current">$<?php echo e(number_format($product->price, 2)); ?></span>
            <?php if($product->compare_price): ?>
                <span class="price-compare">$<?php echo e(number_format($product->compare_price, 2)); ?></span>
                <?php if($discount): ?>
                    <span class="price-discount">Save <?php echo e($discount); ?>%</span>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="product-card-footer">
        <?php if($product->isInStock()): ?>
            <form action="<?php echo e(route('cart.add')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                <button type="submit" class="btn btn-primary btn-sm" style="width:100%">🛒 Add to Cart</button>
            </form>
        <?php else: ?>
            <button class="btn btn-ghost btn-sm" style="width:100%" disabled>Out of Stock</button>
        <?php endif; ?>
        <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="btn btn-outline btn-sm btn-icon" title="View Details">👁️</a>
    </div>
</div>
<?php /**PATH C:\Users\radim\Downloads\ecommerce-pro\ecommerce-pro-v4\resources\views/partials/product-card.blade.php ENDPATH**/ ?>