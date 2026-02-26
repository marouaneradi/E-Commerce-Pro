<?php $__env->startSection('title', 'Products'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-page-header">
    <h1 class="admin-page-title">📦 Products</h1>
    <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary">+ Add Product</a>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <div class="table-toolbar" style="width:100%">
            <form action="<?php echo e(route('admin.products.index')); ?>" method="GET" style="display:flex;gap:.75rem;flex-wrap:wrap;">
                <div class="table-search">
                    <input type="text" name="search" placeholder="Search products..." value="<?php echo e(request('search')); ?>">
                    <button type="submit">🔍</button>
                </div>
                <select name="category" class="form-control" style="width:auto;" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category') == $cat->id ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php if(request()->hasAny(['search', 'category'])): ?>
                    <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-ghost btn-sm">Clear</a>
                <?php endif; ?>
            </form>
        </div>
    </div>
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:.75rem;">
                            <?php if($product->image): ?>
                                <img src="<?php echo e($product->image_url); ?>" class="image-preview" style="width:44px;height:44px;" alt="">
                            <?php else: ?>
                                <div style="width:44px;height:44px;border-radius:var(--radius);background:var(--bg);display:flex;align-items:center;justify-content:center;border:1px solid var(--border);font-size:1rem;">📦</div>
                            <?php endif; ?>
                            <div>
                                <div style="font-weight:600;font-size:.9rem;"><?php echo e($product->name); ?></div>
                                <?php if($product->sku): ?>
                                    <div style="font-size:.75rem;color:var(--text-muted);"><?php echo e($product->sku); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td><?php echo e($product->category->name ?? '—'); ?></td>
                    <td>
                        $<?php echo e(number_format($product->price, 2)); ?>

                        <?php if($product->compare_price): ?>
                            <br><small style="text-decoration:line-through;color:var(--text-muted);">$<?php echo e(number_format($product->compare_price, 2)); ?></small>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span style="font-weight:600;color:<?php echo e($product->stock <= 5 ? 'var(--danger)' : ($product->stock <= 20 ? 'var(--warning)' : 'var(--accent)')); ?>;">
                            <?php echo e($product->stock); ?>

                        </span>
                    </td>
                    <td>
                        <span class="status-badge" style="background:<?php echo e($product->is_active ? '#d1fae5' : '#fee2e2'); ?>;color:<?php echo e($product->is_active ? '#065f46' : '#991b1b'); ?>;">
                            <?php echo e($product->is_active ? '✓ Active' : '✗ Inactive'); ?>

                        </span>
                        <?php if($product->is_featured): ?>
                            <span class="status-badge" style="background:#fef3c7;color:#92400e;margin-left:.25rem;">⭐ Featured</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($product->reviews_count > 0): ?>
                            ⭐ <?php echo e(number_format($product->average_rating, 1)); ?> (<?php echo e($product->reviews_count); ?>)
                        <?php else: ?>
                            <span style="color:var(--text-muted);">No reviews</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div style="display:flex;gap:.375rem;">
                            <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="btn btn-ghost btn-sm btn-icon" title="View" target="_blank">👁️</a>
                            <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="btn btn-outline btn-sm">Edit</a>
                            <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm" data-confirm="Delete this product?">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" style="text-align:center;padding:3rem;color:var(--text-muted);">
                        No products found. <a href="<?php echo e(route('admin.products.create')); ?>" style="color:var(--primary);">Add one?</a>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="pagination"><?php echo e($products->links('partials.pagination')); ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\radim\Downloads\ecommerce-pro\ecommerce-pro-v4\resources\views/admin/products/index.blade.php ENDPATH**/ ?>