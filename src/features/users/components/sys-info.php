<style>
    main section.system-info {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 1rem;

        margin-top: 1.25rem;
        height: 91%;
    }

    main section.system-info .info {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 3px;
    }

    main section.system-info .info label {
        font-size: 0.8rem;
    }
</style>
<section class="system-info box">
    <div class="logo">
        <img class="rounded-circle" width="140" src="<?= asset('img/logo.jpg'); ?>" />
    </div>
    <div class="info">
        <h2>Lorem</h2>
        <label>Lorem ipsum dolor</label>
    </div>
</section>