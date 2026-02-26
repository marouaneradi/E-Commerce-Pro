<?php $__env->startSection('title', 'My Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="container">
        <h1>📊 My Dashboard</h1>
        <p>Welcome back, <?php echo e($user->name); ?>!</p>
    </div>
</div>

<div class="container">
    
    <div class="stats-grid" style="margin-bottom:2rem;">
        <div class="stat-card">
            <div class="stat-icon primary">📦</div>
            <div class="stat-info">
                <div class="stat-label">Total Orders</div>
                <div class="stat-value"><?php echo e($totalOrders); ?></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success">💰</div>
            <div class="stat-info">
                <div class="stat-label">Total Spent</div>
                <div class="stat-value">$<?php echo e(number_format($totalSpent, 0)); ?></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon secondary">⭐</div>
            <div class="stat-info">
                <div class="stat-label">Member Since</div>
                <div class="stat-value" style="font-size:1.1rem;"><?php echo e($user->created_at->format('M Y')); ?></div>
            </div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;align-items:start;">
        
        <div class="card">
            <div class="card-header">
                <h3>📦 Recent Orders</h3>
                <a href="<?php echo e(route('user.orders')); ?>" class="btn btn-outline btn-sm">View All</a>
            </div>
            <?php if($recentOrders->isEmpty()): ?>
                <div class="card-body">
                    <div class="empty-state">
                        <div class="empty-state-icon">📦</div>
                        <h3>No orders yet</h3>
                        <p>Start shopping to see your orders here.</p>
                        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary">Start Shopping</a>
                    </div>
                </div>
            <?php else: ?>
                <div style="overflow-x:auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><strong style="color:var(--primary);"><?php echo e($order->order_number); ?></strong></td>
                                <td><?php echo e($order->created_at->format('M d, Y')); ?></td>
                                <td>$<?php echo e(number_format($order->total, 2)); ?></td>
                                <td><span class="status-badge status-<?php echo e($order->status); ?>"><?php echo e(ucfirst($order->status)); ?></span></td>
                                <td><a href="<?php echo e(route('user.order-detail', $order->order_number)); ?>" class="btn btn-ghost btn-sm">View →</a></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        
        <div class="card">
            <div class="card-header"><h3>👤 Profile</h3></div>
            <div class="card-body" style="text-align:center;">
                <img src="<?php echo e($user->avatar_url); ?>" alt="<?php echo e($user->name); ?>" style="width:80px;height:80px;border-radius:50%;object-fit:cover;margin:0 auto 1rem;border:3px solid var(--primary);">
                <h3 style="font-weight:700;margin-bottom:.25rem;"><?php echo e($user->name); ?></h3>
                <p style="color:var(--text-muted);font-size:.875rem;margin-bottom:1.25rem;"><?php echo e($user->email); ?></p>
                <?php if($user->phone): ?>
                    <p style="font-size:.875rem;color:var(--text-secondary);margin-bottom:.5rem;">📞 <?php echo e($user->phone); ?></p>
                <?php endif; ?>
                <?php if($user->address): ?>
                    <p style="font-size:.875rem;color:var(--text-secondary);margin-bottom:.5rem;">📍 <?php echo e($user->address); ?></p>
                <?php endif; ?>
                <?php if(!$user->hasVerifiedEmail()): ?>
                    <div class="alert alert-warning" style="font-size:.8rem;">⚠️ Email not verified</div>
                <?php endif; ?>
                <a href="<?php echo e(route('user.settings')); ?>" class="btn btn-outline btn-block" style="margin-top:1rem;">Edit Profile ✏️</a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\radim\Downloads\ecommerce-pro\ecommerce-pro-v4\resources\views/user/dashboard.blade.php ENDPATH**/ ?>