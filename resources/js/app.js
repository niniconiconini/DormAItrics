// preview image for room and user
const fileInput = document.querySelector('#profile_picture, #room_image');
const previewImage = document.getElementById('preview-image');
const previewText = document.getElementById('preview-text');
const fileName = document.getElementById('file-name');

if (fileInput && previewImage) {
    const originalImage = previewImage.src;
    const originalFileText = fileName ? fileName.textContent : 'No file chosen';

    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        previewImage.src = URL.createObjectURL(file);

        // show preview image
        previewImage.style.display = 'block';

        // hide placeholder text
        if (previewText) {
            previewText.style.display = 'none';
        }

        // update filename
        if (fileName) {
            fileName.textContent = file.name;
        }
    });

    const form = document.querySelector('.user-modal form') || document.querySelector('.room-modal form');

    if (form) {
        form.addEventListener('reset', () => {
            setTimeout(() => {
                previewImage.src = originalImage;
                if (fileName) {
                    fileName.textContent = originalFileText;
                }

                // if add-room preview started empty
                if (!originalImage) {
                    previewImage.style.display = 'none';

                    if (previewText) { 
                        previewText.style.display = 'block'; 
                    }
                }
            }, 0);
        });
    }
}

// user management character validation
document.querySelectorAll('#last_name, #first_name, #middle_name, #nickname').forEach(input => {
    input.addEventListener('input', function () {
        const currentInput = this;
        setTimeout(() => {
            currentInput.value = currentInput.value.replace(/[^\p{L}\s.,-]/gu, '')
        }, 200)
    });
});

// user management edit modal when turning inactive user to active
const statusSelect = document.getElementById('user-status');
const residentFields = [
    'accommodation_type',
    'resident_type',
    'payment_schedule',
    'room_type',
    'check_in_date',
    'check_out_date'
];

if (statusSelect) {
    statusSelect.addEventListener('change', function () {
        const disabledFields = document.querySelectorAll('#edit-user-form input, #edit-user-form select, #edit-user-form textarea, #edit-user-form button');
        if (this.value === 'Active') {
            disabledFields.forEach(field => {
                if (field.id !== 'user-status') {
                    field.disabled = false;
                }
            });
            residentFields.forEach(id => {
                const field = document.getElementById(id);
                if (!field) return;
                field.value = '';
            });
            document.querySelectorAll('.inactive-btn').forEach(element => {
                element.classList.remove('inactive-btn');
            });
            document.querySelector('.inactive-banner')?.remove();
        }
    });
}



// change enroll face to enrolling text
const enrollButton = document.getElementById('enroll-button')
if (enrollButton) {
    enrollButton.addEventListener('click', function() {
        this.textContent = 'Enrolling..';
        this.style.pointerEvents = 'disabled';
    });
}

// change scan me to scanning text
const scanButton = document.getElementById('scan-button')
if (scanButton) {
    scanButton.addEventListener('click', function() {
        this.textContent = 'Scanning..';
        this.style.pointerEvents = 'disabled';
    });
}

