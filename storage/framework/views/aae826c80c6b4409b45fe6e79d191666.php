<?php $__env->startSection('title', 'Orders'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-page-header">
    <h1 class="admin-page-title">🛒 Orders</h1>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <form action="<?php echo e(route('admin.orders.index')); ?>" method="GET" style="display:flex;gap:.75rem;flex-wrap:wrap;">
            <div class="table-search">
                <input type="text" name="search" placeholder="Order # or email..." value="<?php echo e(request('search')); ?>">
                <button type="submit">🔍</button>
            </div>
            <select name="status" class="form-control" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <?php $__currentLoopData = ['pending','processing','shipped','delivered','cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s); ?>" <?php echo e(request('status') === $s ? 'selected' : ''); ?>><?php echo e(ucfirst($s)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php if(request()->hasAny(['search', 'status'])): ?>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-ghost btn-sm">Clear</a>
            <?php endif; ?>
        </form>
    </div>
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><strong style="color:var(--primary);"><?php echo e($order->order_number); ?></strong></td>
                    <td>
                        <div><?php echo e($order->first_name); ?> <?php echo e($order->last_name); ?></div>
                        <div style="font-size:.78rem;color:var(--text-muted);"><?php echo e($order->email); ?></div>
                    </td>
                    <td><?php echo e($order->created_at->format('M d, Y')); ?></td>
                    <td><strong>$<?php echo e(number_format($order->total, 2)); ?></strong></td>
                    <td><span class="status-badge status-<?php echo e($order->status); ?>"><?php echo e(ucfirst($order->status)); ?></span></td>
                    <td><span class="status-badge status-<?php echo e($order->payment_status); ?>"><?php echo e(ucfirst($order->payment_status)); ?></span></td>
                    <td><a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn btn-outline btn-sm">View →</a></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" style="text-align:center;padding:3rem;color:var(--text-muted);">No orders found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="pagination"><?php echo e($orders->links('partials.pagination')); ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\radim\Downloads\ecommerce-pro\ecommerce-pro-v4\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>