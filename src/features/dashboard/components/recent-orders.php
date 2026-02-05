<section class="recent-orders">
    <h2 class="title">Recent Orders</h2>
    <div class="container box table-list">
        <div class="table-filters">
            <div class="base-filters">
                <div class="ui fluid mini category search">
                    <div class="ui icon input">
                        <input class="prompt" type="text" placeholder="Search orders..." />
                        <i class="search icon"></i>
                    </div>
                    <div class="results"></div>
                </div>
                <div class="quick-filters">
                    <div class="ui mini compact selection floating labeled icon dropdown">
                        <input type="hidden" name="status" />
                        <i class="signal icon"></i>
                        <div class="default text">Status</div>
                        <div class="menu">
                            <div class="header">
                                <i class="tags icon"></i>
                                Filter by Status
                            </div>
                            <div class="item" data-value="active">
                                Pending
                            </div>
                            <div class="item" data-value="inactive">
                                Declined
                            </div>
                            <div class="item" data-value="pending">
                                Completed
                            </div>
                        </div>
                    </div>
                    <button class="ui mini secondary button filter-reset-btn">
                        <i class="times icon"></i>
                        Reset
                    </button>
                </div>
            </div>
            <button class="ui mini secondary button">
                View All
            </button>
        </div>
        <div class="table-container recent-orders">
            <table class="ui fixed single line small center aligned very basic selectable table">
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Course Number</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="recentOrderItems">
                    <!-- Table Data -->
                </tbody>
            </table>
        </div>
    </div>
</section>