<?php if(session('status')): ?>
    <div class="aduana-alert aduana-alert--ok" role="status"><?php echo e(session('status')); ?></div>
<?php endif; ?>
<?php if(session('error')): ?>
    <div class="aduana-alert aduana-alert--danger" role="alert"><?php echo e(session('error')); ?></div>
<?php endif; ?>
<?php if($errors->any()): ?>
    <div class="aduana-alert aduana-alert--danger" role="alert">
        <strong>Revisa los datos:</strong>
        <ul class="mt-1 list-disc list-inside text-sm">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>
<?php /**PATH /home/lozada/Escritorio/AduanaSim/resources/views/capturista/partials/flash.blade.php ENDPATH**/ ?>