$(function () {
    const urlInputs = $(".url-inputs");
    // urlInputs.empty();

    // Add URL input field
    $(".add-url-btn").on("click", function (e) {
        e.preventDefault();
        // Create the input element directly with jQuery
        let newInput = $(
            '<input type="url" placeholder="Enter your URL" name="urls[]" />'
        );
        urlInputs.append(newInput);
    });

    // Remove URL input field
    $(".remove-url-btn").on("click", function (e) {
        e.preventDefault();
        // Select the last input field within .url-inputs and remove it
        if (urlInputs.children("input").length > 1) {
            urlInputs.children("input").last().remove();
        }
    });
});
