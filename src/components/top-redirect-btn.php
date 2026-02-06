<style>
    /*--- Top Redirect Button ---*/
    body.scrolled .shared-standalone-content .top-redirect-button {
        display: block;
    }

    .shared-standalone-content .top-redirect-button {
        display: none;
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        z-index: 101;
        transition: all 0.3s ease;
    }

    .shared-standalone-content .top-redirect-button button {
        background: #00b5ad !important;
        color: var(--color-white) !important;
        transition: all 0.3s ease;
    }

    .shared-standalone-content .top-redirect-button button:hover {
        opacity: 0.8;
        transform: scale(1.05);
    }

    .shared-standalone-content .top-redirect-button button:hover span {
        animation: upDown 2s infinite;
    }

    @keyframes upDown {

        0%,
        100% {
            transform: translateY(0) scale(1.05);
        }

        50% {
            transform: translateY(-5px) scale(1.05);
        }
    }

    /*--- Top Redirect Button END ---*/
</style>
<div class="top-redirect-button">
    <button class="ui circular icon button">
        <span class="material-icons-sharp">arrow_upward</span>
    </button>
</div>