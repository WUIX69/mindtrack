/**
 * MindTrack Middleware Functions
 * JavaScript utilities for AJAX handling and API communication
 */

/**
 * Returns the base URL of the application
 * @returns {string} The base URL
 */
function baseURL() {
  const protocol = window.location.protocol;
  const host = window.location.host;
  const pathArray = window.location.pathname.split("/");

  // Get subfolder if exists (e.g., /mindtrack/)
  const subFolder = pathArray[1] || "";

  return `${protocol}//${host}/${subFolder}/`;
}

/**
 * Returns the API base URL for a given feature or for shared APIs.
 *
 * @param {string|null} feature - The feature name (e.g., "auth"), or "shared" for shared APIs.
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

/**
 * AJAX error handler for debugging
 * @param {object} jqXHR - jQuery XHR object
 * @param {string} textStatus - Status text
 * @param {string} errorThrown - Error thrown
 * @param {string} error - Additional error info
 * @returns {boolean}
 */
function ajaxErrorHandler(jqXHR, textStatus, errorThrown, error) {
  console.log("Detailed error information:");
  console.log("Stringy Response:", JSON.stringify(jqXHR));
  console.log("Server Response: ", jqXHR);
  console.log("Status of the request: ", textStatus);
  console.log("Error thrown by the request: ", errorThrown);
  console.log("Error:", error);
  return false;
}

/**
 * General error handler
 * @param {string} errorMessage - Error message
 * @param {object} xhr - XHR object
 * @param {object} jqXHR - jQuery XHR object
 * @param {string} textStatus - Status text
 * @param {string} error - Error info
 */
function onErrorHandler(errorMessage, xhr, jqXHR, textStatus, error) {
  console.error("errorMessage", errorMessage);
  console.error("xhr", xhr);
  console.log("Stringy Response:", JSON.stringify(jqXHR));
  console.log("responseText", JSON.stringify(jqXHR.responseText));
  console.error("textStatus", textStatus);
  console.error("error:", error);
}
