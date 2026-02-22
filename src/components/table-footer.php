<!-- Table Footer -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mt-10 font-sans">

    <!-- LEFT SIDE -->
    <div class="text-sm text-muted-foreground">
        Showing <span class="font-medium text-foreground">1</span>
        to <span class="font-medium text-foreground">10</span>
        of <span class="font-medium text-foreground">20</span> entries
    </div>

    <!-- RIGHT SIDE -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-8">

        <!-- Per Page Select -->
        <div class="flex items-center gap-2 text-sm">
            <span class="text-muted-foreground">Per page</span>
            <select class="per-page px-3 py-2
                       bg-card text-foreground
                       border border-border
                       rounded-lg
                       shadow-sm
                       focus:outline-none
                       focus:ring-2 focus:ring-ring
                       transition-all duration-200">

                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>

        <!-- Pagination -->
        <div class="pagination flex items-center gap-2">

            <!-- Previous -->
            <button class="page-item flex items-center justify-center
                       w-10 h-10 rounded-full
                       bg-card text-muted-foreground
                       border border-border
                       shadow-sm
                       transition-all duration-200
                       hover:bg-accent hover:text-accent-foreground">
                <span class="material-symbols-outlined text-[18px]">
                    chevron_left
                </span>
            </button>

            <!-- Page 1 (Active) -->
            <button class="page-item active flex items-center justify-center
                       w-10 h-10 rounded-full
                       bg-primary text-primary-foreground
                       shadow-sm transition-all duration-200">
                1
            </button>

            <!-- Page 2 -->
            <button class="page-item flex items-center justify-center
                       w-10 h-10 rounded-full
                       bg-card text-foreground
                       border border-border
                       shadow-sm transition-all duration-200
                       hover:bg-accent hover:text-accent-foreground">
                2
            </button>

            <!-- Next -->
            <button class="page-item flex items-center justify-center
                       w-10 h-10 rounded-full
                       bg-card text-muted-foreground
                       border border-border
                       shadow-sm transition-all duration-200
                       hover:bg-accent hover:text-accent-foreground">
                <span class="material-symbols-outlined text-[18px]">
                    chevron_right
                </span>
            </button>

        </div>
    </div>
</div>

<script>
    $(function () {

        // Pagination click
        $('.pagination').on('click', '.page-item', function () {

            // Ignore arrows
            if ($(this).find('.material-symbols-outlined').length) return;

            $('.pagination .page-item')
                .not(':has(.material-symbols-outlined)')
                .removeClass('bg-primary text-primary-foreground active')
                .addClass('bg-card text-foreground border border-border');

            $(this)
                .addClass('bg-primary text-primary-foreground active')
                .removeClass('bg-card text-foreground border border-border');
        });


        // Per page change
        $('.per-page').on('change', function () {
            const value = $(this).val();
            console.log("Per page changed to:", value);

            // You can hook AJAX reload here
            // reloadTable({ perPage: value });
        });

    });
</script>