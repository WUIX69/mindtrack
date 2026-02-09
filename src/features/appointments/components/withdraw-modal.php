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

        $('body').on('click', '.withdraw-btn', function () {
            activeWithdrawUuid = $(this).data('uuid');
            $('#withdraw-modal h3').text('Withdraw Request?');
            $('#withdraw-modal p').text('Are you sure you want to retract your pending appointment request?');
            $('#withdraw-modal').removeClass('hidden').addClass('flex');
        });

        $('#confirm-withdraw-btn').on('click', function () {
            if (!activeWithdrawUuid) return;
            const btn = $(this);
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
                    btn.prop('disabled', false).text('Yes, Withdraw Request');
                    activeWithdrawUuid = null;
                }
            });
        });
    });
</script>