// calendar picker
(() => {
    const monthNames = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];

    document.querySelectorAll('[data-birthday-picker]').forEach(picker => {
        const find = role => picker.querySelector(`[data-role="${role}"]`);
        const input = find('input');
        const openButton = find('toggle');
        const calendar = find('calendar');
        const monthButton = find('month-button');
        const monthPicker = find('month-picker');
        const monthGrid = find('month-grid');
        const yearButton = find('year-button');
        const yearPicker = find('year-picker');
        const yearGrid = find('year-grid');
        const yearRange = find('year-range');
        const previousYearRangeButton = find('previous-year-range');
        const nextYearRangeButton = find('next-year-range');
        const dayGrid = find('day-grid');
        const previousMonthButton = find('previous-month');
        const nextMonthButton = find('next-month');

        if (!input || !openButton || !calendar) {
            return;
        }

        const today = new Date();
        today.setHours(0, 0, 0, 0);

        let displayedMonth = input.value
            ? new Date(`${input.value}T00:00:00`)
            : new Date();

        displayedMonth.setDate(1);

        function renderYearPicker() {
            const currentYear = today.getFullYear();
            const selectedYear = displayedMonth.getFullYear();
            const firstYear = Math.max(
                1900,
                Math.min(selectedYear - 5, currentYear - 11)
            );
            const lastYear = Math.min(firstYear + 11, currentYear);
            yearRange.textContent = `${firstYear}–${lastYear}`;
            yearGrid.replaceChildren();

            for (let year = firstYear; year <= lastYear; year++) {
                const button = document.createElement('button');
                button.type = 'button';
                button.textContent = year;
                button.setAttribute(
                    'aria-selected',
                    year === selectedYear
                );

                button.addEventListener('click', () => {
                    displayedMonth = new Date(
                        year,
                        displayedMonth.getMonth(),
                        1
                    );

                    yearPicker.hidden = true;
                    calendar.classList.remove('year-selection');
                    dayGrid.hidden = false;
                    yearButton.setAttribute('aria-expanded', 'false');

                    renderCalendar();
                });

                yearGrid.append(button);
            }

            previousYearRangeButton.disabled = firstYear <= 1900;
            nextYearRangeButton.disabled = lastYear >= currentYear;
        }

        function renderMonthPicker() {
            monthGrid.replaceChildren();
            monthNames.forEach((month, index) => {
                const button = document.createElement('button');
                button.type = 'button';
                button.textContent = month;
                button.setAttribute(
                    'aria-selected',
                    index === displayedMonth.getMonth()
                );

                button.disabled =
                    displayedMonth.getFullYear() === today.getFullYear() &&
                    index > today.getMonth();

                button.addEventListener('click', () => {
                    displayedMonth.setMonth(index);

                    monthPicker.hidden = true;
                    calendar.classList.remove('month-selection');
                    dayGrid.hidden = false;
                    monthButton.setAttribute('aria-expanded', 'false');

                    renderCalendar();
                });

                monthGrid.append(button);
            });
        }

        function renderCalendar() {
            const year = displayedMonth.getFullYear();
            const month = displayedMonth.getMonth();
            const firstWeekday = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate()
            monthButton.textContent = monthNames[month];
            yearButton.textContent = year;
            dayGrid.replaceChildren();
            ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'].forEach(day => {
                const heading = document.createElement('span');
                heading.textContent = day;

                dayGrid.append(heading);
            });

            for (let blank = 0; blank < firstWeekday; blank++) {
                dayGrid.append(document.createElement('span'));
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const date = new Date(year, month, day);
                const button = document.createElement('button');
                const value = [
                    year,
                    String(month + 1).padStart(2, '0'),
                    String(day).padStart(2, '0')
                ].join('-');
                button.type = 'button';
                button.textContent = day;
                button.setAttribute(
                    'aria-label',
                    date.toLocaleDateString()
                );
                button.setAttribute(
                    'aria-selected',
                    input.value === value
                );
                button.disabled = date > today;
                button.addEventListener('click', () => {
                    input.value = value;
                    input.dispatchEvent(
                        new Event('input', { bubbles: true })
                    );
                    input.dispatchEvent(
                        new Event('change', { bubbles: true })
                    );
                    calendar.hidden = true;
                    openButton.setAttribute(
                        'aria-expanded',
                        'false'
                    );
                });

                dayGrid.append(button);
            }

            previousMonthButton.disabled =
                year === 1900 && month === 0;
            nextMonthButton.disabled =
                year === today.getFullYear() &&
                month === today.getMonth();
        }

        openButton.addEventListener('click', () => {
            displayedMonth = input.value
                ? new Date(`${input.value}T00:00:00`)
                : new Date();
            displayedMonth.setDate(1);
            calendar.hidden = !calendar.hidden;
            openButton.setAttribute(
                'aria-expanded',
                String(!calendar.hidden)
            );

            if (!calendar.hidden) {
                calendar.classList.remove(
                    'year-selection',
                    'month-selection'
                );

                yearPicker.hidden = true;
                monthPicker.hidden = true;
                dayGrid.hidden = false;
                monthButton.setAttribute(
                    'aria-expanded',
                    'false'
                );

                yearButton.setAttribute(
                    'aria-expanded',
                    'false'
                );

                renderCalendar();
            }
        });

        monthButton.addEventListener('click', () => {
            calendar.classList.add('month-selection');
            calendar.classList.remove('year-selection');
            monthPicker.hidden = false;
            yearPicker.hidden = true;
            dayGrid.hidden = true;
            monthButton.setAttribute(
                'aria-expanded',
                'true'
            );
            yearButton.setAttribute(
                'aria-expanded',
                'false'
            );
            renderMonthPicker();
        });

        yearButton.addEventListener('click', () => {
            calendar.classList.remove('month-selection');
            monthPicker.hidden = true;
            monthButton.setAttribute(
                'aria-expanded',
                'false'
            );
            calendar.classList.add('year-selection');
            yearPicker.hidden = false;
            dayGrid.hidden = true;
            yearButton.setAttribute(
                'aria-expanded',
                'true'
            );
            renderYearPicker();
        });

        previousYearRangeButton.addEventListener('click', () => {
            displayedMonth.setFullYear(
                Math.max(
                    1900,
                    displayedMonth.getFullYear() - 12
                )
            );
            renderYearPicker();
        });

        nextYearRangeButton.addEventListener('click', () => {
            displayedMonth.setFullYear(
                Math.min(
                    today.getFullYear(),
                    displayedMonth.getFullYear() + 12
                )
            );
            renderYearPicker();
        });

        previousMonthButton.addEventListener('click', () => {
            displayedMonth.setMonth(
                displayedMonth.getMonth() - 1
            );
            renderCalendar();
        });

        nextMonthButton.addEventListener('click', () => {
            displayedMonth.setMonth(
                displayedMonth.getMonth() + 1
            );
            renderCalendar();
        });
    });
})();