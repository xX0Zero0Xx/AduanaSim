<section aria-labelledby="user-information-heading">
    <header>
        <h2 id="user-information-heading" class="text-lg font-medium text-gray-900">
            <?php echo e(__('Datos del usuario')); ?>

        </h2>
        <p class="mt-1 text-sm text-gray-600">
            <?php echo e(__('Información asociada a tu cuenta.')); ?>

        </p>
    </header>

    <dl class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="rounded-md bg-gray-50 p-4">
            <dt class="text-sm font-medium text-gray-500"><?php echo e(__('Nombre')); ?></dt>
            <dd class="mt-1 text-sm text-gray-900"><?php echo e($user->name); ?></dd>
        </div>

        <div class="rounded-md bg-gray-50 p-4">
            <dt class="text-sm font-medium text-gray-500"><?php echo e(__('Correo electrónico')); ?></dt>
            <dd class="mt-1 break-all text-sm text-gray-900"><?php echo e($user->email); ?></dd>
        </div>

        <div class="rounded-md bg-gray-50 p-4">
            <dt class="text-sm font-medium text-gray-500"><?php echo e(__('Rol')); ?></dt>
            <dd class="mt-1 text-sm text-gray-900"><?php echo e(ucfirst($user->rol)); ?></dd>
        </div>

        <div class="rounded-md bg-gray-50 p-4">
            <dt class="text-sm font-medium text-gray-500"><?php echo e(__('Fecha de registro')); ?></dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?php echo e($user->created_at?->format('d/m/Y') ?? __('No disponible')); ?>

            </dd>
        </div>

        <div class="rounded-md bg-gray-50 p-4 sm:col-span-2">
            <dt class="text-sm font-medium text-gray-500"><?php echo e(__('Estado del correo')); ?></dt>
            <dd class="mt-1 text-sm <?php echo e($user->email_verified_at ? 'text-green-700' : 'text-amber-700'); ?>">
                <?php echo e($user->email_verified_at ? __('Verificado') : __('Sin verificar')); ?>

            </dd>
        </div>
    </dl>
</section>
<?php /**PATH /home/lozada/Escritorio/AduanaSim/resources/views/profile/partials/show-information-from.blade.php ENDPATH**/ ?>