<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-card">
    <div class="auth-logo">
        <div class="logo">🛒 ECommerce Pro</div>
        <p>Welcome back! Sign in to your account.</p>
    </div>

    <?php if(session('status')): ?>
        <div class="alert alert-success"><?php echo e(session('status')); ?></div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-error"><?php echo e($errors->first()); ?></div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login')); ?>">
        <?php echo csrf_field(); ?>

        <div class="form-group">
            <label class="form-label" for="email">Email Address <span class="required">*</span></label>
            <input type="email" id="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                value="<?php echo e(old('email')); ?>" placeholder="you@example.com" required autofocus>
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.5rem;">
                <label class="form-label" for="password" style="margin:0;">Password <span class="required">*</span></label>
                <?php if(Route::has('password.request')): ?>
                    <a href="<?php echo e(route('password.request')); ?>" style="font-size:.8rem;color:var(--primary);font-weight:600;">Forgot password?</a>
                <?php endif; ?>
            </div>
            <input type="password" id="password" name="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                placeholder="Your password" required>
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group" style="display:flex;align-items:center;gap:.5rem;">
            <input type="checkbox" name="remember" id="remember" style="accent-color:var(--primary);">
            <label for="remember" style="font-size:.875rem;color:var(--text-secondary);cursor:pointer;">Remember me</label>
        </div>

        <button type="submit" class="btn btn-primary btn-block btn-lg">Sign In</button>
    </form>

    <div class="auth-footer">
        Don't have an account? <a href="<?php echo e(route('register')); ?>">Create one free</a>
    </div>

    <div style="margin-top:1.5rem;padding:1rem;background:var(--bg);border-radius:var(--radius);border:1px solid var(--border);">
        <p style="font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:.5rem;">Demo Accounts</p>
        <p style="font-size:.8rem;color:var(--text-secondary);">Admin: <strong>admin@example.com</strong> / password</p>
        <p style="font-size:.8rem;color:var(--text-secondary);">User: <strong>user1@example.com</strong> / password</p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\radim\Downloads\ecommerce-pro\ecommerce-pro-v4\resources\views/auth/login.blade.php ENDPATH**/ ?>