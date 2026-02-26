<?php $__env->startSection('title', 'Categories'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-page-header">
    <h1 class="admin-page-title">🏷️ Categories</h1>
    <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary">+ Add Category</a>
</div>

<div class="admin-card">
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Products</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:.75rem;">
                            <?php if($category->image): ?>
                                <img src="<?php echo e($category->image_url); ?>" style="width:40px;height:40px;border-radius:var(--radius-sm);object-fit:cover;border:1px solid var(--border);" alt="">
                            <?php else: ?>
                                <div style="width:40px;height:40px;border-radius:var(--radius-sm);background:rgba(99,102,241,.1);display:flex;align-items:center;justify-content:center;font-size:1.25rem;">🏷️</div>
                            <?php endif; ?>
                            <strong><?php echo e($category->name); ?></strong>
                        </div>
                    </td>
                    <td style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:var(--text-muted);"><?php echo e($category->description ?? '—'); ?></td>
                    <td><?php echo e($category->products_count ?? 0); ?></td>
                    <td><?php echo e($category->sort_order); ?></td>
                    <td>
                        <span class="status-badge" style="background:<?php echo e($category->is_active ? '#d1fae5' : '#fee2e2'); ?>;color:<?php echo e($category->is_active ? '#065f46' : '#991b1b'); ?>;">
                            <?php echo e($category->is_active ? 'Active' : 'Inactive'); ?>

                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:.375rem;">
                            <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" class="btn btn-outline btn-sm">Edit</a>
                            <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm" data-confirm="Delete this category?">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" style="text-align:center;padding:3rem;color:var(--text-muted);">No categories found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="pagination"><?php echo e($categories->links('partials.pagination')); ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\radim\Downloads\ecommerce-pro\ecommerce-pro-v4\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>