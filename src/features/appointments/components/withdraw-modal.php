<?php
/**
 * Shared Withdraw/Delete Modal
 * 
 * @param string $title
 * @param string $message
 * @param string $confirm_text 
 * @param string $cancel_text (optional)
 */
?>

<!-- Withdraw Confirmation Modal -->
<div id="withdraw-modal"
    class="fixed inset-0 z-[60] hidden items-center justify-center p-4 bg-background/80 backdrop-blur-sm">
    <div class="bg-card w-full max-w-md rounded-[2.5rem] border border-border shadow-2xl p-8">
        <div class="size-20 bg-error/10 text-error rounded-3xl flex items-center justify-center mx-auto mb-6">
            <span class="material-symbols-outlined text-4xl">warning</span>
        </div>
        <h3 class="text-xl font-black text-center mb-2">Withdraw Request?</h3>

        <p class="text-muted-foreground text-center text-sm mb-8">This will cancel your pending appointment request.
            This action cannot be undone.</p>

        <div class="flex flex-col gap-3">
            <button id="confirm-withdraw-btn"
                class="w-full py-4 bg-error font-black rounded-2xl hover:opacity-95 shadow-xl shadow-error/20 transition-all">
                Yes, Withdraw Request
            </button>
            <button onclick="$('#withdraw-modal').addClass('hidden').removeClass('flex')"
                class="w-full py-4 bg-muted text-foreground font-black rounded-2xl hover:bg-muted/80 transition-all">
                Keep Requested Session
            </button>
        </div>
    </div>
</div>

<script>
    $(function () {
        let activeWithdrawUuid = null;

        const title = "<?= $title ?? 'Withdraw Request?' ?>";
        const message = "<?= $message ?? 'This will cancel your pending appointment request. This action cannot be undone.' ?>";
        const confirmText = "<?= $confirm_text ?? 'Yes, Withdraw Request' ?>";

        $('body').on('click', '.withdraw-btn', function () {
            activeWithdrawUuid = $(this).data('uuid');

            $('#withdraw-modal h3').text(title);
            $('#withdraw-modal p').text(message);
            $('#confirm-withdraw-btn').text(confirmText);

            $('#withdraw-modal').removeClass('hidden').addClass('flex');
        });

        $('#confirm-withdraw-btn').on('click', function () {
            if (!activeWithdrawUuid) return;
            const btn = $(this);
            const originalText = btn.text();
            btn.prop('disabled', true).html('<span class="loading loading-spinner"></span> Processing...');

            $.ajax({
                url: apiUrl("appointments") + "cancel-appointment.php",
                method: "POST",
                contentType: "application/json",
                data: JSON.stringify({ appointment_uuid: activeWithdrawUuid }),
                success: function (response) {
                    if (!response.success) {
                        alert(response.message);
                        return;
                    }
                    $('#withdraw-modal').addClass('hidden').removeClass('flex');
                    if (typeof window.fetchAppointments === 'function') {
                        window.fetchAppointments(); // Refresh list
                    }
                },
                complete: function () {
                    btn.prop('disabled', false).text(originalText);
                    activeWithdrawUuid = null;
                }
            });
        });
    });
</script>