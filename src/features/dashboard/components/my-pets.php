<style>
    main section.my-pets .header .tabs {
        background: #f3f3f3;
        padding: 4px;
        border-radius: 20px;
        display: flex;
        gap: 5px;
    }

    main section.my-pets .header .tabs a {
        padding: 4px 20px;
        font-size: 12px;
        color: #000;
        border-radius: 20px;
        font-weight: 600;
    }

    main section.my-pets .header .tabs a.active {
        background: #fff;
    }

    /* New styles for pet avatars */
    main section.my-pets .pet-items {
        display: flex;
        gap: 1rem;
        justify-content: center;
        align-items: start;
        flex-wrap: wrap;

        padding: 0;
        margin: 0;
    }

    main section.my-pets .pet-items .item {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 120px;
    }

    main section.my-pets .pet-items .item .avatar-img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: #fff;
        object-fit: cover;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        /* font-size: 48px; */
        color: #bbb;
        border: 2px solid #e0e0e0;
        transition: box-shadow 0.2s;
    }

    main section.my-pets .pet-items .add-pet-btn {
        border-radius: 50%;
        width: 100px;
        height: 100px;
    }
</style>
<section class="my-pets">
    <div class="header">
        <h4>My pets</h4>
    </div>
    <ul class="pet-items">
        <!-- Dynamic loaded on myPets.js -->
    </ul>
</section>

<!-- Rate Us Modal -->
<div class="ui tiny modal" id="rateUsModal">
    <div class="header">
        <i class="star icon"></i> Rate Us
    </div>
    <div class="content" style="text-align:center;">
        <p>We'd love to hear your feedback!</p>
        <div class="rate-stars" id="rateStars">
            <i class="star icon rate-star" data-value="1"></i>
            <i class="star icon rate-star" data-value="2"></i>
            <i class="star icon rate-star" data-value="3"></i>
            <i class="star icon rate-star" data-value="4"></i>
            <i class="star icon rate-star" data-value="5"></i>
        </div>
        <form class="ui form" id="rateUsForm">
            <div class="field">
                <textarea id="rateUsMessage" rows="3" placeholder="Write your feedback here..."></textarea>
            </div>
            <div class="actions" style="margin-top: 16px;">
                <button type="button" class="ui button" id="rateUsCancelBtn">Cancel</button>
                <button type="submit" class="ui blue button">Submit</button>
            </div>
        </form>
    </div>
</div>