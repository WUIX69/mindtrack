/**
 * Appointment Status Colors
 *
 * Maps appointment statuses to their corresponding Tailwind CSS classes.
 * Used in admin appointments table and summary modal.
 */
const APPOINTMENT_STATUS_COLORS = {
    pending:
        "bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400",
    confirmed:
        "bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400",
    scheduled:
        "bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400", // Fallback for legacy status
    completed:
        "bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400",
    cancelled: "bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400",
    no_show: "bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-400",
    rescheduled:
        "bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400",
};
