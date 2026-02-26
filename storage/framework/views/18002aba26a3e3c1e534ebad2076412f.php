<?php $__env->startSection('title', 'Shop - All Products'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="<?php echo e(route('home')); ?>">Home</a>
            <span class="breadcrumb-sep">›</span>
            <span class="breadcrumb-current">Shop</span>
            <?php if(request('search')): ?>
                <span class="breadcrumb-sep">›</span>
                <span class="breadcrumb-current">Search: "<?php echo e(request('search')); ?>"</span>
            <?php endif; ?>
        </div>
        <h1><?php echo e(request('search') ? 'Search Results' : (request('category') ? ucfirst(str_replace('-', ' ', request('category'))) : 'All Products')); ?></h1>
        <p><?php echo e($products->total()); ?> products found</p>
    </div>
</div>

<div class="container">
    <div class="shop-layout">
        
        <aside class="filter-sidebar">
            <form action="<?php echo e(route('products.index')); ?>" method="GET" id="filterForm">
                <?php if(request('search')): ?>
                    <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                <?php endif; ?>

                <div class="filter-group">
                    <div class="filter-title">Categories</div>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label>
                        <input type="radio" name="category" value="<?php echo e($cat->slug); ?>"
                            <?php echo e(request('category') === $cat->slug ? 'checked' : ''); ?>

                            onchange="document.getElementById('filterForm').submit()">
                        <?php echo e($cat->name); ?>

                        <span style="margin-left:auto;color:var(--text-muted);font-size:.75rem;">(<?php echo e($cat->active_products_count); ?>)</span>
                    </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if(request('category')): ?>
                        <a href="<?php echo e(route('products.index', array_except(request()->query(), 'category'))); ?>" class="btn btn-ghost btn-sm" style="margin-top:.5rem;font-size:.8rem;">✕ Clear Category</a>
                    <?php endif; ?>
                </div>

                <div class="filter-group">
                    <div class="filter-title">Price Range</div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
                        <div>
                            <label class="form-label" style="font-size:.75rem;">Min</label>
                            <input type="number" name="min_price" class="form-control form-control-sm" placeholder="$0" value="<?php echo e(request('min_price')); ?>" style="padding:.5rem;">
                        </div>
                        <div>
                            <label class="form-label" style="font-size:.75rem;">Max</label>
                            <input type="number" name="max_price" class="form-control form-control-sm" placeholder="$999" value="<?php echo e(request('max_price')); ?>" style="padding:.5rem;">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm btn-block" style="margin-top:.75rem;">Apply Filter</button>
                </div>

                <div class="filter-group">
                    <div class="filter-title">Sort By</div>
                    <div style="display:flex;flex-direction:column;gap:.5rem;">
                        <?php $__currentLoopData = ['latest' => 'Newest First', 'price_asc' => 'Price: Low to High', 'price_desc' => 'Price: High to Low', 'rating' => 'Top Rated', 'name_asc' => 'Name A-Z']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;font-size:.875rem;">
                            <input type="radio" name="sort" value="<?php echo e($value); ?>"
                                <?php echo e(request('sort', 'latest') === $value ? 'checked' : ''); ?>

                                onchange="document.getElementById('filterForm').submit()">
                            <?php echo e($label); ?>

                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <?php if(request()->hasAny(['category', 'min_price', 'max_price', 'sort', 'search'])): ?>
                    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-ghost btn-sm btn-block">✕ Clear All Filters</a>
                <?php endif; ?>
            </form>
        </aside>

        
        <div>
            <?php if($products->isEmpty()): ?>
                <div class="empty-state card">
                    <div class="card-body">
                        <div class="empty-state-icon">📦</div>
                        <h3>No products found</h3>
                        <p>Try adjusting your filters or search terms.</p>
                        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary">Browse All Products</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="products-grid">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('partials.product-card', ['product' => $product], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                
                <div class="pagination">
                    <?php echo e($products->links('partials.pagination')); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\radim\Downloads\ecommerce-pro\ecommerce-pro-v4\resources\views/products/index.blade.php ENDPATH**/ ?>