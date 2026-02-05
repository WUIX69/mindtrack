<style>
    /* Contact Section Styles */
    main section.contact-section {
        padding: 5rem 0;
        background: var(--color-white);
    }

    main section.contact-section .contact-info {
        padding-right: 3rem;
    }

    main section.contact-section .sub-title {
        color: var(--color-primary);
        font-size: 1rem;
        font-weight: 500;
        margin-bottom: 1rem;
        display: block;
    }

    main section.contact-section h2 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        line-height: 1.2;
        color: var(--color-dark);
    }

    main section.contact-section p {
        color: var(--color-text);
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    main section.contact-section .contact-card {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: var(--color-background-variant);
        border-radius: 0.5rem;
    }

    main section.contact-section .contact-card .icon {
        color: var(--color-primary);
    }

    main section.contact-section .contact-card .content h3 {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: var(--color-dark);
    }

    main section.contact-section .contact-card .content p {
        margin: 0;
        color: var(--color-text);
        font-size: 0.9rem;
    }

    main section.contact-section .contact-form {
        background: var(--color-background-variant);
        padding: 2rem;
        border-radius: 0.8rem;
    }

    main section.contact-section .contact-form .field {
        margin-bottom: 1.5rem;
    }

    main section.contact-section .contact-form label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--color-dark);
        font-weight: 500;
    }

    main section.contact-section .contact-form input,
    main section.contact-section .contact-form textarea {
        width: 100%;
        padding: 1rem;
        border: 1px solid var(--color-border);
        border-radius: 0.5rem;
        background: var(--color-white);
    }

    main section.contact-section .contact-form textarea {
        height: 150px;
        resize: vertical;
    }

    main section.contact-section .contact-form button {
        width: auto;
        padding: 0.8rem 2rem;
        border-radius: 2rem;
        background: var(--color-dark);
        color: var(--color-white);
        font-weight: 500;
    }

    main section.contact-section .contact-form button:hover {
        opacity: 0.9;
    }
</style>

<section class="contact-section">
    <div class="container-xl">
        <div class="row">
            <!-- Left Side - Contact Info -->
            <div class="col-lg-6">
                <div class="contact-info">
                    <span class="sub-title">CONTACT US</span>
                    <h2>Get In Touch<br>With Our Agents</h2>
                    <p>When you really need to download free CSS templates, please remember our
                        website TemplateMo. Also, tell your friends about our website. Thank you for
                        visiting. There is a variety of Bootstrap HTML CSS templates on our website.
                        If you need more information, please contact us.</p>

                    <!-- Phone Info -->
                    <div class="contact-card">
                        <div class="icon">
                            <i class="huge phone icon orange"></i>
                        </div>
                        <div class="content">
                            <h3>010-020-0340</h3>
                            <p>Phone Number</p>
                        </div>
                    </div>

                    <!-- Email Info -->
                    <div class="contact-card">
                        <div class="icon">
                            <i class="huge envelope icon orange"></i>
                        </div>
                        <div class="content">
                            <h3>info@villa.co</h3>
                            <p>Business Email</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Contact Form -->
            <div class="col-lg-6">
                <div class="contact-form">
                    <form class="ui form">
                        <div class="field">
                            <label>Full Name</label>
                            <input type="text" placeholder="Your Name...">
                        </div>
                        <div class="field">
                            <label>Email Address</label>
                            <input type="email" placeholder="Your E-mail...">
                        </div>
                        <div class="field">
                            <label>Subject</label>
                            <input type="text" placeholder="Subject...">
                        </div>
                        <div class="field">
                            <label>Message</label>
                            <textarea placeholder="Your Message"></textarea>
                        </div>
                        <button class="ui black button" type="submit">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>