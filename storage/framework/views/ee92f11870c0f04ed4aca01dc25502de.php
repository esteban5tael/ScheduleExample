<?php $__env->startSection('title'); ?>
    <?php echo e(config('app.name')); ?> - Calendario de Citas
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h3 class="text-center mb-4"><?php echo e(config('app.name')); ?> - Calendario de Citas</h3>

    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Domingo</th>
                    <th>Lunes</th>
                    <th>Martes</th>
                    <th>Miércoles</th>
                    <th>Jueves</th>
                    <th>Viernes</th>
                    <th>Sábado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $currentDay = 1;
                    $lastDayOfMonth = now()->year(2024)->month(11)->endOfMonth()->day;
                    $dayOfWeek = now()->year(2024)->month(11)->day(1)->dayOfWeek;
                ?>

                
                <tr>
                    <?php for($i = 0; $i < $dayOfWeek; $i++): ?>
                        <td></td>
                    <?php endfor; ?>

                    
                    <?php while($currentDay <= $lastDayOfMonth): ?>
                        
                        <?php if($dayOfWeek == 0 && $currentDay != 1): ?>
                            </tr><tr>
                        <?php endif; ?>

                        
                        <td>
                            <div class="fw-bold"><?php echo e($currentDay); ?></div>

                            
                            <?php
                                $dailySchedules = $schedules->filter(function ($schedule) use ($currentDay) {
                                    return $schedule->day == $currentDay;
                                });
                            ?>

                            <?php $__empty_1 = true; $__currentLoopData = $dailySchedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="mt-1 <?php echo e($schedule->taken ? 'bg-danger text-white' : 'bg-success text-white'); ?> p-2 rounded">
                                    <?php echo e($schedule->start); ?> - <?php echo e($schedule->end); ?>

                                    <span><?php echo e($schedule->taken ? 'Ocupada' : 'Disponible'); ?></span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <small class="text-muted">Sin citas</small>
                            <?php endif; ?>
                        </td>

                        
                        <?php
                            $currentDay++;
                            $dayOfWeek = ($dayOfWeek + 1) % 7;
                        ?>
                    <?php endwhile; ?>

                    
                    <?php for($i = $dayOfWeek; $i < 7 && $dayOfWeek != 0; $i++): ?>
                        <td></td>
                    <?php endfor; ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\ScheduleExample\resources\views/index.blade.php ENDPATH**/ ?>