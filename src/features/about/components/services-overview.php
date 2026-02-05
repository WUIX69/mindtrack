<style>
    /*----------- MAIN (Services Section) -----------*/
    main section.services-overview .service-item {
        text-align: center;
        padding: 30px 20px;

        /* display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    gap: 1rem; */
    }

    main section.services-overview .service-item i {
        font-size: 3rem;
        color: var(--color-primary);
        margin-bottom: 20px;
    }

    main section.services-overview .service-item p {
        color: var(--color-dark-variant);
        margin-bottom: 20px;
        font-size: 1.1rem;
    }

    main section.services-overview .ui.teal.button {
        /* background-color: var(--color-primary);
    color: var(--color-white); */
        padding: 12px 25px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    main section.services-overview .ui.teal.button:hover {
        transform: translateY(-5px);
    }
</style>

<!-- Services Overview -->
<section class="services-overview">
    <div class="container-xl">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="service-item">
                    <i class="huge heartbeat icon"></i>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus voluptas beatae aliquid
                        amet placeat natus!</p>
                    <button class="ui teal button">Learn More</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-item">
                    <i class="huge syringe icon"></i>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Corporis esse obcaecati dolorem
                        iure. Iure, nisi!</p>
                    <button class="ui teal button">Learn More</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-item">
                    <i class="huge stethoscope icon"></i>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi tempore suscipit molestiae
                        quibusdam facilis iure?</p>
                    <button class="ui teal button">Learn More</button>
                </div>
            </div>
        </div>
    </div>
</section>