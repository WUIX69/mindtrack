<style>
    main section.services-table table tbody td .service-img {
        width: 60px;
        height: 60px;
        border-radius: 0.3rem;
        object-fit: cover;
    }

    main section.services-table .service-status {
        font-size: 0.7rem;
        padding: 0.2rem 0.5rem;
        border-radius: 1rem;
        font-weight: 500;
    }

    main section.services-table .service-status.available {
        background-color: #e8f5e9;
        color: #2e7d32;
    }

    main section.services-table .service-status.unavailable {
        background-color: #ffebee;
        color: #c62828;
    }

    main section.services-table .service-status.busy {
        background-color: #fff8e1;
        color: #f57c00;
    }

    main section.services-table .service-status.soon {
        background-color: #e3f2fd;
        color: #1976d2;
    }
</style>
<section class="services-table">
    <h2 class="title">Services List</h2>
    <div class="container box table-list">
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
            <button class="ui mini primary button" data-open-modal="#serviceModal">
                <i class="plus icon"></i>
                Add Services
            </button>
        </div>

        <div class="table-container">
            <table class="ui fixed single line small center aligned very basic selectable display table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Created_at</th>
                        <th>Updated_at</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="servicesTableBody">
                    <!-- Table Data Populated by JS -->
                </tbody>
            </table>
        </div>
    </div>
</section>