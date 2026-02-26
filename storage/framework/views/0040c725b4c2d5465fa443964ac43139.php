<?php if($paginator->hasPages()): ?>
    <?php if($paginator->onFirstPage()): ?>
        <span>‹</span>
    <?php else: ?>
        <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev">‹</a>
    <?php endif; ?>

    <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(is_string($element)): ?>
            <span><?php echo e($element); ?></span>
        <?php endif; ?>

        <?php if(is_array($element)): ?>
            <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($page == $paginator->currentPage()): ?>
                    <span class="active"><?php echo e($page); ?></span>
                <?php else: ?>
                    <a href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php if($paginator->hasMorePages()): ?>
        <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next">›</a>
    <?php else: ?>
        <span>›</span>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\Users\radim\Downloads\ecommerce-pro\ecommerce-pro-v4\resources\views/partials/pagination.blade.php ENDPATH**/ ?>