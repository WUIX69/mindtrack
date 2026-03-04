<?php
/**
 * Patient Account Deactivation Modal
 * 
 * An editable form modal for patients to securely deactivate their account.
 * Uses CSR and JS object namespace for data and event handling.
 */
?>
<!-- Deactivation Modal Overlay -->
<div id="deactivation-modal"
    class="fixed inset-0 z-[100] h-screen flex items-center justify-center p-4 sm:p-6 modal-overlay hidden"
    style="background-color: rgba(0, 0, 0, 0.6); backdrop-filter: blur(4px);">

    <!-- Modal Content -->
    <div
        class="bg-card dark:bg-card w-full max-w-2xl rounded-[0.75rem] shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">

        <!-- Header -->
        <div
            class="px-8 py-6 border-b border-border flex justify-between items-start bg-card sticky top-0 z-10 w-full shrink-0">
            <div class="flex items-start gap-4">
                <div
                    class="size-12 rounded-full bg-destructive/10 flex items-center justify-center text-destructive shrink-0 mt-1">
                    <span class="material-symbols-outlined text-2xl">warning</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-foreground">Deactivate Account</h3>
                    <p class="text-sm font-semibold text-muted-foreground mt-1">Permanently remove your account and
                        data.</p>
                </div>
            </div>
            <button id="close-deactivation-top-btn"
                class="size-10 flex items-center justify-center rounded-full hover:bg-muted text-muted-foreground hover:text-foreground transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <!-- Scrollable Body (Form) -->
        <div class="flex-1 overflow-y-auto p-8 bg-background/50">
            <div class="mb-8">
                <p class="text-sm text-muted-foreground leading-relaxed font-medium">
                    This action is <span class="font-bold text-destructive">irreversible</span>. All your medical
                    records, session history, and personal data will be archived and become inaccessible immediately
                    upon confirmation.
                </p>
            </div>

            <form id="deactivation-form" class="space-y-6">
                <!-- Reason Selection -->
                <div class="space-y-3">
                    <label class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">help</span> Reason for Leaving
                    </label>

                    <div class="space-y-2">
                        <label
                            class="flex items-center gap-3 p-3 rounded-xl border border-border hover:bg-card/50 cursor-pointer transition-colors bg-card">
                            <input checked class="text-primary focus:ring-primary size-4 border-border bg-background"
                                name="deactivation_reason" type="radio" value="Moving to another clinic" />
                            <span class="text-sm font-semibold text-foreground">Moving to another clinic</span>
                        </label>
                        <label
                            class="flex items-center gap-3 p-3 rounded-xl border border-border hover:bg-card/50 cursor-pointer transition-colors bg-card">
                            <input class="text-primary focus:ring-primary size-4 border-border bg-background"
                                name="deactivation_reason" type="radio" value="Privacy concerns" />
                            <span class="text-sm font-semibold text-foreground">Privacy concerns</span>
                        </label>
                        <label
                            class="flex items-center gap-3 p-3 rounded-xl border border-border hover:bg-card/50 cursor-pointer transition-colors bg-card">
                            <input class="text-primary focus:ring-primary size-4 border-border bg-background"
                                name="deactivation_reason" type="radio" value="No longer need services" />
                            <span class="text-sm font-semibold text-foreground">No longer need services</span>
                        </label>
                        <div>
                            <label
                                class="flex items-center gap-3 p-3 rounded-xl border border-border hover:bg-card/50 cursor-pointer transition-colors bg-card">
                                <input class="text-primary focus:ring-primary size-4 border-border bg-background"
                                    name="deactivation_reason" id="other_reason_radio" type="radio" value="Other" />
                                <span class="text-sm font-semibold text-foreground">Other</span>
                            </label>
                            <div id="other_feedback_container" class="mt-3 hidden">
                                <label
                                    class="block text-[10px] font-bold text-muted-foreground mb-1.5 ml-1 uppercase tracking-wider">Please
                                    tell us more (optional)</label>
                                <textarea name="other_feedback" id="other_feedback"
                                    class="w-full px-4 py-3 bg-card border border-border rounded-xl text-sm focus:ring-2 focus:ring-primary/20 transition-all resize-y placeholder:text-muted-foreground/50"
                                    placeholder="Your feedback helps us improve our care..." rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Confirmation Input -->
                <div class="space-y-3 pt-4 border-t border-border">
                    <label class="text-xs font-bold text-destructive uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">gpp_bad</span> Security Confirmation
                    </label>
                    <p class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1">
                        To confirm, please type <span class="text-destructive">DEACTIVATE</span>
                    </p>
                    <input id="deactivation-confirmation-input"
                        class="w-full px-4 py-3 bg-card border border-border rounded-xl text-sm font-bold focus:ring-2 focus:ring-destructive/20 transition-all placeholder:font-normal placeholder:normal-case uppercase"
                        placeholder="Type here..." type="text" autocomplete="off" />
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div
            class="px-8 py-5 border-t border-border flex flex-col sm:flex-row justify-end gap-3 bg-card sticky bottom-0 z-10 w-full shrink-0">
            <button type="button" id="close-deactivation-btn"
                class="px-6 py-2.5 text-sm font-bold text-muted-foreground hover:text-foreground transition-all border border-border rounded-lg hover:border-foreground/20 w-full sm:w-auto">
                Cancel
            </button>
            <button type="button" id="submit-deactivation-btn" disabled
                class="px-8 py-2.5 bg-destructive text-destructive-foreground rounded-lg text-sm font-bold hover:bg-destructive/90 transition-all shadow-lg shadow-destructive/25 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed w-full sm:w-auto">
                <span class="material-symbols-outlined text-sm hidden animate-spin"
                    id="deactivation-spinner">progress_activity</span>
                Confirm Deactivation
            </button>
        </div>
    </div>
