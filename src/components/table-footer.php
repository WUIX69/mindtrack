<!-- Table Footer -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mt-10 font-sans">

    <!-- LEFT SIDE -->
    <div class="text-sm text-muted-foreground showing-entries">
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

                <option value="5" selected>5</option>
                <option value="10">10</option>
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
    class TableFooter {
        constructor(options) {
            this.perPageElement = document.querySelector('.per-page');
            this.paginationContainer = document.querySelector('.pagination');
            this.showingEntriesElement = document.querySelector('.showing-entries');

            this.currentPage = options.currentPage || 1;
            this.perPage = parseInt(this.perPageElement?.value || 10);
            this.onPageChange = options.onPageChange || function () { };
            this.onPerPageChange = options.onPerPageChange || function () { };

            this.initEvents();
        }

        initEvents() {
            if (this.perPageElement) {
                this.perPageElement.addEventListener('change', (e) => {
                    this.perPage = parseInt(e.target.value);
                    this.currentPage = 1;
                    this.onPerPageChange(this.perPage);
                });
            }

            if (this.paginationContainer) {
                this.paginationContainer.addEventListener('click', (e) => {
                    const btn = e.target.closest('.page-item');
                    if (!btn || btn.hasAttribute('disabled')) return;

                    const action = btn.getAttribute('data-action');
                    const page = parseInt(btn.getAttribute('data-page'));

                    let newPage = this.currentPage;

                    if (action === 'prev') {
                        newPage = Math.max(1, this.currentPage - 1);
                    } else if (action === 'next') {
                        newPage = this.currentPage + 1; // Upper bound check happens externally
                    } else if (page) {
                        newPage = page;
                    }

                    if (newPage !== this.currentPage) {
                        this.currentPage = newPage;
                        this.onPageChange(this.currentPage);
                    }
                });
            }
        }

        update(totalItems) {
            const startIdx = (this.currentPage - 1) * this.perPage;
            const endIdx = Math.min(startIdx + this.perPage, totalItems);

            // Update entries text
            if (this.showingEntriesElement) {
                this.showingEntriesElement.innerHTML = `Showing <span class="font-medium text-foreground">${totalItems === 0 ? 0 : startIdx + 1}</span> to <span class="font-medium text-foreground">${endIdx}</span> of <span class="font-medium text-foreground">${totalItems}</span> entries`;
            }

            // Update pagination buttons
            if (this.paginationContainer) {
                const totalPages = Math.ceil(totalItems / this.perPage) || 1;

                // Ensure current page doesn't exceed total pages after a filter changes totalItems
                if (this.currentPage > totalPages) {
                    this.currentPage = totalPages;
                    // Note: We don't auto-trigger onPageChange here to avoid infinite loops,
                    // the caller should re-render based on the new valid page.
                }

                let html = '';

                html += `<button class="page-item px-3 py-1 flex items-center justify-center w-10 h-10 rounded-full bg-card text-muted-foreground border border-border transition-all duration-200 hover:bg-accent hover:text-accent-foreground disabled:opacity-50" data-action="prev" ${this.currentPage === 1 ? 'disabled' : ''}><span class="material-symbols-outlined text-[18px]">chevron_left</span></button>`;

                for (let i = 1; i <= totalPages; i++) {
                    if (i === this.currentPage) {
                        html += `<button class="page-item px-3 py-1 flex items-center justify-center w-10 h-10 rounded-full bg-primary text-primary-foreground shadow-sm transition-all duration-200" data-page="${i}">${i}</button>`;
                    } else if (i === 1 || i === totalPages || Math.abs(i - this.currentPage) <= 1) {
                        html += `<button class="page-item px-3 py-1 flex items-center justify-center w-10 h-10 rounded-full bg-card text-foreground border border-border shadow-sm transition-all duration-200 hover:bg-accent hover:text-accent-foreground" data-page="${i}">${i}</button>`;
                    } else if (Math.abs(i - this.currentPage) === 2) {
                        html += `<span class="px-2">...</span>`;
                    }
                }

                html += `<button class="page-item px-3 py-1 flex items-center justify-center w-10 h-10 rounded-full bg-card text-muted-foreground border border-border transition-all duration-200 hover:bg-accent hover:text-accent-foreground disabled:opacity-50" data-action="next" ${this.currentPage === totalPages ? 'disabled' : ''}><span class="material-symbols-outlined text-[18px]">chevron_right</span></button>`;

                this.paginationContainer.innerHTML = html;
            }

            return {
                startIdx,
                endIdx,
                currentPage: this.currentPage,
                perPage: this.perPage
            };
        }
    }
</script>