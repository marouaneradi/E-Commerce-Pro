<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title'); ?> | E-Commerce Pro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="<?php echo e(route('home')); ?>" class="navbar-brand">🛒 <span>E</span>Commerce Pro</a>
            <div class="navbar-actions">
                <button class="dark-toggle" aria-label="Toggle dark mode"></button>
                <a href="<?php echo e(route('home')); ?>" class="btn btn-ghost" style="color:rgba(255,255,255,.8);">← Back to Store</a>
            </div>
        </div>
    </nav>

    <div class="main-content">
        <div class="auth-wrapper">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\radim\Downloads\ecommerce-pro\ecommerce-pro-v4\resources\views/layouts/auth.blade.php ENDPATH**/ ?>