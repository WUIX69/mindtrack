<style>
    main section.status {
        padding: 20px 20px 26px;
        background: #006A71;
        border-radius: 0 0 30px 30px;
    }

    main section.status .header {
        display: flex;
        align-items: center;
        width: 100%;
        margin-bottom: 20px;
    }

    main section.status .header h4 {
        color: #f1f3f2;
        font-weight: 500;
        margin: 0;
    }

    main section.status .header h4#big {
        flex: 3;
    }

    main section.status .header h4#small {
        flex: 1;
        padding-left: 90px;
    }

    main section.status .items-list {
        margin: 0;
        padding: 0;
    }

    main section.status .items-list .item {
        background: #e0f2fe;
        width: 100%;
        padding: 20px;
        border-radius: 18px;
    }

    main section.status .items-list .item.item-2 {
        background: #fffbeb;
    }

    main section.status .items-list .item.item-3 {
        background: #bfdbfe;
    }

    main section.status .items-list .item.item-4 {
        background: #006A71;
        padding: 0;
        margin: 0;
    }

    main section.status .items-list .item .info {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 40px;
    }

    main section.status .items-list .item .info h5 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    main section.status .items-list .item .info p {
        font-size: 12px;
        font-weight: 500;
    }

    main section.status .items-list .item .info>i {
        font-size: 20px;
        padding: 10px;
        background: #031224;
        color: #f1f3f2;
        border-radius: 50%;
    }

    main section.status .items-list .item .progress {
        position: relative;
        height: 10px;
        background: #b7c0cd;
        border-radius: 10px;
    }

    main section.status .items-list .item .progress .bar {
        width: 92%;
        height: 10px;
        background: #031224;
        border-radius: 10px;
    }

    main section.status .items-list .item .progress::before {
        content: "92%";
        position: absolute;
        top: -40px;
        right: 0;
        font-size: 22px;
        font-weight: 600;
    }

    main section.status .items-list .item.item-2 .progress {
        background: #d6d3d1;
    }

    main section.status .items-list .item.item-2 .progress .bar {
        width: 65%;
    }

    main section.status .items-list .item.item-2 .progress::before {
        content: "65%";
    }

    main section.status .items-list .item.item-3 .progress {
        background: #94a3b8;
    }

    main section.status .items-list .item.item-3 .progress .bar {
        width: 80%;
    }

    main section.status .items-list .item.item-3 .progress::before {
        content: "80%";
    }

    main section.status .items-list .item.item-4 canvas {
        height: 140px;
    }
</style>
<section class="status">
    <div class="header">
        <h4 id="big">Your favorites</h4>
        <!-- <h4 id="small">Weekly Activity</h4> -->
    </div>
    <div class="items-list">
        <div class="row">
            <div class="col-lg-3">
                <div class="item item-1">
                    <div class="info">
                        <div>
                            <h5>Vaccination </h5>
                            <p>- 3 sessions left</p>

                        </div>
                        <i class='bx bx-data'></i>
                    </div>
                    <div class="progress">
                        <div class="bar"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="item item-2">
                    <div class="info">
                        <div>
                            <h5>Checkup</h5>
                            <p>- 2 appointments made</p>

                        </div>
                        <i class='bx bx-terminal'></i>
                    </div>
                    <div class="progress">
                        <div class="bar"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="item item-3">
                    <div class="info">
                        <div>
                            <h5>Grooming</h5>
                            <p>- 5 sessions made</p>

                        </div>
                        <i class='bx bxl-python'></i>
                    </div>
                    <div class="progress">
                        <div class="bar"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="item item-4">
                    <canvas class="activity-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>