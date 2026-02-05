<style>
    main section.categories-table table td:first-child i {
        text-align: center;
        font-size: 1.1rem !important;
    }
</style>
<section class="categories-table">
    <h2 class="title">Service Categories</h2>
    <div class="container table-list box"> <!-- categories-table-container -->
        <div class="table-filters">
            <div class="base-filters">
                <div class="ui fluid mini category search service-search">
                    <div class="ui icon input">
                        <input class="prompt" type="text" placeholder="Search services..." />
                        <i class="search icon"></i>
                    </div>
                    <div class="results"></div>
                </div>
                <!-- More base filters here when needed -->
            </div>
            <button class="ui mini primary button" data-open-modal="#serviceCategoryModal">
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
                <tbody id="serviceCategoriesTableBody">
                    <!-- Table Data Populated by JS -->
                </tbody>
            </table>
        </div>
    </div>
</section>