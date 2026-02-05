<style>
    main section.products-table table tbody td .product-status {
        font-size: 0.7rem;
        padding: 0.2rem 0.5rem;
        border-radius: 1rem;
        font-weight: 500;
        width: fit-content;
        text-align: center;
    }

    main section.products-table table tbody td .product-status.available {
        background-color: #e8f5e9;
        color: #2e7d32;
    }

    main section.products-table table tbody td .product-status.unavailable {
        background-color: #ffebee;
        color: #c62828;
    }

    main section.products-table table tbody td .product-image {
        width: 60px;
        height: 60px;
        border-radius: 0.3rem;
        object-fit: cover;
    }
</style>
<!-- Products Table -->
<section class="products-table">
    <h2 class="title">Products List</h2>
    <div class="container table-list box">
        <div class="table-filters">
            <div class="base-filters">

                <div class="ui fluid mini category search service-search">
                    <div class="ui icon input">
                        <input class="prompt" type="text" placeholder="Search services..." />
                        <i class="search icon"></i>
                    </div>
                    <div class="results"></div>
                </div>

                <div class="ui mini compact selection floating labeled icon dropdown">
                    <input type="hidden" name="status-filter">
                    <i class="filter icon"></i>
                    <div class="default text">All Statuses</div>
                    <div class="menu">
                        <div class="item" data-value="all">All Statuses</div>
                        <div class="item" data-value="available">Available</div>
                        <div class="item" data-value="unavailable">Unavailable</div>
                    </div>
                </div>

                <div class="ui mini compact selection floating labeled icon dropdown">
                    <input type="hidden" name="category-filter">
                    <i class="filter icon"></i>
                    <div class="default text">All Categories</div>
                    <div class="menu">
                        <div class="item" data-value="all">All Categories</div>
                        <div class="item" data-value="examination">Examination</div>
                        <div class="item" data-value="treatment">Treatment</div>
                        <div class="item" data-value="surgery">Surgery</div>
                        <div class="item" data-value="grooming">Grooming</div>
                    </div>
                </div>

            </div>
            <button class="ui mini primary button" data-open-modal="#productModal">
                <i class="plus icon"></i>
                Add Product
            </button>
        </div>
        <div class="table-container">
            <table class="ui fixed single line small center aligned very basic selectable table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Tags</th>
                        <th>Specs</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="productsTableBody">
                    <!-- Table Data Populated by JS -->
                </tbody>
            </table>
        </div>
    </div>
</section>