<style>
    .category-form-modal form .field textarea {
        min-height: 100px;
    }
</style>
<div class="ui tiny modal category-form-modal" id="productCategoryModal">
    <i class="close icon"></i>
    <div class="header">
        <i class="plus circle icon"></i> Add New Product Category
    </div>
    <div class="content">
        <form class="ui form">
            <input type="hidden" name="id"> <!-- For edit -->
            <div class="field">
                <label>Category Name</label>
                <input type="text" name="name" placeholder="Enter category name">
            </div>
            <div class="field">
                <label>Description</label>
                <textarea name="description" rows="3" placeholder="Enter category description"></textarea>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>Icon</label>
                    <div class="ui selection dropdown">
                        <input type="hidden" name="icon">
                        <i class="dropdown icon"></i>
                        <div class="default text">Select Icon</div>
                        <div class="menu">
                            <div class="item" data-value="stethoscope"><i class="stethoscope icon"></i>Stethoscope</div>
                            <div class="item" data-value="syringe"><i class="syringe icon"></i>Syringe</div>
                            <div class="item" data-value="cut"><i class="cut icon"></i>Scalpel</div>
                            <div class="item" data-value="paw"><i class="paw icon"></i>Paw</div>
                            <div class="item" data-value="tooth"><i class="tooth icon"></i>Tooth</div>
                            <div class="item" data-value="heartbeat"><i class="heartbeat icon"></i>Heartbeat</div>
                            <div class="item" data-value="shower"><i class="shower icon"></i>Shower</div>
                            <div class="item" data-value="medkit"><i class="medkit icon"></i>Medkit</div>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label>Status</label>
                    <div class="ui selection dropdown">
                        <input type="hidden" name="status">
                        <i class="dropdown icon"></i>
                        <div class="default text">Select Status</div>
                        <div class="menu">
                            <div class="item" data-value="active"><i class="check circle green icon"></i>Active</div>
                            <div class="item" data-value="inactive"><i class="times circle red icon"></i>Inactive</div>
                        </div>
                    </div>
                </div>
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