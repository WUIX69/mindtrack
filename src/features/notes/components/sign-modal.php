<?php
/**
 * Sign Clinical Note Modal
 *
 * A reusable confirmation modal for finalizing and signing notes.
 */
?>
<!-- Modal Overlay -->
<div id="sign-note-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 modal-overlay hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity opacity-0 modal-backdrop"></div>

    <!-- Modal Content -->
    <div
        class="bg-card dark:bg-card w-full max-w-md p-6 rounded-xl shadow-2xl overflow-hidden flex flex-col relative z-10 transform scale-95 opacity-0 transition-all duration-300 modal-panel border border-border">

        <div class="flex items-start gap-4">
            <div
                class="flex items-center justify-center flex-shrink-0 w-12 h-12 rounded-full bg-primary/10 text-primary">
                <span class="material-symbols-outlined text-2xl">draw</span>
            </div>
            <div class="flex-1 mt-1">
                <h3 class="text-lg font-bold text-foreground">Sign Clinical Note</h3>
                <p class="mt-2 text-sm text-muted-foreground leading-relaxed">
                    Are you sure you want to finalize and sign this note? Once signed, the note becomes read-only and
                    cannot be modified.
                </p>
            </div>
        </div>

        <div class="flex justify-end mt-8 gap-3">
            <button type="button"
                class="btn-cancel px-4 py-2 text-sm font-semibold rounded-xl text-foreground bg-muted hover:bg-muted/80 transition-colors">
                Cancel
            </button>
            <button type="button"
                class="btn-confirm px-4 py-2 text-sm font-semibold rounded-xl shadow-sm transition-colors bg-primary text-primary-foreground hover:bg-primary/90">
                Yes, Sign Note
            </button>
        </div>

    </div>
</div>

<script>
    // --- Sign Action & Modal ---
    const $modal = $('#sign-note-modal');
    const $backdrop = $modal.find('.modal-backdrop');
    const $panel = $modal.find('.modal-panel');

    function openModal() {
        $modal.removeClass('hidden');
        // Trigger reflow
        void $modal[0].offsetWidth;
        $backdrop.removeClass('opacity-0').addClass('opacity-100');
        $panel.removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100');
    }

    function closeModal() {
        $backdrop.removeClass('opacity-100').addClass('opacity-0');
        $panel.removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
        setTimeout(() => {
            $modal.addClass('hidden');
        }, 300);
    }

    $('#btn-sign-note').click(function () {
        if (typeof window.currentAppointmentUuid === 'undefined' || !window.currentAppointmentUuid || window.isNoteSigned) return;
        openModal();
    });

    // Modal Close Triggers
    $modal.find('.btn-cancel').click(closeModal);
    $backdrop.click(closeModal);

    $modal.find('.btn-confirm').click(function () {
        if (typeof window.getNoteFormData !== 'function') {
            alert('Cannot save note data. Missing function.');
            return;
        }

        const data = window.getNoteFormData('signed');
        const $btn = $(this);
        $btn.text('Signing...').prop('disabled', true);

        // console.log(data);
        // return false;

        $.ajax({
            url: window.API_URL,
            method: 'POST',
            data: JSON.stringify(data),
            dataType: 'json',
            contentType: 'application/json',
            success: function (resp) {
                // console.log(resp);
                // return false;
                $btn.text('Yes, Sign Note').prop('disabled', false);
                try {
                    const res = typeof resp === 'string' ? JSON.parse(resp) : resp;
                    alert(res.message);
                    if (res.success) {
                        closeModal();
                        // Reload the editor to reflect signed status
                        if (typeof loadNoteEditor === 'function') {
                            loadNoteEditor(window.currentAppointmentUuid);
                        }
                    } else {
                        alert(res.message);
                    }
                } catch (e) {
                    alert('Error signing note');
                    console.error(e);
                }
            },
            error: function () {
                $btn.text('Yes, Sign Note').prop('disabled', false);
                alert('Connection error');
            }
        });
    });
</script>