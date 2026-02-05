<style>
    main section.popular>img {
        width: 100%;
        aspect-ratio: 16/9;
        border-radius: 20px;
        margin-bottom: 20px;
    }

    main section.popular .audio {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    main section.popular .audio i {
        font-size: 26px;
        background: #eff6ff;
        padding: 6px;
        border-radius: 50%;
    }

    main section.popular .audio a {
        font-size: 15px;
        font-weight: 600;
        color: #000;
        line-height: 18px;
    }

    main section.popular>p {
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 50px;
    }

    main section.popular .listen {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    main section.popular .listen .author {
        padding: 6px 10px;
        background: #f3f3f3;
        display: flex;
        align-items: center;
        gap: 10px;
        border-radius: 10px;
    }

    main section.popular .listen .author img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    main section.popular .listen .author a {
        font-size: 14px;
        color: #000;
    }

    main section.popular .listen .author p {
        font-size: 12px;
        color: #9b9b9b;
    }

    main section.popular .listen button {
        border: none;
        color: #fff;
        background: #031224;
        padding: 8.45px 14px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
    }

    main section.popular .listen button i {
        font-size: 16px;
    }
</style>
<section class="popular">
    <div class="header">
        <h4>Popular</h4>
        <a href="#"></a>
    </div>
    <img src="<?= asset('img/contents/services/grooming.jpg'); ?>">
    <div class="audio">
        <i class='bx bx-podcast'></i>
        <a href="#">Perfect: Freshly groomed and looking paw-some!</a>
    </div>
    <p>All cleaned up and ready to conquer the world.</p>
    <div class="listen">
        <div class="author">
            <img src="<?= asset('img/profiles/user-1.jpg'); ?>">
            <div>
                <a href="#">Alex Costa</a>
                <p>Data Analyst</p>
            </div>
        </div>
        <button>book<i class='bx bx-right-arrow-alt'></i></button>
    </div>
</section>