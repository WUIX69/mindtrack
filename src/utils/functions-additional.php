<!-- Uses for JQUERY/JS -->
<script>
    function asset(file = "") {
        // Generate a URL for a dummy file "REPLACE_ME"
        const template = "<?php echo urlFileHelper('public', 'REPLACE_ME', true); ?>";
        // Replace the dummy text with the actual JS argument
        return template.replace("REPLACE_ME", file);
    }

    function route($link = "") {
        // Handle empty link case
        if (link === "") {
            return <?php echo urlFileHelper("app", "landing"); ?>;
        }

        // Check if the link ends with a trailing slash (indicating a directory)
        if (link.endsWith("/")) {
            url = link + "index.php";
        }
        // Check if the link has no slashes (just a directory name)
        else if (link.indexOf("/") === -1) {
            url = link + "/index.php";
        }
        // Handle paths with subdirectories
        else {
            // Check if the path contains a file extension
            if (link.match(/\.[a-zA-Z0-9]+$/)) {
                // If it already has an extension, use it as is
                url = link;
            } else {
                // No extension, so add .php
                url = link + ".php";
            }
        }

        // Ensure we have the .php extension
        if (url.endsWith(".php") === false) {
            url += ".php";
        }

        const template = "<?php echo urlFileHelper('app', 'REPLACE_ME'); ?>";
        return template.replace("REPLACE_ME", url);
    }

    /**
     * Returns the server actions for a given feature or for shared actions.
     *
     * @param {string|null} feature - The feature name (e.g., "products"), or "shared" for shared actions.
     * @returns {string} The full actions base URL for the specified feature.
     */
    function apiUrl(feature = null) {
        let url = "";

        if (feature === "shared" || feature === null) {
            url = <?php baseURL() ?> + "src/server/actions/";
        } else {
            url = <?php baseURL() ?> + "src/features/" + feature + "/server/actions/";
        }

        return url;
    }

</script>