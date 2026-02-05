<style>
    /* FAQs section */
    main section.about .faqs {
        margin-bottom: 4rem;
    }

    main section.about .faqs .faqs-accordion {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    main section.about .faqs .faqs-accordion .accordion-item {
        border: 1px solid var(--bs-border-color) !important;
        border-radius: 0.4rem;
        overflow: hidden;
    }

    main section.about .faqs .faqs-accordion .accordion-item .accordion-header button {
        font-size: 1rem;
        font-weight: 500;
    }

    main section.about .faqs .faqs-accordion .accordion-item .accordion-body {
        font-size: 0.9rem;
        padding: 1.5rem;
        line-height: 1.5;
    }
</style>
<div class="faqs">
    <h2 class="mb-4 mt-1">FAQs</h2>
    <div class="accordion faqs-accordion" id="faqsAccordion">
        <div class="accordion-item">
            <div class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    What is a dog?
                </button>
            </div>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                data-bs-parent="#faqsAccordion">
                <div class="accordion-body">
                    A dog is a type of domesticated animal. Known for its loyalty
                    and faithfulness, it can be found as a welcome guest in many households across
                    the
                    world.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <div class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    What kinds of dogs are there?
                </button>
            </div>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                data-bs-parent="#faqsAccordion">
                <div class="accordion-body">
                    There are many breeds of dogs. Each breed varies in size and temperament. Owners
                    often
                    select a breed of dog that they find to be compatible with their own lifestyle
                    and
                    desires from a companion.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <div class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    How do you acquire a dog?
                </button>
            </div>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                data-bs-parent="#faqsAccordion">
                <div class="accordion-body">
                    Three common ways for a prospective owner to acquire a dog is from pet shops,
                    private
                    owners, or shelters.
                    A pet shop may be the most convenient way to buy a dog. Buying a dog from a
                    private owner
                    allows you to assess the pedigree and upbringing of your dog before choosing to
                    take it
                    home. Lastly, finding your dog from a shelter, helps give a good home to a dog
                    who may
                    not find one so readily.
                </div>
            </div>
        </div>
    </div>
</div>