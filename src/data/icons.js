/**
 * Appointment Service Icons
 * Maps service names to Material Symbols
 */
const SERVICE_ICONS = {
    Therapy: "diversity_1",
    Assessment: "fact_check",
    Consultation: "medical_services",
    Programs: "groups",
    Psychotherapy: "diversity_1",
    CBT: "auto_graph",
    "Psychological Testing": "fact_check",
};

/**
 * Get icon for a service
 * @param {string} serviceName
 * @returns {string} Material Symbol name
 */
function getServiceIcon(serviceName) {
    return SERVICE_ICONS[serviceName] || "health_and_safety";
}
