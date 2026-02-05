<!-- Reminder Modal -->
<div class="ui tiny modal" id="reminderModal">
    <div class="header">Add Time Entry</div>
    <div class="content">
        <form class="ui form" id="reminderForm">
            <div class="field">
                <label for="employee">Employee</label>
                <div class="ui fluid floating dropdown">
                    <input type="hidden" name="employee" />
                    <div class="default text">Select employee</div>
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        <div class="ui icon search input">
                            <i class="search icon"></i>
                            <input type="text" name="employee_search" placeholder="Search employee...">
                        </div>
                        <div class="divider"></div>
                        <div class="header">
                            <i class="tags icon"></i>
                            Tag Label
                        </div>
                        <div class="scrolling menu">
                            <div class="item" data-value="1">
                                <img class="ui avatar image rounded-circle"
                                    src="<?= asset('img/avatars/jenny.jpg'); ?>" />
                                John Smith
                            </div>
                            <div class="item" data-value="2">
                                <img class="ui avatar image rounded-circle"
                                    src="<?= asset('img/avatars/elliot.jpg'); ?>" />
                                Sarah Johnson
                            </div>
                            <div class="item" data-value="3">
                                <img class="ui avatar image rounded-circle"
                                    src="<?= asset('img/avatars/stevie.jpg'); ?>" />
                                Michael Williams
                            </div>
                            <div class="item" data-value="4">
                                <img class="ui avatar image rounded-circle"
                                    src="<?= asset('img/avatars/veronika.jpg'); ?>" />
                                Emily Brown
                            </div>
                            <div class="item" data-value="1">
                                <img class="ui avatar image rounded-circle"
                                    src="<?= asset('img/avatars/jenny.jpg'); ?>" />
                                John Smith
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="fields">
                <div class="eight wide field">
                    <label for="date">Date</label>
                    <input type="date" name="date" placeholder="Select Date" />
                </div>
                <div class="four wide field">
                    <label for="timeIn">Time In</label>
                    <input type="time" name="time_in" id="timeIn" />
                </div>
                <div class="four wide field">
                    <label for="timeOut">Time Out</label>
                    <input type="time" name="time_out" id="timeOut" />
                </div>
            </div>
            <div class="field">
                <label for="memo">Memo</label>
                <textarea rows="4" name="memo" placeholder="What this time entry is for..."></textarea>
            </div>
            <div class="actions">
                <button class="ui cancel button" type="button">Cancel</button>
                <button class="ui positive button" type="submit">Save Entry</button>
            </div>
        </form>
    </div>
</div>