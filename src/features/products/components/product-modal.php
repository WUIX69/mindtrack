<?php
use VetSync\Models\Categories;
$categories = Categories::all('products')['data'] ?? [];
?>
<style>
    .product-form-modal form .field textarea {
        min-height: 100px;
    }
</style>
<!-- Product Modal -->
<div class="ui tiny modal product-form-modal" id="productModal">
    <i class="close icon"></i>
    <div class="header">
        <i class="plus circle icon"></i> Add New Product
    </div>
    <div class="content">
        <form class="ui form" enctype="multipart/form-data">
            <input type="hidden" name="uuid"> <!-- For edit -->
            <div class="field">
                <label>Product Name</label>
                <input type="text" name="name" placeholder="Enter product name">
            </div>
            <div class="field">
                <label>Description</label>
                <textarea name="description" rows="3" placeholder="Enter product description"></textarea>
            </div>
            <div class="three fields">
                <div class="field">
                    <label>Original Price</label>
                    <div class="ui labeled input">
                        <div class="ui label">&#8369;</div>
                        <input type="decimal" name="og_price" placeholder="0.00">
                    </div>
                </div>
                <div class="field">
                    <label>Discounted Price</label>
                    <div class="ui labeled input">
                        <div class="ui label">&#8369;</div>
                        <input type="decimal" name="dc_price" placeholder="0.00">
                    </div>
                </div>
                <div class="field">
                    <label>Stock</label>
                    <input type="number" name="stock" placeholder="0" min="1">
                </div>
            </div>
            <div class="two fields">
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
                    <div class="ui fluid floating selection dropdown">
                        <input type="hidden" name="category_id">
                        <i class="dropdown icon"></i>
                        <div class="default text">Select Category</div>
                        <div class="menu">
                            <!-- Category Options -->
                            <?php foreach ($categories as $category) { ?>
                                <div class="item" data-value="<?= $category['id'] ?>">
                                    <i class="<?= $category['icon'] ?> icon"></i><?= $category['name'] ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field">
                <label>Tags</label>
                <div class="ui fluid multiple search selection dropdown" id="tagsDropdown">
                    <input type="hidden" name="tags">
                    <i class="dropdown icon"></i>
                    <div class="default text">Select Tags</div>
                    <div class="menu">
                        <div class="item" data-value="organic">Organic</div>
                        <div class="item" data-value="grainfree">Grain-Free</div>
                        <div class="item" data-value="puppy">Puppy</div>
                        <div class="item" data-value="senior">Senior</div>
                        <div class="item" data-value="hypoallergenic">Hypoallergenic</div>
                        <div class="item" data-value="bestseller">Bestseller</div>
                        <div class="item" data-value="new">New Arrival</div>
                        <div class="item" data-value="limited">Limited Edition</div>
                    </div>
                </div>
            </div>
            <div class="field">
                <label>Specs</label>
                <div class="ui fluid multiple search selection dropdown" id="specsDropdown">
                    <input type="hidden" name="specs">
                    <i class="dropdown icon"></i>
                    <div class="default text">Select Specs</div>
                    <div class="menu">
                        <div class="item" data-value="smallbreed">Small Breed</div>
                        <div class="item" data-value="largebreed">Large Breed</div>
                        <div class="item" data-value="chicken">Chicken Flavor</div>
                        <div class="item" data-value="beef">Beef Flavor</div>
                        <div class="item" data-value="1kg">1kg Pack</div>
                        <div class="item" data-value="5kg">5kg Pack</div>
                        <div class="item" data-value="softchews">Soft Chews</div>
                        <div class="item" data-value="liquid">Liquid</div>
                        <div class="item" data-value="tablet">Tablet</div>
                    </div>
                </div>
            </div>
            <div class="field">
                <label>Upload Image</label>
                <input type="file" name="file" class="filepond product-pond">
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