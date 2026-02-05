<?php
use Mindtrack\Server\Db\Categories;
$categories = Categories::all('services')['data'] ?? [];
?>
<style>
    /* Service Form Modal */
    .service-form-modal .ui.form .field {
        margin-bottom: 1.2rem;
    }

    .service-form-modal .ui.form label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .service-form-modal .ui.form .field.image-preview {
        margin-top: 1rem;
    }

    .service-form-modal .ui.form .field.image-preview img {
        max-width: 100%;
        border-radius: 0.5rem;
        border: 1px solid #e2e8f0;
    }
</style>
<div class="ui tiny modal service-form-modal" id="serviceModal">
    <i class="close icon"></i>
    <div class="header">
        <i class="plus circle icon"></i> Add New Service
    </div>
    <div class="content">
        <form class="ui form">
            <input type="hidden" name="uuid">
            <div class="field">
                <label>Service Name</label>
                <input type="text" name="name" placeholder="Enter service name">
            </div>
            <div class="field">
                <label>Description</label>
                <textarea name="description" rows="3" placeholder="Enter service description"></textarea>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>Price</label>
                    <div class="ui labeled input">
                        <div class="ui label">&#8369;</div>
                        <input type="number" name="price" placeholder="0.00">
                    </div>
                </div>
                <div class="field">
                    <label>Duration (minutes)</label>
                    <input type="number" name="duration" placeholder="30">
                </div>
            </div>
            <div class="field">
                <label>Status</label>
                <div class="ui selection dropdown">
                    <input type="hidden" name="status">
                    <i class="dropdown icon"></i>
                    <div class="default text">Select Status</div>
                    <div class="menu">
                        <div class="item" data-value="available">
                            <i class="check circle green icon"></i>Available
                        </div>
                        <div class="item" data-value="unavailable">
                            <i class="times circle red icon"></i>Unavailable
                        </div>
                    </div>
                </div>
            </div>
            <div class="field">
                <label>Category</label>
                <div class="ui selection dropdown">
                    <input type="hidden" name="category_id">
                    <i class="dropdown icon"></i>
                    <div class="default text">Select Category</div>
                    <div class="menu">
                        <!-- Category Options for services -->
                        <?php foreach ($categories as $category) { ?>
                            <div class="item" data-value="<?= $category['id'] ?>">
                                <i class="<?= $category['icon'] ?> icon"></i><?= $category['name'] ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="field">
                <label>Upload Image</label>
                <input type="file" name="file" class="filepond service-pond">
            </div>
            <div class="actions">
                <button class="ui black deny clear button" type="reset">
                    Cancel
                </button>
                <button class="ui positive right labeled icon submit button" type="submit">
                    Save
                    <i class="checkmark icon"></i>
                </button>
            </div>
        </form>
    </div>
</div>