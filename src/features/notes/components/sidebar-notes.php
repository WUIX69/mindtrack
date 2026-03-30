<!-- Inner Sidebar: Session List -->
<aside class="w-80 border-r border-border bg-card flex flex-col shrink-0 h-screen">
    <div class="p-6 border-b border-border">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-black text-foreground tracking-tight">Reported Symptoms</h3>
        </div>
        <div class="relative group">
            <span
                class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-muted-foreground group-focus-within:text-primary transition-colors text-lg font-variation-settings-['wght'_400]">search</span>
            <input id="notes-search-input"
                class="w-full pl-11 pr-4 py-2.5 bg-muted/30 border border-border rounded-xl text-sm focus:border-primary focus:ring-1 focus:ring-primary/20 transition-all placeholder:text-muted-foreground/60"
                placeholder="Filter patients..." type="text" />
        </div>
    </div>

    <div id="notes-sidebar-list" class="flex-1 overflow-y-auto scrollbar-hide">
        <div class="p-8 text-center text-muted-foreground text-sm">Loading sessions...</div>
    </div>
</aside>

<script>
    $(document).ready(function () {

        window.fetchSidebarNotes = function () {
            $.ajax({
                url: window.API_URL + '?action=list',
                method: 'GET',
                success: function (resp) {
                    try {
                        const res = typeof resp === 'string' ? JSON.parse(resp) : resp;
                        if (res.success) {
                            window.currentNotes = res.data;
                            window.renderSidebarNotes(window.currentNotes);
                        } else {
                            $('#notes-sidebar-list').html(`<div class="p-8 text-center text-red-500 text-sm">Error: ${res.message}</div>`);
                        }
                    } catch (e) {
                        console.error('Failed to parse notes response', e);
                    }
                }
            });
        };

        window.renderSidebarNotes = function (notesToRender) {
            const $list = $('#notes-sidebar-list');
            $list.empty();

            if (!notesToRender || notesToRender.length === 0) {
                $list.html(`<div class="p-8 text-center text-muted-foreground text-sm">No recent sessions found.</div>`);
                return;
            }

            notesToRender.forEach(note => {
                const isSelected = note.appointment_uuid === window.currentAppointmentUuid;
                const dateStr = new Date(note.sched_date + ' ' + note.sched_time).toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' });

                const statusConfig = note.status === 'signed'
                    ? { label: 'Signed', color: 'emerald', bg: 'bg-emerald-100 dark:bg-emerald-950/50', text: 'text-emerald-600' }
                    : { label: 'Draft', color: 'amber', bg: 'bg-amber-100 dark:bg-amber-950/50', text: 'text-amber-600' };

                const activeClass = isSelected ? 'bg-primary/5 border-l-4 border-primary' : 'hover:bg-muted/30 border-b border-border/60';
                const titleClass = isSelected ? 'font-black text-foreground' : 'font-bold text-foreground/80 group-hover:text-foreground';

                const html = `
                <div class="note-item p-5 cursor-pointer transition-all group ${activeClass}" data-uuid="${note.appointment_uuid}">
                    <div class="flex justify-between items-start mb-1.5">
                        <span class="text-sm transition-colors tracking-tight ${titleClass}">
                            ${note.patient_firstname} ${note.patient_lastname}
                        </span>
                        <span class="text-[9px] font-black uppercase tracking-widest ${statusConfig.text} ${statusConfig.bg} px-2 py-0.5 rounded shadow-sm opacity-80">
                            ${statusConfig.label}
                        </span>
                    </div>
                    <p class="text-[11px] font-bold text-muted-foreground mb-2 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[14px]">event</span>
                        ${dateStr}
                    </p>
                    <p class="text-xs text-muted-foreground line-clamp-1 opacity-70 group-hover:opacity-90 transition-opacity">
                        ${note.service_name}
                    </p>
                    ${isSelected ? '<div class="absolute inset-y-0 right-0 w-1 bg-primary/10"></div>' : ''}
                </div>
            `;
                $list.append(html);
            });
        };

        // Sidebar search filtering
        $('#notes-search-input').on('input', function () {
            const query = $(this).val().toLowerCase();
            const filtered = (window.currentNotes || []).filter(note => {
                const name = `${note.patient_firstname} ${note.patient_lastname}`.toLowerCase();
                return name.includes(query);
            });
            window.renderSidebarNotes(filtered);
        });

        // Sidebar click handler
        $('#notes-sidebar-list').on('click', '.note-item', function () {
            const uuid = $(this).data('uuid');
            if (uuid) {
                // Update URL without refreshing
                const url = new URL(window.location);
                url.searchParams.set('appointment_uuid', uuid);
                window.history.pushState({}, '', url);

                window.loadNoteEditor(uuid);
            }
        });
    });
</script>