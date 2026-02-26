<?php $__env->startSection('title', 'Home - Premium Shopping'); ?>

<?php $__env->startSection('content'); ?>


<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge">✨ New Collection Available</div>
            <h1>Shop the <span>Best Products</span> Online</h1>
            <p>Discover thousands of premium products with unbeatable prices, fast shipping, and exceptional quality.</p>
            <div class="hero-actions">
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-white btn-lg">🛍️ Shop Now</a>
                <a href="<?php echo e(route('products.index', ['sort' => 'rating'])); ?>" class="btn btn-outline btn-lg" style="border-color:rgba(255,255,255,.5);color:white;">⭐ Top Rated</a>
            </div>
        </div>
    </div>
</section>


<section class="py-8">
    <div class="container">
        <div class="section-header">
            <div>
                <h2 class="section-title">Shop by <span>Category</span></h2>
                <p class="section-subtitle">Find exactly what you're looking for</p>
            </div>
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline btn-sm">View All →</a>
        </div>

        <div class="categories-grid">
            <?php
            $icons = ['Electronics' => '📱', 'Clothing' => '👕', 'Books' => '📚', 'Home & Garden' => '🏠', 'Sports' => '⚽', 'Beauty' => '💄', 'Toys' => '🧸', 'Food' => '🍕', 'Automotive' => '🚗', 'Health' => '💊'];
            ?>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('products.index', ['category' => $category->slug])); ?>" class="category-card">
                <div class="category-icon">
                    <?php echo e($icons[$category->name] ?? '🏷️'); ?>

                </div>
                <span class="category-name"><?php echo e($category->name); ?></span>
                <span class="category-count"><?php echo e($category->active_products_count ?? 0); ?> Products</span>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>


<section class="py-8" style="background:var(--bg-card);border-top:1px solid var(--border);border-bottom:1px solid var(--border);">
    <div class="container">
        <div class="section-header">
            <div>
                <h2 class="section-title">⭐ Featured <span>Products</span></h2>
                <p class="section-subtitle">Handpicked products just for you</p>
            </div>
            <a href="<?php echo e(route('products.index', ['sort' => 'rating'])); ?>" class="btn btn-outline btn-sm">See All →</a>
        </div>

        <div class="products-grid">
            <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('partials.product-card', ['product' => $product], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>


<section class="py-8">
    <div class="container">
        <div class="section-header">
            <div>
                <h2 class="section-title">🆕 New <span>Arrivals</span></h2>
                <p class="section-subtitle">Fresh products added this week</p>
            </div>
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline btn-sm">View All →</a>
        </div>

        <div class="products-grid">
            <?php $__currentLoopData = $latestProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('partials.product-card', ['product' => $product], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>


<section class="py-8" style="background:linear-gradient(135deg,#1e1b4b,#312e81);color:white;">
    <div class="container">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:2rem;text-align:center;">
            <div>
                <div style="font-size:2.5rem;margin-bottom:.75rem;">🚀</div>
                <h3 style="font-size:1.125rem;font-weight:700;margin-bottom:.375rem;">Fast Delivery</h3>
                <p style="opacity:.75;font-size:.875rem;">Free shipping on orders over $100</p>
            </div>
            <div>
                <div style="font-size:2.5rem;margin-bottom:.75rem;">🔒</div>
                <h3 style="font-size:1.125rem;font-weight:700;margin-bottom:.375rem;">Secure Payment</h3>
                <p style="opacity:.75;font-size:.875rem;">100% secure transactions</p>
            </div>
            <div>
                <div style="font-size:2.5rem;margin-bottom:.75rem;">↩️</div>
                <h3 style="font-size:1.125rem;font-weight:700;margin-bottom:.375rem;">Easy Returns</h3>
                <p style="opacity:.75;font-size:.875rem;">30 day return policy</p>
            </div>
            <div>
                <div style="font-size:2.5rem;margin-bottom:.75rem;">💬</div>
                <h3 style="font-size:1.125rem;font-weight:700;margin-bottom:.375rem;">24/7 Support</h3>
                <p style="opacity:.75;font-size:.875rem;">Always here to help you</p>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\radim\Downloads\ecommerce-pro\ecommerce-pro-v4\resources\views/home.blade.php ENDPATH**/ ?>