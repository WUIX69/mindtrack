<?php
/**
 * Shared Progress Stepper Component
 * 
 * @param int $currentStep (1, 2, or 3)
 * @param string $title
 */
$currentStep = $currentStep ?? 1;
$title = $title ?? 'Select Service';
$steps = [
    1 => 'Service',
    2 => 'Schedule',
    3 => 'Confirmation'
];
$percentage = ($currentStep / 3) * 100;
?>

<div class="flex flex-col gap-4 mt-8 mb-10 w-full">
    <div class="flex justify-between items-center mb-2">
        <div class="flex items-center gap-3">
            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-primary text-white font-bold text-sm">
                <?= $currentStep ?>
            </span>
            <span class="text-foreground font-bold text-lg">
                <?= $title ?>
            </span>
        </div>
        <div class="text-right">
            <span class="text-muted-foreground text-sm font-medium">Step
                <?= $currentStep ?> of 3
            </span>
            <?php if ($currentStep > 1): ?>
                <p class="text-primary text-xs font-bold">
                    <?= round($percentage) ?>% Complete
                </p>
            <?php endif; ?>
        </div>
    </div>

    <div class="w-full bg-muted dark:bg-zinc-800 h-2 rounded-full overflow-hidden">
        <div class="bg-primary h-full transition-all duration-500 rounded-full" style="width: <?= $percentage ?>%;">
        </div>
    </div>

    <div class="flex justify-between text-[10px] font-bold uppercase tracking-widest text-muted-foreground">
        <?php foreach ($steps as $num => $label): ?>
            <span class="<?= $currentStep >= $num ? 'text-primary' : 'opacity-50' ?>">
                <?= $num ?>.
                <?= $label ?>
            </span>
        <?php endforeach; ?>
    </div>
</div>