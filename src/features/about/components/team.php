<style>
    /*----------- MAIN (Team Section) -----------*/

    /* Team Grid Layout */
    main section.team-section .row {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Team Member Cards */
    main section.team-section .member-card {
        background: var(--color-white);
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    main section.team-section .member-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--box-shadow-hover);
    }

    main section.team-section .member-card img {
        width: 100%;
        height: 280px;
        object-fit: cover;
    }

    main section.team-section .member-info {
        padding: 25px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    main section.team-section .member-info h3 {
        color: var(--color-dark);
        font-size: 1.5rem;
        margin-bottom: 8px;
        font-weight: 600;
    }

    main section.team-section .member-title {
        color: var(--color-primary);
        font-weight: 600;
        margin-bottom: 12px;
        font-size: 1.1rem;
    }

    main section.team-section .member-bio {
        color: var(--color-dark-variant);
        line-height: 1.6;
        margin-bottom: 20px;
        flex-grow: 1;
    }

    main section.team-section .social-links {
        margin-top: auto;
    }

    main section.team-section .social-links a {
        color: var(--color-dark-variant);
        margin-right: 15px;
        font-size: 1.2rem;
        transition: color 0.3s ease;
    }

    main section.team-section .social-links a:hover {
        color: var(--color-primary);
    }

    /* Responsive Design */
    @media screen and (max-width: 1200px) {
        main section.team-section .member-card {
            width: 300px;
        }
    }
</style>

<section class="team-section">
    <div class="container-xl">
        <div class="section-title">
            <span class="sub-title">Our Team</span>
            <h2>Meet Our Veterinary Professionals</h2>
            <p>Dedicated experts committed to the health and wellbeing of your pets. Lorem ipsum dolor sit amet
                consectetur adipisicing elit. Itaque, provident.</p>
        </div>

        <div class="team-grid">
            <div class="row">
                <!-- Team Member 1 -->
                <div class="col-md-4">
                    <div class="member-card">
                        <img src="<?= asset('img/teams/team1.jpg') ?>" alt="Dr. Josephine Anne Angeles">
                        <div class="member-info">
                            <h3>Dr. Josephine Anne Angeles</h3>
                            <p class="member-title">Lead Veterinarian & Clinic Director</p>
                            <p class="member-bio">With over a decade of experience in veterinary medicine,
                                Dr. Angeles leads our clinic with expertise in small animal care and
                                surgery.</p>
                            <div class="social-links">
                                <a href="#"><i class="facebook f icon"></i></a>
                                <a href="#"><i class="instagram icon"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Member 2 -->
                <div class="col-md-4">
                    <div class="member-card">
                        <img src="<?= asset('img/teams/team2.jpg') ?>" alt="Dr. Maria Santos">
                        <div class="member-info">
                            <h3>Dr. Maria Santos</h3>
                            <p class="member-title">Associate Veterinarian</p>
                            <p class="member-bio">Specializing in preventive care and emergency medicine,
                                Dr. Santos brings warmth and expertise to every patient interaction.</p>
                            <div class="social-links">
                                <a href="#"><i class="facebook f icon"></i></a>
                                <a href="#"><i class="instagram icon"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Member 3 -->
                <div class="col-md-4">
                    <div class="member-card">
                        <img src="<?= asset('img/teams/team3.jpg') ?>" alt="Dr. Santos">
                        <div class="member-info">
                            <h3>Dr. Santos</h3>
                            <p class="member-title">Associate Veterinarian</p>
                            <p class="member-bio">Specializing in preventive care and emergency medicine,
                                Dr. Santos brings warmth and expertise to every patient interaction.</p>
                            <div class="social-links">
                                <a href="#"><i class="facebook f icon"></i></a>
                                <a href="#"><i class="instagram icon"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>