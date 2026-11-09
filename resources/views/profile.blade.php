<x-layout>
    <x-slot:title>Profile</x-slot:title>
    @php
        $user = auth()->user()->load('resident.room');
        $isAdmin = $user->user_type === 'Admin';
        $isManager = $user->user_type === 'Manager';
        $isResident = $user->user_type === 'Resident';
    @endphp
    <header class="page-title"  style="margin-bottom: 0;">PROFILE MANAGEMENT</header>
    <section class="profile-management">
        <div class="card user-modal">
            <h2 class="modal-title">Hello {{ $user->nickname }}!</h2>
                <form action="{{ route('profile.update', $user) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    {{-- PERSONAL INFORMATION --}}
                    <div class="user-top-section">
                        <div class="sidebar">
                            <div class="image-upload" style="align-items: center;">
                                <img id="preview-image" src="{{ $user->profile_picture ? asset($user->profile_picture) : asset('images/user-profile.png') }}">
                                <input type="file" name="profile_picture" id="profile_picture" accept="image/*" hidden>
                                <label for="profile_picture" class="btn-primary">Update Profile</label>
                                <span id="file-name">No file chosen</span><br>
                            </div>
                            @if($user->resident)
                                <p>Resident ID: <br><span>{{ $user->resident->id }}</span></p><br>
                                <p>Room: <br><span>{{ $user->resident->room?->dorm_name ?? 'Unassigned' }} {{ $user->resident->room?->room_number ?? '' }}</span></p>
                            @else
                                <p>User ID: <span>{{ $user->id }}</span></p>
                            @endif
                        </div>
                        <div class="user-details">
                            <div class="fullname">
                                <div class="form-group last_name">
                                    <label for="last_name">Last Name*:</label>
                                    <input type="text" id="last_name" name="last_name" class="form-input" value="{{ $user->last_name }}" @disabled(!$isAdmin && !$isManager)>
                                    @if(!$isAdmin && !$isManager)
                                        <input type="hidden" name="last_name" value="{{ $user->last_name }}">
                                    @endif
                                </div>
                                <div class="form-group first_name">
                                    <label for="first_name">First Name*:</label>
                                    <input type="text" id="first_name" name="first_name" class="form-input" value="{{ $user->first_name }}" @disabled(!$isAdmin && !$isManager)>
                                    @if(!$isAdmin && !$isManager)
                                        <input type="hidden" name="first_name" value="{{ $user->first_name }}">
                                    @endif
                                </div>
                                <div class="form-group middle_name">
                                    <label for="middle_name">Middle Name:</label>
                                    <input type="text" id="middle_name" name="middle_name" class="form-input" value="{{ $user->middle_name }}" @disabled(!$isAdmin && !$isManager)>
                                    @if(!$isAdmin && !$isManager)
                                        <input type="hidden" name="middle_name" value="{{ $user->middle_name }}">
                                    @endif
                                </div>
                            </div>
                            <div class="info">
                                <div class="form-group nickname">
                                    <label for="nickname">Nickname*:</label>
                                    <input type="text" id="nickname" name="nickname" class="form-input" value="{{ $user->nickname }}" >
                                </div>
                                <div class="form-group birthdate">
                                    <label for="birthdate">Birthdate*:</label>
                                    <div class="birthday-picker">
                                        <input type="date" id="birthdate" name="birthdate" class="form-input"
                                            value="{{ $user->birthdate?->format('Y-m-d') }}">
                                        <button type="button" id="birthdayPickerButton"
                                                aria-label="Open birthday calendar" aria-expanded="false">
                                            <span aria-hidden="true">▦</span>
                                        </button>

                                        <div class="birthday-calendar" id="birthdayCalendar" hidden>
                                            <div class="birthday-calendar-header">
                                                <button type="button" id="birthdayPreviousMonth" aria-label="Previous month">‹</button>
                                                <button type="button" id="birthdayMonthButton" aria-expanded="false">Month</button>
                                                <button type="button" id="birthdayYearButton" aria-expanded="false">Year</button>
                                                <button type="button" id="birthdayNextMonth" aria-label="Next month">›</button>
                                            </div>

                                            <div class="birthday-month-picker" id="birthdayMonthPicker" hidden>
                                                <div class="birthday-month-grid" id="birthdayMonthGrid"></div>
                                            </div>

                                            <div class="birthday-year-picker" id="birthdayYearPicker" hidden>
                                                <div class="birthday-year-header">
                                                    <button type="button" id="birthdayPreviousYearRange" aria-label="Previous years">‹</button>
                                                    <span id="birthdayYearRange"></span>
                                                    <button type="button" id="birthdayNextYearRange" aria-label="Next years">›</button>
                                                </div>
                                                <div class="birthday-year-grid" id="birthdayYearGrid"></div>
                                            </div>

                                            <div class="birthday-calendar-grid" id="birthdayCalendarGrid"></div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="form-group gender">
                                        <label for="gender">Gender*:</label>
                                        <select id="gender" name="gender" class="form-cb" @disabled(!$isAdmin && !$isManager)>
                                            <option value="" selected disabled hidden></option>
                                            <option value="Female" {{ $user->gender === 'Female' ? 'selected' : ''}}>Female</option>
                                            <option value="Male" {{ $user->gender === 'Male' ? 'selected' : '' }}>Male</option>
                                        </select>
                                        <input type="hidden" name="gender" value="{{ $user->gender }}">
                                    </div>
                                </div>
                            <div class="contact">
                                <div class="form-group address">
                                    <label for="address">Address:</label>
                                    <input type="text" id="address" name="address" class="form-input" value="{{ $user->address }}">
                                </div>
                                <div class="form-group phone_number">
                                    <label for="phone_number">Phone Number:</label>
                                    <input type="tel" id="phone_number" name="phone_number" class="form-input" value="{{ $user->phone_number }}">
                                </div>
                            </div>
                            <div class="login-details">
                                <div class="form-group email">
                                    <label for="email">Email Address*:</label>
                                    <input type="email" id="email" name="email" class="form-input" value="{{ $user->email }}">
                                </div>
                                <div class="password-group">
                                    <label for="password">Password*:</label>
                                    <div class="password-row">
                                        <input type="password" id="password" name="password" class="form-input" placeholder="Leave blank to keep current password">
                                        <button type="submit" name="reset_password" value="1" class="btn-primary">Reset</button>
                                    </div>
                                </div>
                            </div>
                            <div class="account">
                                <div class="form-group user_type">
                                    <label for="user_type">User Type*:</label>
                                    <select id="user_type" name="user_type" class="form-cb" @disabled(!$isAdmin)>
                                        <option value="Admin" {{ $user->user_type === 'Admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="Manager" {{ $user->user_type === 'Manager' ? 'selected' : '' }}>Manager</option>
                                        <option value="Resident" {{ $user->user_type === 'Resident' ? 'selected' : '' }}>Resident</option>
                                    </select>
                                    @if(!$isAdmin)
                                        <input type="hidden" name="user_type" value="{{ $user->user_type }}">
                                    @endif
                                </div>
                                <div class="form-group user-status">
                                    <label for="user-status">User Status*:</label>
                                    <select id="user-status" name="status" class="form-cb" @disabled(!$isAdmin)>
                                        <option value="Active" {{ $user->status === 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ $user->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @if(!$isAdmin)
                                        <input type="hidden" name="status" value="{{ $user->status }}">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- resident section --}}
                    @if($user->user_type === 'Resident' && $user->resident)
                        <hr style="margin: 0.5rem 0.5rem 1rem 0.5rem;">
                        @php
                            $paymentOptions = match($user->resident->accommodation_type) {
                                'Resident' => ['Full Payment', '4 Payments', '3 Payments', '2 Payments', 'Monthly'],
                                'Transient' => ['Per Day'],
                                default => [],
                            };
                        @endphp
                        <h2 class="modal-title">Resident Information</h2>
                        <p style="text-align: center;">(if there are any changes regarding your information, please contact the Dorm Manager and Dorm Administrator)</p>
                        <br>
                        <div class="resident-type">
                            <div class="form-group accommodation_type">
                                <label for="accommodation_type">Accommodation Type*:</label>
                                <select name="accommodation_type" id="accommodation_type" class="form-cb" @disabled(!$isAdmin && !$isManager)>
                                    <option value="Resident" {{ $user->resident->accommodation_type === 'Resident' ? 'selected' : '' }} @disabled(!$isAdmin && !$isManager)>Resident</option>
                                    <option value="Transient" {{ $user->resident->accommodation_type === 'Transient' ? 'selected' : '' }} @disabled(!$isAdmin && !$isManager)>Transient</option>
                                </select>
                                <input type="hidden" name="accommodation_type" value="{{ $user->resident->accommodation_type }}">
                            </div>
                            <div class="form-group resident_type">
                                <label for="resident_type">Resident Type*:</label>
                                <select name="resident_type" id="resident_type" class="form-cb" @disabled(!$isAdmin && !$isManager)>
                                    <option value="Student" {{ $user->resident->resident_type === 'Student' ? 'selected' : '' }} @disabled(!$isAdmin && !$isManager)>Student</option>
                                    <option value="Employee" {{ $user->resident->resident_type === 'Employee' ? 'selected' : '' }} @disabled(!$isAdmin && !$isManager)>Employee</option>
                                </select>
                                <input type="hidden" name="resident_type" value="{{ $user->resident->resident_type }}">
                            </div>
                        </div>
                        <div class="lodging-type">
                            <div class="form-group payment_schedule">
                                <label for="payment_schedule">Payment Schedule*:</label>
                                <select name="payment_schedule" id="payment_schedule" class="form-cb" @disabled(!$isAdmin && !$isManager)>
                                    @foreach ($paymentOptions as $paymentOption)
                                        <option value="{{ $paymentOption }}" @selected($user->resident->payment_schedule == $paymentOption) @disabled(!$isAdmin && !$isManager)>{{ $paymentOption }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="payment_schedule" value="{{ $user->resident->payment_schedule }}">
                            </div>
                            <div class="form-group room_type">
                                <label for="room_type">Room Type*:</label>
                                <select name="room_type" id="room_type" class="form-cb" @disabled(!$isAdmin && !$isManager)>
                                    <option value="8 persons" {{ $user->resident->room_type === '8 persons' ? 'selected' : '' }} @disabled(!$isAdmin && !$isManager)>8 persons</option>
                                    <option value="4 persons" {{ $user->resident->room_type === '4 persons' ? 'selected' : '' }} @disabled(!$isAdmin && !$isManager)>4 persons</option>
                                    <option value="3 persons" {{ $user->resident->room_type === '3 persons' ? 'selected' : '' }} @disabled(!$isAdmin && !$isManager)>3 persons</option>
                                    <option value="2 persons" {{ $user->resident->room_type === '2 persons' ? 'selected' : '' }} @disabled(!$isAdmin && !$isManager)>2 persons</option>
                                    <option value="1 person" {{ $user->resident->room_type === '1 person' ? 'selected' : '' }} @disabled(!$isAdmin && !$isManager)>1 person</option>
                                </select>
                                <input type="hidden" name="room_type" value="{{ $user->resident->room_type }}">
                            </div>
                        </div>
                        <div class="checkin-checkout">
                            <div class="form-group check_in_date">
                                <label for="check_in_date">Check In*:</label>
                                <input type="date" id="check_in_date" name="check_in_date" class="form-input" value="{{ $user->resident->check_in_date?->format('Y-m-d') }}" @disabled(!$isAdmin && !$isManager)>
                            </div>
                                <input type="hidden" name="check_in_date" value="{{ $user->resident->check_in_date }}">
                            <div class="form-group check_out_date">
                                <label for="check_out_date">Check Out*:</label>
                                <input type="date" id="check_out_date" name="check_out_date" class="form-input" value="{{ $user->resident->check_out_date?->format('Y-m-d') }}" @disabled(!$isAdmin && !$isManager)>
                                <input type="hidden" name="check_out_date" value="{{ $user->resident->check_out_date }}"></div>
                        </div>
                    @endif
                    <div class="form-buttons">
                        <button type="submit" class="btn-primary"
                                onclick="if (document.getElementById('user_type').value !== '{{ $user->user_type }}' || 
                                                document.getElementById('user-status').value !== '{{ $user->status }}') {
                                                    return confirm('Are you sure? Changing your user type or account status may affect your access.');
                                        } return true;">Save Changes</button>
                        <button type="reset" class="btn-primary" >Restore</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- confirmation --}}
        @if(session('success'))
            <div class="modal">
                <div class="card user-modal receipt-modal">
                    <h2 class="modal-title">{{ session('receipt.action') }}</h2>
                    <p style="text-align:center;">{{ session('success') }}</p>
                    <div class="form-buttons">
                        <button class="btn-primary" onclick="this.closest('.modal').remove()">OK</button>
                    </div>
                </div>
            </div>
        @endif

        {{-- error receipt --}}
        @if($errors->any())
            <div class="modal">
                <div class="card user-modal receipt-modal">
                    <h2 class="modal-title">ERROR RECEIPT</h2>
                    <div class="receipt-box">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    <div class="form-buttons">
                        <button
                            type="button"
                            class="btn-primary"
                            onclick="this.closest('.modal').remove()">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </section>

    <script>
        (() => {
            const input = document.getElementById('birthdate');
            const openButton = document.getElementById('birthdayPickerButton');
            const calendar = document.getElementById('birthdayCalendar');
            const monthButton = document.getElementById('birthdayMonthButton');
            const monthPicker = document.getElementById('birthdayMonthPicker');
            const monthGrid = document.getElementById('birthdayMonthGrid');
            const yearButton = document.getElementById('birthdayYearButton');
            const yearPicker = document.getElementById('birthdayYearPicker');
            const yearGrid = document.getElementById('birthdayYearGrid');
            const yearRange = document.getElementById('birthdayYearRange');
            const previousYearRangeButton = document.getElementById('birthdayPreviousYearRange');
            const nextYearRangeButton = document.getElementById('birthdayNextYearRange');
            const grid = document.getElementById('birthdayCalendarGrid');
            const previousButton = document.getElementById('birthdayPreviousMonth');
            const nextButton = document.getElementById('birthdayNextMonth');

            if (!input || !openButton || !calendar) {
                return;
            }

            const today = new Date();
            let displayedMonth = input.value
                ? new Date(`${input.value}T00:00:00`)
                : new Date();

            const monthNames = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            function renderYearPicker() {
                const currentYear = today.getFullYear();
                const selectedYear = displayedMonth.getFullYear();

                const firstYearInRange = Math.max(
                    1900,
                    Math.min(selectedYear - 5, currentYear - 11)
                );

                const lastYearInRange = Math.min(firstYearInRange + 11, currentYear);

                yearRange.textContent = `${firstYearInRange}–${lastYearInRange}`;
                yearGrid.replaceChildren();

                for (let year = firstYearInRange; year <= lastYearInRange; year++) {
                    const button = document.createElement('button');

                    button.type = 'button';
                    button.textContent = year;
                    button.setAttribute('aria-selected', year === selectedYear);

                    button.addEventListener('click', () => {
                        displayedMonth = new Date(year, displayedMonth.getMonth(), 1);
                        yearPicker.hidden = true;
                        calendar.classList.remove('year-selection');
                        grid.hidden = false;
                        yearButton.setAttribute('aria-expanded', 'false');
                        renderCalendar();
                    });
                    yearGrid.append(button);
                }

                previousYearRangeButton.disabled = firstYearInRange <= 1900;
                nextYearRangeButton.disabled = lastYearInRange >= currentYear;
            }

            function renderMonthPicker() {
                monthGrid.replaceChildren();

                monthNames.forEach((month, index) => {
                    const button = document.createElement('button');

                    button.type = 'button';
                    button.textContent = month;
                    button.setAttribute('aria-selected', index === displayedMonth.getMonth());
                    button.disabled =
                        displayedMonth.getFullYear() === today.getFullYear() &&
                        index > today.getMonth();

                    button.addEventListener('click', () => {
                        displayedMonth.setMonth(index);
                        monthPicker.hidden = true;
                        calendar.classList.remove('month-selection');
                        grid.hidden = false;
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
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                monthButton.textContent = monthNames[month];
                yearButton.textContent = year;
                grid.replaceChildren();

                ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'].forEach(day => {
                    const heading = document.createElement('span');
                    heading.textContent = day;
                    grid.append(heading);
                });

                for (let blank = 0; blank < firstWeekday; blank++) {
                    grid.append(document.createElement('span'));
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
                    button.setAttribute('aria-label', date.toLocaleDateString());
                    button.setAttribute('aria-selected', input.value === value);
                    button.disabled = date > today;

                    button.addEventListener('click', () => {
                        input.value = value;
                        input.dispatchEvent(new Event('input', { bubbles: true }));
                        input.dispatchEvent(new Event('change', { bubbles: true }));
                        calendar.hidden = true;
                        openButton.setAttribute('aria-expanded', 'false');
                    });

                    grid.append(button);
                }

                previousButton.disabled =
                    year === 1900 && month === 0;
                nextButton.disabled =
                    year === today.getFullYear() && month === today.getMonth();
            }

            openButton.addEventListener('click', () => {
                displayedMonth = input.value
                    ? new Date(`${input.value}T00:00:00`)
                    : new Date();

                calendar.hidden = !calendar.hidden;
                openButton.setAttribute('aria-expanded', String(!calendar.hidden));

                if (!calendar.hidden) {
                    renderCalendar();
                }
            });

            monthButton.addEventListener('click', () => {
                calendar.classList.add('month-selection');
                calendar.classList.remove('year-selection');
                monthPicker.hidden = false;
                yearPicker.hidden = true;
                grid.hidden = true;
                monthButton.setAttribute('aria-expanded', 'true');
                yearButton.setAttribute('aria-expanded', 'false');
                renderMonthPicker();
            });

            yearButton.addEventListener('click', () => {
                calendar.classList.remove('month-selection');
                monthPicker.hidden = true;
                monthButton.setAttribute('aria-expanded', 'false');
                calendar.classList.add('year-selection');
                yearPicker.hidden = false;
                grid.hidden = true;
                yearButton.setAttribute('aria-expanded', 'true');
                renderYearPicker();
            });

            previousYearRangeButton.addEventListener('click', () => {
                const selectedYear = displayedMonth.getFullYear();
                displayedMonth.setFullYear(Math.max(1900, selectedYear - 12));
                renderYearPicker();
            });

            nextYearRangeButton.addEventListener('click', () => {
                const selectedYear = displayedMonth.getFullYear();
                displayedMonth.setFullYear(
                    Math.min(today.getFullYear(), selectedYear + 12)
                );
                renderYearPicker();
            });

            previousButton.addEventListener('click', () => {
                displayedMonth.setMonth(displayedMonth.getMonth() - 1);
                renderCalendar();
            });

            nextButton.addEventListener('click', () => {
                displayedMonth.setMonth(displayedMonth.getMonth() + 1);
                renderCalendar();
            });
        })();
    </script>
</x-layout>