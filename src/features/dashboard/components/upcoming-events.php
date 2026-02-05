<style>
    main section.upcoming .dates {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
    }

    main section.upcoming .dates .item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
    }

    main section.upcoming .dates .item h5 {
        font-weight: 600;
    }

    main section.upcoming .dates .item a {
        color: #000;
        font-size: 13px;
        padding: 5px 9px;
        border-radius: 50%;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    main section.upcoming .dates .item.active a,
    main section.upcoming .dates .item a:hover {
        color: #fff;
        background: #031224;
    }

    main section.upcoming .events {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    main section.upcoming .events .item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #eff6ff;
        padding: 10px;
        border-radius: 10px;
    }

    main section.upcoming .events .item>i {
        cursor: pointer;
    }

    main section.upcoming .events .item>div {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    main section.upcoming .events .item>div i {
        font-size: 30px;
    }

    main section.upcoming .events .item .event-info a {
        font-size: 14px;
        color: #000;
        font-weight: 500;
    }

    main section.upcoming .events .item .event-info p {
        font-size: 13px;
        color: #9b9b9b;
    }
</style>
<section class="upcoming">

    <div class="header">
        <h4>You may like it</h4>
        <a href="#">July <i class='bx bx-chevron-down'></i></a>
    </div>

    <div class="dates">
        <div class="item">
            <h5>Mo</h5>
            <a href="#">12</a>
        </div>
        <div class="item active">
            <h5>Tu</h5>
            <a href="#">13</a>
        </div>
        <div class="item">
            <h5>We</h5>
            <a href="#">14</a>
        </div>
        <div class="item">
            <h5>Th</h5>
            <a href="#">15</a>
        </div>
        <div class="item">
            <h5>Fr</h5>
            <a href="#">16</a>
        </div>
        <div class="item">
            <h5>Sa</h5>
            <a href="#">17</a>
        </div>
        <div class="item">
            <h5>Su</h5>
            <a href="#">18</a>
        </div>
    </div>

    <div class="events">
        <div class="item">
            <div>
                <i class='bx bx-time'></i>
                <div class="event-info">
                    <a href="#">Vaccination</a>
                    <p>10:00-11:30</p>
                </div>
            </div>
            <i class='bx bx-dots-horizontal-rounded'></i>
        </div>
        <div class="item">
            <div>
                <i class='bx bx-time'></i>
                <div class="event-info">
                    <a href="#">Grooming</a>
                    <p>13:30-15:00</p>
                </div>
            </div>
            <i class='bx bx-dots-horizontal-rounded'></i>
        </div>
        <div class="item">
            <div>
                <i class='bx bx-time'></i>
                <div class="event-info">
                    <a href="#">boarding</a>
                    <p>11:30-13:00</p>
                </div>
            </div>
            <i class='bx bx-dots-horizontal-rounded'></i>
        </div>
        <div class="item">
            <div>
                <i class='bx bx-time'></i>
                <div class="event-info">
                    <a href="#">Pet Accessories</a>
                    <p>10:00-11:30</p>
                </div>
            </div>
            <i class='bx bx-dots-horizontal-rounded'></i>
        </div>
    </div>

</section>