<?php
/**
 * Shared Confirmation Modal
 * 
 * @param string $title 
 * @param string $message
 * @param string $confirm_text 
 * @param string $cancel_text (optional)
 */
?>
<!-- Confirmation Modal -->
<div id="confirmation-modal"
    class="fixed inset-0 z-[60] hidden items-center justify-center p-4 bg-background/80 backdrop-blur-sm">
    <div class="bg-card w-full max-w-md rounded-[2.5rem] border border-border shadow-2xl p-8">
        <div class="size-20 bg-success/10 text-success rounded-3xl flex items-center justify-center mx-auto mb-6">
            <span class="material-symbols-outlined text-4xl">check_circle</span>
        </div>
        <h3 class="text-xl font-black text-center mb-2">Confirm Appointment?</h3>
        <p class="text-muted-foreground text-center text-sm mb-8">This will confirm the selected appointment and notify
            the patient.</p>

        <div class="flex flex-col gap-3">
            <button id="confirm-appt-btn"
                class="w-full py-4 bg-success font-black rounded-2xl hover:opacity-95 shadow-xl shadow-success/20 transition-all">
                Yes, Confirm Appointment
            </button>
            <button onclick="$('#confirmation-modal').addClass('hidden').removeClass('flex')"
                class="w-full py-4 bg-muted text-foreground font-black rounded-2xl hover:bg-muted/80 transition-all">
                Cancel
            </button>
        </div>
    </div>
</div>

<script>
    $(function () {
        let activeConfirmUuid = null;

        const title = "<?= $title ?? 'Confirm Appointment?' ?>";
        const message = "<?= $message ?? 'This will confirm the selected appointment and notify the patient.' ?>";
        const confirmText = "<?= $confirm_text ?? 'Yes, Confirm Appointment' ?>";

        $('body').on('click', '.confirm-appt-trigger', function () {
            activeConfirmUuid = $(this).data('uuid');

            $('#confirmation-modal h3').text(title);
            $('#confirmation-modal p').text(message);
            $('#confirm-appt-btn').text(confirmText);

            $('#confirmation-modal').removeClass('hidden').addClass('flex');
        });

        $('#confirm-appt-btn').on('click', function () {
            if (!activeConfirmUuid) return;
            const btn = $(this);
            const originalText = btn.text();
            btn.prop('disabled', true).html('<span class="loading loading-spinner"></span> Processing...');

            $.ajax({
                url: apiUrl("appointments") + "confirm-appointment.php",
                method: "POST",
                contentType: "application/json",
                data: JSON.stringify({ appointment_uuid: activeConfirmUuid }),
                success: function (response) {
                    if (!response.success) {
                        alert(response.message);
                        return;
                    }
                    $('#confirmation-modal').addClass('hidden').removeClass('flex');
                    if (typeof window.fetchAppointments === 'function') {
                        window.fetchAppointments(); // Refresh list
                    }
                },
                complete: function () {
                    btn.prop('disabled', false).text(originalText);
                    activeConfirmUuid = null;
                }
            });
        });
    });
</script>