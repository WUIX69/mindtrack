<script>
    function ajaxErrorHandler(jqXHR, textStatus, errorThrown, error) {
        console.log("Detailed error information:");
        console.log("Stringy Response:", JSON.stringify(jqXHR));
        console.log("Server Response: ", jqXHR);
        console.log("Status of the request: ", textStatus);
        console.log("Error thrown by the request: ", errorThrown);
        console.log("Error:", error);
        return false;
    }

    function onErrorHandler(errorMessage, xhr, jqXHR, textStatus, error) {
        console.error("errorMessage", errorMessage);
        console.error("xhr", xhr);
        console.log("Stringy Response:", JSON.stringify(jqXHR));
        console.log("responseText", JSON.stringify(jqXHR.responseText));
        console.error("textStatus", textStatus);
        console.error("error:", error);
    }

    /**
     * Returns the API base URL for a given feature or for shared APIs.
     *
     * @param {string|null} feature - The feature name (e.g., "products"), or "shared" for shared APIs.
     * @returns {string} The full API base URL for the specified feature.
     */
    function apiURL(feature = null) {
        let url = "";

        if (feature === "shared" || feature === null) {
            url = baseURL() + "servers/";
        } else {
            url = baseURL() + "features/" + feature + "/servers/";
        }

        return url;
    }
</script>