</div>

<script>
    const DeactivationModal = {
        $modal: $('#deactivation-modal'),
        $form: $('#deactivation-form'),
        $confirmInput: $('#deactivation-confirmation-input'),
        $submitBtn: $('#submit-deactivation-btn'),
        $spinner: $('#deactivation-spinner'),

        open: function () {
            this.resetForm();
            this.$modal.removeClass('hidden').addClass('flex');
            $('body').addClass('overflow-hidden');
        },

        close: function () {
            this.$modal.addClass('hidden').removeClass('flex');
            $('body').removeClass('overflow-hidden');
            this.resetForm();
        },

        resetForm: function () {
            this.$form[0].reset();
            this.$confirmInput.val('');
            this.$submitBtn.prop('disabled', true);
            this.$form.find('input, textarea').prop('disabled', false);
        },

        handleValidation: function () {
            const val = this.$confirmInput.val().trim().toUpperCase();
            if (val === 'DEACTIVATE') {
                this.$submitBtn.prop('disabled', false);
            } else {
                this.$submitBtn.prop('disabled', true);
            }
        },

        submit: function () {
            if (this.$confirmInput.val().trim().toUpperCase() !== 'DEACTIVATE') {
                return;
            }

            const formData = new FormData(this.$form[0]);
            const payload = Object.fromEntries(formData.entries());
            payload.confirmation = this.$confirmInput.val().trim();

            const originalBtnText = typeof this.$submitBtn[0].childNodes[2] !== 'undefined' ? this.$submitBtn[0].childNodes[2].nodeValue : ' Confirm Deactivation';

            this.$submitBtn.prop('disabled', true);
            this.$submitBtn.contents().filter(function () { return this.nodeType === 3; }).remove();
            this.$submitBtn.append(document.createTextNode(' Processing...'));
            this.$spinner.removeClass('hidden');
            this.$form.find('input, textarea').prop('disabled', true);
            this.$confirmInput.prop('disabled', true);
            $('#close-deactivation-btn, #close-deactivation-top-btn').prop('disabled', true);

            $.ajax({
                url: apiUrl('settings') + 'deactivation.php',
                type: 'POST',
                data: payload,
                dataType: 'json',
                success: (response) => {
                    try {
                        const res = response;
                        if (res.success) {
                            if (window.toast && window.toast.success) {
                                window.toast.success(res.message || 'Account deactivated.');
                            } else {
                                alert(res.message || 'Account deactivated.');
                            }
                            // Redirect user to login area or home
                            setTimeout(() => {
                                window.location.href = "<?= app('auth') ?>";
                            }, 1500);
                        } else {
                            if (window.toast && window.toast.error) {
                                window.toast.error(res.message || 'Validation failed.');
                            } else {
                                alert(res.message || 'Validation failed.');
                            }
                            this.unlockForm(originalBtnText);
                        }
                    } catch (e) {
                        console.error('Parse error:', e);
                        this.unlockForm(originalBtnText);
                        if (window.toast && window.toast.error) window.toast.error('An unexpected error occurred.');
                    }
                },
                error: () => {
                    this.unlockForm(originalBtnText);
                    if (window.toast && window.toast.error) window.toast.error('Connection error.');
                }
            });
        },

        unlockForm: function (originalBtnText) {
            this.$submitBtn.prop('disabled', false);
            this.$submitBtn.contents().filter(function () { return this.nodeType === 3; }).remove();
            this.$submitBtn.append(document.createTextNode(originalBtnText));
            this.$spinner.addClass('hidden');
            this.$form.find('input, textarea').prop('disabled', false);
            this.$confirmInput.prop('disabled', false);
            $('#close-deactivation-btn, #close-deactivation-top-btn').prop('disabled', false);
            // Re-run validation so button toggles correctly if value is still valid
            this.handleValidation();
        }
    };

    $(document).ready(function () {
        // Confirmation Input listener
        $('#deactivation-confirmation-input').on('input', function () {
            DeactivationModal.handleValidation();
        });

        // Submit Button listener
        $('#submit-deactivation-btn').on('click', function (e) {
            e.preventDefault();
            DeactivationModal.submit();
        });

        // Close handlers
        $('#close-deactivation-btn, #close-deactivation-top-btn').on('click', function () {
            DeactivationModal.close();
        });

        // Close on escape
        $(document).on('keydown', function (e) {
            if (e.key === 'Escape' && !$('#deactivation-modal').hasClass('hidden')) {
                DeactivationModal.close();
            }
        });

        // Close on click outside
        $('#deactivation-modal').on('click', function (e) {
            if (e.target === this) {
                DeactivationModal.close();
            }
        });

        // Radio button listener for "Other" option
        $('input[name="deactivation_reason"]').on('change', function () {
            if ($('#other_reason_radio').is(':checked')) {
                $('#other_feedback_container').slideDown(200);
            } else {
                $('#other_feedback_container').slideUp(200);
            }
        });
    });
</script>