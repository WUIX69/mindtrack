<style>
    #bookNowModal {
        padding: 0;
        margin: 0;

        overflow: hidden;
    }

    #bookNowModal .header {
        font-size: 1.8rem !important;
        font-weight: bold !important;
    }

    #bookNowModal .form-container {
        padding: 2.5rem;
        position: relative;
        width: calc(100% - 540px);
        height: 100%;
    }

    #bookNowModal .form-container .ui.form .submit.button {
        background: #000;
        color: #fff;
        font-size: 1rem !important;
        padding: 1rem 2rem;
    }

    #bookNowModal .image-container {
        width: calc(100% - 540px);
        height: 100%;

        background: #fafafa;
        display: flex;
        align-items: center;
        justify-content: center;

        position: absolute;
        top: 0;
        right: 0;
    }

    #bookNowModal .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }
</style>
<div class="ui large modal" id="bookNowModal">
    <div class="header">Book Appointment</div>
    <div class="image content">
        <div class="form-container">
            <form class="ui form" id="bookNowForm">
                <div class="two fields">
                    <div class="field">
                        <label for="full_name">Full Name</label>
                        <input type="text" name="full_name" placeholder="Your Name" />
                    </div>
                    <div class="field">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" placeholder="your@email.com" />
                    </div>
                </div>
                <div class="two fields">
                    <div class="field">
                        <label for="phone">Phone Number</label>
                        <input type="text" name="phone" placeholder="123-456-7890" />
                    </div>
                    <div class="field">
                        <label for="persons">Number of persons</label>
                        <input type="number" name="persons" placeholder="12 persons" min="1" />
                    </div>
                </div>
                <div class="two fields">
                    <div class="field">
                        <label for="date">Date</label>
                        <input type="date" name="date" placeholder="mm/dd/yyyy" />
                    </div>
                    <div class="field">
                        <label for="time">Time</label>
                        <select name="time">
                            <option value="">Select Time</option>
                            <option value="17:00">5:00 PM</option>
                            <option value="17:30">5:30 PM</option>
                            <option value="18:00">6:00 PM</option>
                            <option value="18:30">6:30 PM</option>
                            <option value="19:00">7:00 PM</option>
                            <option value="19:30">7:30 PM</option>
                            <option value="20:00">8:00 PM</option>
                        </select>
                    </div>
                </div>
                <div class="field">
                    <label for="special_request">Special Request</label>
                    <textarea rows="4" name="special_request" placeholder=""></textarea>
                </div>
                <div class="actions" style="text-align:center;">
                    <button class="ui submit button" type="submit">SUBMIT REQUEST</button>
                </div>
            </form>
        </div>
        <div class="image-container">
            <img src="<?= asset('img/contents/bookNow.jpg') ?>" alt="Elegant dining table with white background" />
        </div>
    </div>
</div>