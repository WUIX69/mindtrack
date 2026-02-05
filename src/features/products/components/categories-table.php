<style>
    main section.categories-table table tbody td:first-child i {
        text-align: center;
        font-size: 1.1rem !important;
    }

    main section.categories-table table tbody td .category-status {
        font-size: 0.7rem;
        padding: 0.2rem 0.5rem;
        border-radius: 1rem;
        font-weight: 500;
    }

    main section.categories-table table tbody td .category-status.active {
        background-color: #e8f5e9;
        color: #2e7d32;
    }

    main section.categories-table table tbody td .category-status.inactive {
        background-color: #ffebee;
        color: #c62828;
    }
</style>
<section class="categories-table">
    <h2 class="title">Product Categories</h2>
    <div class="container table-list box"> <!-- categories-table-container -->
        <div class="table-filters">
            <div class="base-filters">
                <div class="ui fluid mini category search service-search">
                    <div class="ui icon input">
                        <input class="prompt" type="text" placeholder="Search categories..." />
                        <i class="search icon"></i>
                    </div>
                    <div class="results"></div>
                </div>
                <!-- More base filters here when needed -->
            </div>
            <button class="ui mini primary button" data-open-modal="#productCategoryModal">
                <i class="plus icon"></i>
                Add Category
            </button>
        </div>
        <div class="table-container">
            <table class="ui fixed single line small center aligned very basic selectable table">
                <thead>
                    <tr>
                        <th width="48">Icon</th>
                        <th>Category</th>
                        <th width="300">Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="productCategoriesTableBody">
                    <!-- Table Data Populated by JS -->
                </tbody>
            </table>
        </div>
    </div>
</section>