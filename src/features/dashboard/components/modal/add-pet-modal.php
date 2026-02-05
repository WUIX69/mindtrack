<!-- Add Pet Modal -->
<div class="ui tiny modal add-pet-modal" id="addPetModal">
    <i class="close icon"></i>
    <div class="header">
        <i class="paw icon"></i> Add New Pet
    </div>
    <div class="content">
        <form class="ui form" id="addPetForm">
            <div class="field">
                <label>Pet Name</label>
                <input type="text" name="pet_name" placeholder="Enter pet name" required>
            </div>
            <div class="field">
                <label>Breed</label>
                <input type="text" name="pet_breed" placeholder="Enter breed" required>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>Age</label>
                    <input type="text" name="pet_age" placeholder="e.g. 3 years" required>
                </div>
                <div class="field">
                    <label>Notes</label>
                    <input type="text" name="pet_notes" placeholder="e.g. Loves to wear ties.">
                </div>
            </div>
            <div class="field">
                <label>Avatar</label>
                <input type="file" name="pet_avatar" accept="image/*">
            </div>
            <div class="actions" style="margin-top: 18px;">
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