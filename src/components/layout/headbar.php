<?php
/**
 * Shared Headbar Component
 * 
 * @param string $title - Main page title
 * @param string $description - Sub-title description
 * @param string $searchPlaceholder - If provided, shows a search input
 * @param string $actionLabel - Label for the primary action button
 * @param string $actionIcon - Material icon name for the action button
 * @param string $actionUrl - URL for the action button (or '#' for button)
 * @param string $role - User role (admin, patient, doctor)
 * @param int $mb - Margin bottom utility (default: 8)
 * @param string $extraContent - HTML for additional actions or items
 */

$title = $title ?? '';
$description = $description ?? '';
$searchPlaceholder = $searchPlaceholder ?? '';
$actionLabel = $actionLabel ?? '';
$actionIcon = $actionIcon ?? 'add_circle';
$actionUrl = $actionUrl ?? '#';
$actionClass = $actionClass ?? 'bg-primary hover:bg-primary/90 text-primary-foreground';
$role = $role ?? 'patient';
$mb = $mb ?? 8;

// Define Identity based on Role
$identities = [
    'admin' => [
        'name' => 'Admin Staff',
        'sub' => 'WAYSIDE PSYCHE CENTER',
        'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDVQVEYnYP3RNwtH688PAaJcRKYUqn-FqE3R99MdZw7cuBlzeuvQOFMORRPCTmvE4fxogYwfMKbwhwRUiudJq_c-ki4wFS2Den4x0RusJ8YALmX_o5qbk7tNd90GqS1rQrJcVzNi_BStArnQRfyO2JjIiLPCK129vP_lgAJndDhaHwV8ElpfmYp-qrzx1H5uvznW6wac1YOp4zmsyQT6dxGJBckI7bTPWXUho97ooiVdBuyiEl9uBysl1uW03DFIIYr7LhKk5DS8kM'
    ],
    'doctor' => [
        'name' => 'Dr. Aris',
        'sub' => 'SPECIALIST',
        'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBAbFD9I88SLVxTHJugxddKsh7JNFt2DcqWQZvPspu8WfWpHPebkP2u1xIClJiwejZumDtfEisRiNZJahrCABZ-VaWkplhfSjT3hya0Fs4WR2q568OOJnIdHPN4vQjXVGSgFxV36CEuigWqxcO4t9EQMXnopNWe2GfQcifhFOTHGhbcMmpjva2YKrNmBvLsQduqTm-ckXUuQ_A4gE5cDAgYkR3dSRuj0m_BS6WSdbQ_SQBr8-djed7y759pym1TY_Nlf142szXNDmw'
    ],
    'patient' => [
        'name' => 'Alex Henderson',
        'sub' => 'PATIENT ID: #29402',
        'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCwUDx00gZK6krtBkGrAjs8OlgCSukAKpmdeiY9SSpuk_oHQxq_aXj7NhqtbTmoH4_HFuf_kSuMriX_vCT4EOydYTg5_Ca7gJbSHteacm67tY1XAX7u7n1bNc6h5zxLenLvdPNpqUgC5EKdWwfWtpHhMu7EiJyB6I6H1hPY52FLVMLJ5vmIFY1Lk64rcXtkaJY19hIBqsb5YwOYQdzXTSFA4XNNS3qfWefhTUx3LCP4I0xt9RJJHZaz1s1iPNd9xhQMh8UrdGqWGQY'
    ]
];

$userIdentity = $identities[$role] ?? $identities['patient'];
$userName = $userIdentity['name'];
$userRole = $userIdentity['sub'];
$userAvatar = $userIdentity['avatar'];
?>

<header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-<?= $mb ?>">
    <div>
        <h2 class="text-3xl font-black tracking-tight text-foreground">
            <?= $title ?>
        </h2>
        <?php if ($description): ?>
            <p class="text-muted-foreground mt-1">
                <?= $description ?>
            </p>
        <?php endif; ?>
    </div>
    <div class="flex items-center gap-6">
        <div class="flex items-center gap-3">
            <?php if ($searchPlaceholder): ?>
                <div class="relative hidden lg:block">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground font-variation-settings-['FILL'_0,'wght'_400]">search</span>
                    <input
                        class="pl-10 pr-4 py-2 bg-card border border-border rounded-lg text-sm focus:ring-primary focus:border-primary w-64 transition-all placeholder:text-muted-foreground"
                        placeholder="<?= htmlspecialchars($searchPlaceholder) ?>" type="text" />
                </div>
            <?php endif; ?>

            <?php if ($actionLabel): ?>
                <?php if ($actionUrl !== '#'): ?>
                    <a href="<?= $actionUrl ?>"
                        class="<?= $actionClass ?> px-5 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md shadow-primary/20 flex items-center gap-2 cursor-pointer">
                        <span class="material-symbols-outlined text-[20px]">
                            <?= $actionIcon ?>
                        </span>
                        <span class="hidden lg:block"><?= $actionLabel ?></span>
                    </a>
                <?php else: ?>
                    <button
                        class="<?= $actionClass ?> px-5 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md shadow-primary/20 flex items-center gap-2 cursor-pointer">
                        <span class="material-symbols-outlined text-[20px] font-variation-settings-['FILL'_0,'wght'_400]">
                            <?= $actionIcon ?>
                        </span>
                        <span class="hidden lg:block"><?= $actionLabel ?></span>
                    </button>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (isset($extraContent))
                echo $extraContent; ?>
        </div>

        <!-- User Identity Section -->
        <div class="flex items-center gap-4 border-l border-border pl-4">
            <button class="relative p-2 text-muted-foreground hover:bg-muted rounded-full transition-all group">
                <span
                    class="material-symbols-outlined text-2xl font-variation-settings-['FILL'_0,'wght'_400]">notifications</span>
                <span
                    class="absolute top-2 right-2 size-2.5 bg-error rounded-full border-2 border-background animate-pulse"></span>
            </button>

            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-black text-foreground leading-none"><?= $userName ?></p>
                    <p class="text-[10px] font-bold text-primary uppercase tracking-widest mt-1 opacity-80">
                        <?= $userRole ?>
                    </p>
                </div>
                <div
                    class="size-10 rounded-full border-2 border-primary/20 p-0.5 overflow-hidden shadow-sm shadow-primary/10">
                    <div class="size-full rounded-full bg-cover bg-center"
                        style="background-image: url('<?= $userAvatar ?>')"></div>
                </div>
            </div>
        </div>
    </div>
</header>