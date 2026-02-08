<style>
    main section .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 3rem;
    }

    main section .pagination .page-item {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--color-white);
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    main section .pagination .page-item i {
        margin: 0;
    }

    main section .pagination .page-item:hover {
        background-color: var(--color-primary-light);
    }

    main section .pagination .page-item.active {
        background-color: var(--color-dark);
        color: var(--color-white);
    }
</style>
<!-- Pagination -->
<div class="pagination">
    <div class="page-item">
        <i class="angle left icon"></i>
    </div>
    <div class="page-item active">1</div>
    <div class="page-item">2</div>
    <div class="page-item">3</div>
    <div class="page-item">
        <i class="angle right icon"></i>
    </div>
</div>