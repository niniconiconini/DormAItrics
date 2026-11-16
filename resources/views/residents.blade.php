<x-layout>
    <x-slot:title>Dormer Management</x-slot:title>    
    <header class="page-title">DORMITORY RESIDENTS</header>
    <section class="residents">
        <section class="dorm-section">
            <div class="section-dormname">
                <h2>Dormitory Administrators</h2>
                @if (auth()->user()->user_type === 'Admin')
                    <a href="{{ route('users.index', ['modal' => 'add-admin']) }}" class="btn-primary">+ Add Admin</a>
                @endif
            </div>
            <hr>
            <section class="flex-view">
                @forelse ($admins as $admin)
                    @if (auth()->user()->user_type === 'Manager' && $admin->id !== auth()->id())
                        <div class="card dorm-card disabled-card {{ $admin->status === 'Inactive' ? 'inactive-card' : '' }}">
                            <div class="room-image resident-card"><img src="{{ asset($admin->profile_picture) }}"></div>
                            <div class="room-number"><p>{{ $admin->nickname }}</p></div>
                        </div>
                    @elseif (auth()->user()->user_type === 'Manager' && auth()->id() === $admin->id) {{-- ms aneen edit self --}}
                        <a href="{{ route('profile', ['return' => route('users.index', ['view' => request('view')] )] ) }}">
                            <div class="card dorm-card {{ $admin->status === 'Inactive' ? 'inactive-card' : '' }}">
                                <div class="room-image resident-card"><img src="{{ asset($admin->profile_picture) }}"></div>
                                <div class="room-number"><p>{{ $admin->nickname }}</p></div>
                            </div>
                        </a>
                    @elseif (auth()->user()->user_type === 'Admin' && auth()->id() === $admin->id) {{-- sister nicole edit self --}}
                        <a href="{{ route('profile', ['return' => route('users.index', ['view' => request('view')] )] ) }}">
                            <div class="card dorm-card {{ $admin->status === 'Inactive' ? 'inactive-card' : '' }}">
                                <div class="room-image resident-card"><img src="{{ asset($admin->profile_picture) }}"></div>
                                <div class="room-number"><p>{{ $admin->nickname }}</p></div>
                            </div>
                        </a>
                    @else
                        <a href="{{ route('users.index', ['modal' => 'edit-user', 'user' => $admin->id, 'view' => request('view')]) }}">
                            <div class="card dorm-card {{ $admin->status === 'Inactive' ? 'inactive-card' : '' }}">
                                <div class="room-image resident-card"><img src="{{ asset($admin->profile_picture) }}"></div>
                                <div class="room-number"><p>{{ $admin->nickname }}</p></div>
                            </div>
                        </a>
                    @endif
                @empty
                    <p>No administrators found.</p>
                @endforelse
            </section>
        </section>
        <section class="dorm-section">
            <div class="residents-header">
                <div class="residents-title">
                    <h2 class="section-title">
                        @switch(request('view', 'resident'))
                            @case('transient')
                                Transients
                                @break
                            @case('applicant')
                                Applicants
                                @break
                            @case('inactive')
                                Inactive Accounts
                                @break
                            @case('all')
                                All Accounts
                                @break
                            @default
                                Residents
                        @endswitch
                        <div class="logs-count" style="margin-top: 5px; width: 100%;">{{ $residents->count() }} Users</div>
                    </h2>
                    @if(request('view') == 'resident' || request('view') == 'transient')
                        <a href="{{ route('users.index', ['modal' => 'add-resident', 'view' => request('view')]) }}" class="btn-primary">+ Add {{ request('view') === 'transient' ? 'Transient' : 'Resident' }}</a>
                    @endif
                </div>
            </div>
            <hr>
            <div class="section-dormname" style="margin-top: 0; margin-bottom: 1rem;">
                <select id="user-view" class="user-view-select" onchange="window.location=this.value">
                    <option value="{{ route('users.index', ['view' => 'all']) }}" @selected(request('view') === 'all')>All Accounts</option>
                    <option value="{{ route('users.index', ['view' => 'resident']) }}" @selected(request('view', 'resident') === 'resident')>Residents</option>
                    <option value="{{ route('users.index', ['view' => 'transient']) }}" @selected(request('view') === 'transient')>Transients</option>
                    <option value="{{ route('users.index', ['view' => 'applicant']) }}" @selected(request('view') === 'applicant')>Applicants</option>
                    <option value="{{ route('users.index', ['view' => 'inactive']) }}" @selected(request('view') === 'inactive')>Inactive</option>
                </select>
                <h2> | </h2>
                <a href="{{ route('users.index', ['view' => request('view')]) }}" class="btn-primary {{ !request('resident_type') ? 'active' : '' }}">All</a>
                <a href="{{ route('users.index', ['view' => request('view'), 'resident_type' => 'Student']) }}" class="btn-primary  {{ request('resident_type') === 'Student' ? 'active' : '' }}">Students</a>
                <a href="{{ route('users.index', ['view' => request('view'), 'resident_type' => 'Employee']) }}" class="btn-primary  {{ request('resident_type') === 'Employee' ? 'active' : '' }}">Employees</a>
                @if (request('view') === 'all')
                    <h2> | </h2>
                    <form method="GET" style="display:inline;">
                        <input type="hidden" name="view" value="{{ request('view', 'resident') }}">
                        <input type="hidden" name="resident_type" value="{{ request('resident_type') }}">
                        <div class="password-row">
                            <input type="text" name="search" class="form-input" value="{{ request('search') }}" placeholder="Search name..."> <button class="btn-primary">🔍︎</button>
                        </div>
                    </form>
                @endif
            </div>
            @if (request('view') === 'all')
                <div class="card">
                    <table class="logs-table">
                        <thead>
                            <tr>
                                <th>Resident ID</th>
                                <th>Name</th>
                                <th>Resident Type</th>
                                <th>Accommodation</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($residents as $resident)
                                <tr style="cursor:pointer" onclick="window.location='{{ route('users.index', ['modal' => 'edit-user', 'user' => $resident->user_id, 'view' => request('view') ]) }}'">
                                    <td><strong>{{ $resident->id }}</strong></td>
                                    <td><div class="resident-name"><strong>{{ $resident->user->last_name }}, {{ $resident->user->first_name }} {{ $resident->user->middle_name }}</strong></div></td>
                                    <td>{{ $resident->resident_type }}</td>
                                    <td>
                                        @if($resident->is_applicant)
                                            <span class="status-badge pending">
                                                Applicant
                                            </span>
                                        @elseif($resident->accommodation_type === 'Resident')
                                            <span class="status-badge approved">
                                                Resident
                                            </span>
                                        @else
                                            <span class="status-badge outside">
                                                Transient
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($resident->user->status === 'Active')
                                            <span class="status-badge approved">
                                                Active
                                            </span>
                                        @else
                                            <span class="status-badge no-slip">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty-state">
                                        <div class="empty-icon">👤</div>
                                        <strong>No Users Found</strong>
                                        <p>User records will appear here.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @if ($residents->hasPages())
                        @php
                            $current = $residents->currentPage();
                            $last = $residents->lastPage();
                            if ($last <= 7) {
                                $pages = range(1, $last);
                            } elseif ($current <= 4) {
                                $pages = [...range(1, 5), '...', $last];
                            } elseif ($current >= $last - 3) {
                                $pages = [1, '...', ...range($last - 4, $last)];
                            } else {
                                $pages = [1, '...', $current - 1, $current, $current + 1, '...', $last];
                            }
                        @endphp
                        <nav class="pager" aria-label="Pagination" data-last="{{ $last }}" data-url="{{ $residents->url(1) }}" data-page-name="{{ $residents->getPageName() }}">
                            @if ($logs->onFirstPage())
                                <span class="disabled">◀&#xFE0E;</span>
                            @else
                                <a href="{{ $logs->previousPageUrl() }}">◀&#xFE0E;</a>
                            @endif
                            @foreach ($pages as $page)
                                @if ($page === '...')
                                    <button type="button" class="dots">&hellip;</button>
                                @elseif ($page == $current)
                                    <span class="active">{{ $page }}</span>
                                @else
                                    <a href="{{ $logs->url($page) }}">{{ $page }}</a>
                                @endif
                            @endforeach
                            @if ($logs->hasMorePages())
                                <a href="{{ $logs->nextPageUrl() }}">▶&#xFE0E;</a>
                            @else
                                <span class="disabled">▶&#xFE0E;</span>
                            @endif
                        </nav>
                    @endif
                </div>
            @else
                <section class="flex-view">
                    @forelse ($residents as $resident)
                        <div class="card dorm-card">
                            <a href="{{ route('users.index', ['modal' => 'edit-user', 'user' => $resident->user->id, 'view' => request('view')]) }}" style="color: inherit">
                                <div class="dorm-card">
                                    <div class="room-image resident-card"><img src="{{ asset($resident->user->profile_picture) }}"></div>
                                    <div class="room-number"><p>{{ $resident->user->userName() }}</p></div>
                                    <div class="room-info"><p>Room: {{ $resident->room?->room_number ?? 'Unassigned' }}</p></div>
                                    <div class="room-info"><p>Dorm: {{ $resident->room?->dorm_name ?? 'Unassigned' }}</p></div>
                                    <div class="room-info"><p>Resident Type: {{ $resident->resident_type }}</p></div>
                                </div>
                            </a>
                            @if ($resident->is_applicant)
                                <form action="{{ route('applicants.approve', $resident) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn-primary">Approve</button>
                                </form>
                            @endif 
                        </div>
                    @empty
                        <p>No User found.</p>
                    @endforelse
                </section>
            @endif
        </section>

        {{-- =============================== ADD ADMIN USER MODAL =============================== --}}
        @if (request('modal') == 'add-admin')
            <div class="modal">
                <div class="card user-modal">
                    <h2 class="modal-title">Add Admin</h2>
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- PERSONAL INFORMATION --}}
                        <div class="user-top-section">
                            <div class="sidebar">
                                <div class="image-upload" style="align-items: center;">
                                    <img id="preview-image" src="{{ $admin->profile_picture ? asset($admin->profile_picture) : asset('images/users/user-profile.png') }}">
                                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*" hidden>
                                    <label for="profile_picture" class="btn-primary">Choose Profile Picture</label>
                                    <span id="file-name">No file chosen</span><br>
                                </div>
                            </div>
                            <div class="user-details">
                                <div class="fullname">
                                    <div class="form-group last_name">
                                        <label for="last_name">Last Name*:</label>
                                        <input type="text" id="last_name" name="last_name" class="form-input" value="{{ old('last_name') }}">
                                    </div>
                                    <div class="form-group first_name">
                                        <label for="first_name">First Name*:</label>
                                        <input type="text" id="first_name" name="first_name" class="form-input" value="{{ old('first_name') }}">
                                    </div>
                                    <div class="form-group middle_name">
                                        <label for="middle_name">Middle Name:</label>
                                        <input type="text" id="middle_name" name="middle_name" class="form-input" value="{{ old('middle_name') }}">
                                    </div>
                                </div>
                                <div class="info">
                                    <div class="form-group nickname">
                                        <label for="nickname">Nickname*:</label>
                                        <input type="text" id="nickname" name="nickname" class="form-input" value="{{ old('nickname') }}">
                                    </div>
                                    <div class="form-group birthdate">
                                        <label for="add-admin-birthdate">Birthdate*:</label>
                                        <div class="birthday-picker" data-birthday-picker>
                                            <input type="date" id="add-admin-birthdate" name="birthdate" class="form-input" value="{{ old('birthdate') }}" data-role="input">
                                            <button type="button" aria-label="Open birthday calendar" aria-expanded="false" data-role="toggle"><span aria-hidden="true">▦</span></button>
                                            <div class="birthday-calendar" data-role="calendar" hidden>
                                                <div class="birthday-calendar-header">
                                                    <button type="button" aria-label="Previous month" data-role="previous-month">‹</button>
                                                    <button type="button" class="birthday-month-button" aria-expanded="false" data-role="month-button">Month</button>
                                                    <button type="button" class="birthday-year-button" aria-expanded="false" data-role="year-button">Year</button>
                                                    <button type="button" aria-label="Next month" data-role="next-month">›</button>
                                                </div>
                                                <div class="birthday-month-picker" data-role="month-picker" hidden>
                                                    <div class="birthday-month-grid" data-role="month-grid"></div>
                                                </div>
                                                <div class="birthday-year-picker" data-role="year-picker" hidden>
                                                    <div class="birthday-year-header">
                                                        <button type="button" aria-label="Previous years" data-role="previous-year-range">‹</button>
                                                        <span data-role="year-range"></span>
                                                        <button type="button" aria-label="Next years" data-role="next-year-range">›</button>
                                                    </div>
                                                    <div class="birthday-year-grid" data-role="year-grid"></div>
                                                </div>
                                                <div class="birthday-calendar-grid" data-role="day-grid"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group gender">
                                        <label for="gender">Gender*:</label>
                                        <select id="gender" name="gender" class="form-cb">
                                            <option value="" selected disabled hidden></option>
                                            <option value="Female" {{ old('gender') === 'Female' ? 'selected' : ''}}>Female</option>
                                            <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="contact">
                                    <div class="form-group address">
                                        <label for="address">Address:</label>
                                        <input type="text" id="address" name="address" class="form-input" value="{{ old('address') }}">
                                    </div>
                                    <div class="form-group phone_number">
                                        <label for="phone_number">Phone Number:</label>
                                        <input type="tel" id="phone_number" name="phone_number" class="form-input" value="{{ old('phone_number') }}">
                                    </div>
                                </div>
                                <div class="login-details">
                                    <div class="form-group email">
                                        <label for="email">Email Address*:</label>
                                        <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}">
                                    </div>
                                    <div class="password-group">
                                        <label for="password">Password*:</label>
                                        <div class="password-row">
                                            <input type="password" id="password" name="password" class="form-input" placeholder="Leave blank to set default password (spum123)">
                                        </div>
                                    </div>
                                </div>
                                <div class="account">
                                    <div class="form-group user_type">
                                        <label for="user_type">User Type*:</label>
                                        <select id="user_type" name="user_type" class="form-cb">
                                            <option value="" selected disabled hidden>Select User Type</option>
                                            <option value="Admin" {{ old('user_type') === 'Admin' ? 'selected' : ''}}>Admin</option>
                                            <option value="Manager" {{ old('user_type') === 'Manager' ? 'selected' : '' }}>Manager</option>
                                            <option value="Guard" {{ old('user_type') === 'Guard' ? 'selected' : '' }}>Guard</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-buttons">
                            <button type="submit" class="btn-primary">Create User</button>
                            <button type="reset" class="btn-primary">Clear</button>
                            <a href="{{ route('users.index', ['view' => request('view')]) }}" class="btn-primary">Close</a>
                        </div>
                    </form>
                </div>
            </div>
        @endif
        
        {{-- =============================== ADD RESIDENT/TRANSIENT USER MODAL =============================== --}}
        @if (request('modal') == 'add-resident')
            <div class="modal">
                <div class="card user-modal">
                    <h2 class="modal-title">Add {{ request('view') === 'transient' ? 'Transient' : 'Resident' }}</h2>
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- PERSONAL INFORMATION --}}
                        <div class="user-top-section">
                            <div class="sidebar">
                                <div class="image-upload" style="align-items: center;">
                                <img id="preview-image" src="{{ old('profile_picture') ? asset(old('profile_picture')) : asset('images/users/user-profile.png') }}">
                                <input type="file" name="profile_picture" id="profile_picture" accept="image/*" hidden>
                                <label for="profile_picture" class="btn-primary">Choose File</label>
                                <span id="file-name">No file chosen</span><br>
                            </div>
                            </div>
                            <div class="user-details">
                                <div class="fullname">
                                    <div class="form-group last_name">
                                        <label for="last_name">Last Name*:</label>
                                        <input type="text" id="last_name" name="last_name" class="form-input" value="{{ old('last_name') }}">
                                    </div>
                                    <div class="form-group first_name">
                                        <label for="first_name">First Name*:</label>
                                        <input type="text" id="first_name" name="first_name" class="form-input" value="{{ old('first_name') }}">
                                    </div>
                                    <div class="form-group middle_name">
                                        <label for="middle_name">Middle Name:</label>
                                        <input type="text" id="middle_name" name="middle_name" class="form-input" value="{{ old('middle_name') }}">
                                    </div>
                                </div>
                                <div class="info">
                                    <div class="form-group nickname">
                                        <label for="nickname">Nickname*:</label>
                                        <input type="text" id="nickname" name="nickname" class="form-input" value="{{ old('nickname') }}">
                                    </div>
                                    <div class="form-group birthdate">
                                        <label for="add-admin-birthdate">Birthdate*:</label>
                                        <div class="birthday-picker" data-birthday-picker>
                                            <input type="date" id="add-admin-birthdate" name="birthdate" class="form-input" value="{{ old('birthdate') }}" data-role="input">
                                            <button type="button" aria-label="Open birthday calendar" aria-expanded="false" data-role="toggle"><span aria-hidden="true">▦</span></button>
                                            <div class="birthday-calendar" data-role="calendar" hidden>
                                                <div class="birthday-calendar-header">
                                                    <button type="button" aria-label="Previous month" data-role="previous-month">‹</button>
                                                    <button type="button" class="birthday-month-button" aria-expanded="false" data-role="month-button">Month</button>
                                                    <button type="button" class="birthday-year-button" aria-expanded="false" data-role="year-button">Year</button>
                                                    <button type="button" aria-label="Next month" data-role="next-month">›</button>
                                                </div>
                                                <div class="birthday-month-picker" data-role="month-picker" hidden>
                                                    <div class="birthday-month-grid" data-role="month-grid"></div>
                                                </div>
                                                <div class="birthday-year-picker" data-role="year-picker" hidden>
                                                    <div class="birthday-year-header">
                                                        <button type="button" aria-label="Previous years" data-role="previous-year-range">‹</button>
                                                        <span data-role="year-range"></span>
                                                        <button type="button" aria-label="Next years" data-role="next-year-range">›</button>
                                                    </div>
                                                    <div class="birthday-year-grid" data-role="year-grid"></div>
                                                </div>
                                                <div class="birthday-calendar-grid" data-role="day-grid"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group gender">
                                        <label for="gender">Gender*:</label>
                                        <select id="gender" name="gender" class="form-cb">
                                            <option value="" selected disabled hidden></option>
                                            <option value="Female" {{ old('gender') === 'Female' ? 'selected' : ''}}>Female</option>
                                            <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="contact">
                                    <div class="form-group address">
                                        <label for="address">Address:</label>
                                        <input type="text" id="address" name="address" class="form-input" value="{{ old('address') }}">
                                    </div>
                                    <div class="form-group phone_number">
                                        <label for="phone_number">Phone Number:</label>
                                        <input type="tel" id="phone_number" name="phone_number" class="form-input" value="{{ old('phone_number') }}">
                                    </div>
                                </div>
                                <div class="login-details">
                                    <div class="form-group email">
                                        <label for="email">Email Address*:</label>
                                        <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}">
                                    </div>
                                    <div class="password-group">
                                        <label for="password">Password*:</label>
                                        <div class="password-row">
                                            <input type="password" id="password" name="password" class="form-input" placeholder=" Leave blank to set default password (spum123)">
                                        </div>
                                    </div>
                                </div>
                                <div class="account">
                                    <div class="form-group user_type">
                                        <label for="user_type">User Type*:</label>
                                        <select type="hidden" id="user_type" name="user_type" class="form-cb" disabled>
                                            <option value="Resident" {{ old('user_type') === 'Resident' ? 'selected' : '' }}>Resident</option>
                                        </select>
                                        <input type="hidden" name="user_type" value="Resident">
                                    </div>
                                </div>
                            </div>
                        </div>
 
                        {{-- resident section --}}
                        <hr style="margin: 0.5rem 0.5rem 1rem 0.5rem;">
                        <h2 class="modal-title">Resident Information</h2>
                        <div class="resident-type">
                            <div class="form-group accommodation_type">
                                <label for="accommodation_type">Accommodation Type*:</label>
                                <select name="accommodation_type" id="accommodation_type" class="form-cb" disabled>
                                    <option value="Resident" {{ old('accommodation_type'), request('view') === 'resident' ? 'selected' : '' }}>Resident</option>
                                    <option value="Transient" {{ old('accommodation_type'), request('view') === 'transient' ? 'selected' : '' }}>Transient</option>
                                </select>
                                <input type="hidden" name="accommodation_type" value="{{ request('view') === 'transient' ? 'Transient' : 'Resident' }}">
                            </div>
                            <div class="form-group resident_type">
                                <label for="resident_type">Resident Type*:</label>
                                <select name="resident_type" id="resident_type" class="form-cb">
                                    <option value="" selected disabled hidden></option>
                                    <option value="Student" {{ old('resident_type') === 'Student' ? 'selected' : '' }}>Student</option>
                                    <option value="Employee" {{ old('resident_type') === 'Employee' ? 'selected' : '' }}>Employee</option>
                                </select>
                            </div>
                        </div>
                        <div class="lodging-type">
                            <div class="form-group payment_schedule">
                                <label for="payment_schedule">Payment Schedule*:</label>
                                @if (request('view') === 'transient')
                                    <select name="payment_schedule" id="payment_schedule" class="form-cb" disabled>
                                        <option selected>Per Day</option>
                                        <input type="hidden" name="payment_schedule" value="Per Day">
                                    </select>
                                @else
                                    <select name="payment_schedule" id="payment_schedule" class="form-cb">
                                        <option value="" selected disabled hidden></option>
                                        <option value="Full Payment" {{ old('payment_schedule') == 'Full Payment' ? 'selected' : '' }}>Full Payment</option>
                                        <option value="4 Payments" {{ old('payment_schedule') == '4 Payments' ? 'selected' : '' }}>4 Payments</option>
                                        <option value="3 Payments" {{ old('payment_schedule') == '3 Payments' ? 'selected' : '' }}>3 Payments</option>
                                        <option value="2 Payments" {{ old('payment_schedule') == '2 Payments' ? 'selected' : '' }}>2 Payments</option>
                                        <option value="Monthly" {{ old('payment_schedule') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                    </select>
                                @endif
                            </div>
                            <div class="form-group room_type">
                                <label for="room_type">Room Type*:</label>
                                <select name="room_type" id="room_type" class="form-cb">
                                    <option value="" selected disabled hidden></option>
                                    <option value="8 persons" {{ old('room_type') === '8 persons' ? 'selected' : '' }}>8 persons</option>
                                    <option value="4 persons" {{ old('room_type') === '4 persons' ? 'selected' : '' }}>4 persons</option>
                                    <option value="3 persons" {{ old('room_type') === '3 persons' ? 'selected' : '' }}>3 persons</option>
                                    <option value="2 persons" {{ old('room_type') === '2 persons' ? 'selected' : '' }}>2 persons</option>
                                    <option value="1 person" {{ old('room_type') === '1 person' ? 'selected' : '' }}>1 person</option>
                                </select>
                            </div>
                        </div>
                        <div class="checkin-checkout">
                            <div class="form-group check_in_date">
                                <label for="check_in_date">Check In*:</label>
                                <input type="date" id="check_in_date" name="check_in_date" class="form-input" value="{{ old('check_in_date') }}">
                            </div>
                            <div class="form-group check_out_date">
                                <label for="check_out_date">Check Out*:</label>
                                <input type="date" id="check_out_date" name="check_out_date" class="form-input" value="{{ old('check_out_date') }}">
                            </div>
                        </div>
                        <div class="form-buttons">
                            <button type="submit" class="btn-primary">Create User</button>
                            <button type="reset" class="btn-primary">Clear</button>
                            <a href="{{ route('users.index', ['view' => request('view')]) }}" class="btn-primary">Close</a>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        {{-- =============================== EDIT USER MODAL =============================== --}}
        {{-- pull up info of selected user ADMIN --}}
        @php
            $selectedUser = null;
            if (request('user')) {
                $selectedUser = \App\Models\User::with('resident.room')->find(request('user'));
            }
        @endphp
        {{-- pull up edit user modal --}}
        @if(request('modal') == 'edit-user' && $selectedUser)
            @php
                $isInactive = $selectedUser->status === 'Inactive';
            @endphp
            <div class="modal">
                <div class="card user-modal">
                    <h2 class="modal-title">Edit User: <span>{{ $selectedUser->userName() }}</span></h2>
                    @if ($isInactive)
                        <div class="inactive-banner">This account is inactive. Please reactivate to edit information.</div>
                    @endif
                    <form action="{{ route('users.update', $selectedUser) }}" method="POST" enctype="multipart/form-data" id="edit-user-form">
                        @csrf
                        @method('PUT')
                        {{-- PERSONAL INFORMATION --}}
                        <div class="user-top-section">
                            <div class="sidebar">
                                <div class="image-upload" style="align-items: center; margin: 0;">
                                    <img id="preview-image" src="{{ $selectedUser->profile_picture ? asset($selectedUser->profile_picture) : asset('images/users/user-profile.png') }}" style="margin: 0;">
                                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*" hidden @disabled($isInactive)>
                                    <label for="profile_picture" class="btn-primary {{ $isInactive ? 'inactive-btn' : '' }}">Choose File</label>
                                    <p id="file-name" style="padding-bottom: 0.3rem; font-weight: 400;">No file chosen</p>
                                </div>
                                @if($selectedUser->resident)
                                    <p>Resident ID: <br><span>{{ $selectedUser->resident->id }}</span></p>
                                    <p>Room: <br><span>{{ $selectedUser->resident->room?->dorm_name ?? 'Unassigned' }} {{ $selectedUser->resident->room?->room_number ?? '' }}</span></p>
                                    @if ($selectedUser->resident->resident_type == 'Student')
                                        <a id="enroll-button" href="/residents/{{ $selectedUser->resident->id }}/enroll-face" class="btn-primary {{ $isInactive ? 'inactive-btn' : '' }}" @disabled($isInactive)>Enroll Face</a>                                
                                    @endif
                                @else
                                    <p>User ID: <span>{{ $selectedUser->id }}</span></p>
                                @endif
                            </div>
                            <div class="user-details">
                                <div class="fullname">
                                    <div class="form-group last_name">
                                        <label for="last_name">Last Name*:</label>
                                        <input type="text" id="last_name" name="last_name" class="form-input" value="{{ $selectedUser->last_name }}" @disabled($isInactive)>
                                    </div>
                                    <div class="form-group first_name">
                                        <label for="first_name">First Name*:</label>
                                        <input type="text" id="first_name" name="first_name" class="form-input" value="{{ $selectedUser->first_name }}" @disabled($isInactive)>
                                    </div>
                                    <div class="form-group middle_name">
                                        <label for="middle_name">Middle Name:</label>
                                        <input type="text" id="middle_name" name="middle_name" class="form-input" value="{{ $selectedUser->middle_name }}" @disabled($isInactive)>
                                    </div>
                                </div>
                                <div class="info">
                                    <div class="form-group nickname">
                                        <label for="nickname">Nickname*:</label>
                                        <input type="text" id="nickname" name="nickname" class="form-input" value="{{ $selectedUser->nickname }}" @disabled($isInactive)>
                                    </div>
                                    <div class="form-group birthdate">
                                        <label for="add-admin-birthdate">Birthdate*:</label>
                                        <div class="birthday-picker" data-birthday-picker>
                                            <input type="date" id="add-admin-birthdate" name="birthdate" class="form-input" value="{{ $selectedUser->birthdate?->format('Y-m-d') }}" data-role="input" @disabled($isInactive)>
                                            <button type="button" aria-label="Open birthday calendar" aria-expanded="false" data-role="toggle"><span aria-hidden="true">▦</span></button>
                                            <div class="birthday-calendar" data-role="calendar" hidden>
                                                <div class="birthday-calendar-header">
                                                    <button type="button" aria-label="Previous month" data-role="previous-month">‹</button>
                                                    <button type="button" class="birthday-month-button" aria-expanded="false" data-role="month-button">Month</button>
                                                    <button type="button" class="birthday-year-button" aria-expanded="false" data-role="year-button">Year</button>
                                                    <button type="button" aria-label="Next month" data-role="next-month">›</button>
                                                </div>
                                                <div class="birthday-month-picker" data-role="month-picker" hidden>
                                                    <div class="birthday-month-grid" data-role="month-grid"></div>
                                                </div>
                                                <div class="birthday-year-picker" data-role="year-picker" hidden>
                                                    <div class="birthday-year-header">
                                                        <button type="button" aria-label="Previous years" data-role="previous-year-range">‹</button>
                                                        <span data-role="year-range"></span>
                                                        <button type="button" aria-label="Next years" data-role="next-year-range">›</button>
                                                    </div>
                                                    <div class="birthday-year-grid" data-role="year-grid"></div>
                                                </div>
                                                <div class="birthday-calendar-grid" data-role="day-grid"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group gender">
                                        <label for="gender">Gender*:</label>
                                        <select id="gender" name="gender" class="form-cb" @disabled($isInactive)>
                                            <option value="" selected disabled hidden>Select Gender</option>
                                            <option value="Female" {{ $selectedUser->gender === 'Female' ? 'selected' : ''}}>Female</option>
                                            <option value="Male" {{ $selectedUser->gender === 'Male' ? 'selected' : '' }}>Male</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="contact">
                                    <div class="form-group address">
                                        <label for="address">Address:</label>
                                        <input type="text" id="address" name="address" class="form-input" value="{{ $selectedUser->address }}" @disabled($isInactive)>
                                    </div>
                                    <div class="form-group phone_number">
                                        <label for="phone_number">Phone Number:</label>
                                        <input type="tel" id="phone_number" name="phone_number" class="form-input" value="{{ $selectedUser->phone_number }}" @disabled($isInactive)>
                                    </div>
                                </div>
                                <div class="login-details">
                                    <div class="form-group email">
                                        <label for="email">Email Address*:</label>
                                        <input type="email" id="email" name="email" class="form-input" value="{{ $selectedUser->email }}" @disabled($isInactive)>
                                    </div>
                                    <div class="password-group">
                                        <label for="password">Password*:</label>
                                        <div class="password-row">
                                            <input type="password" id="password" name="password" class="form-input" placeholder="Leave blank to keep current password" @disabled($isInactive)>
                                            <button type="submit" name="reset_password" value="1" class="btn-primary  {{ $isInactive ? 'inactive-btn' : '' }}" @disabled($isInactive)>Reset</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="account">
                                    <div class="form-group user_type">
                                        <label for="user_type">User Type*:</label>
                                        @if ($selectedUser->resident)
                                            <select type="hidden" id="user_type" name="user_type" class="form-cb" @disabled($isInactive)>
                                                <option value="Resident" {{ $selectedUser->user_type === 'Resident' ? 'selected' : '' }} @disabled($isInactive)>Resident</option>
                                            </select>
                                            <input type="hidden" name="user_type" value="Resident">
                                        @else
                                            <select id="user_type" name="user_type" class="form-cb" @disabled($isInactive)>
                                                <option value="Admin" {{ $selectedUser->user_type === 'Admin' ? 'selected' : '' }} @disabled($isInactive)>Admin</option>
                                                <option value="Manager" {{ $selectedUser->user_type === 'Manager' ? 'selected' : '' }} @disabled($isInactive)>Manager</option>
                                                <option value="Guard" {{ $selectedUser->user_type === 'Guard' ? 'selected' : '' }} @disabled($isInactive)>Guard</option>
                                            </select>
                                        @endif
                                    </div>
                                    <div class="form-group user-status">
                                        <label for="user-status">User Status*:</label>
                                        <select id="user-status" name="status" class="form-cb">
                                            <option value="Active" {{ $selectedUser->status === 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Inactive" {{ $selectedUser->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                         </div>
                        {{-- resident section --}}
                        @if($selectedUser->user_type === 'Resident' && $selectedUser->resident)
                            <hr style="margin: 0.5rem 0.5rem 1rem 0.5rem;">
                            @php
                                $paymentOptions = match($selectedUser->resident->accommodation_type) {
                                    'Resident' => ['Full Payment', '4 Payments', '3 Payments', '2 Payments', 'Monthly'],
                                    'Transient' => ['Per Day'],
                                    default => [],
                                };
                            @endphp
                            <h2 class="modal-title">Resident Information</h2>
                            @if ($isInactive)
                                <div class="inactive-banner">Please update resident information before saving.</div>
                            @endif
                            <div class="resident-type">
                                <div class="form-group accommodation_type">
                                    <label for="accommodation_type">Accommodation Type*:</label>
                                    <select name="accommodation_type" id="accommodation_type" class="form-cb" @disabled($isInactive)>
                                        <option value="" selected disabled hidden></option>
                                        <option value="Resident" {{ $selectedUser->resident->accommodation_type === 'Resident' ? 'selected' : '' }}>Resident</option>
                                        <option value="Transient" {{ $selectedUser->resident->accommodation_type === 'Transient' ? 'selected' : '' }}>Transient</option>
                                    </select>
                                </div>
                                <div class="form-group resident_type">
                                    <label for="resident_type">Resident Type*:</label>
                                    <select name="resident_type" id="resident_type" class="form-cb" @disabled($isInactive)>
                                        <option value="" selected disabled hidden></option>
                                        <option value="Student" {{ $selectedUser->resident->resident_type === 'Student' ? 'selected' : '' }} @disabled($isInactive)>Student</option>
                                        <option value="Employee" {{ $selectedUser->resident->resident_type === 'Employee' ? 'selected' : '' }} @disabled($isInactive)>Employee</option>
                                    </select>
                                </div>
                            </div>
                            <div class="lodging-type">
                                <div class="form-group payment_schedule">
                                    <label for="payment_schedule">Payment Schedule*:</label>
                                    <select name="payment_schedule" id="payment_schedule" class="form-cb" @disabled($isInactive)>
                                        <option value="" selected disabled hidden></option>
                                        @foreach ($paymentOptions as $paymentOption)
                                            <option value="{{ $paymentOption }}" @selected($selectedUser->resident->payment_schedule == $paymentOption) @disabled($isInactive)>{{ $paymentOption }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group room_type">
                                    <label for="room_type">Room Type*:</label>
                                    <select name="room_type" id="room_type" class="form-cb" @disabled($isInactive)>
                                        <option value="" selected disabled hidden></option>
                                        <option value="8 persons" {{ $selectedUser->resident->room_type === '8 persons' ? 'selected' : '' }} @disabled($isInactive)>8 persons</option>
                                        <option value="4 persons" {{ $selectedUser->resident->room_type === '4 persons' ? 'selected' : '' }} @disabled($isInactive)>4 persons</option>
                                        <option value="3 persons" {{ $selectedUser->resident->room_type === '3 persons' ? 'selected' : '' }} @disabled($isInactive)>3 persons</option>
                                        <option value="2 persons" {{ $selectedUser->resident->room_type === '2 persons' ? 'selected' : '' }} @disabled($isInactive)>2 persons</option>
                                        <option value="1 person" {{ $selectedUser->resident->room_type === '1 person' ? 'selected' : '' }} @disabled($isInactive)>1 person</option>
                                    </select>
                                </div>
                            </div>
                            <div class="checkin-checkout">
                                <div class="form-group check_in_date">
                                    <label for="check_in_date">Check In*:</label>
                                    <input type="date" id="check_in_date" name="check_in_date" class="form-input" value="{{ $isInactive ? '' : $selectedUser->resident->check_in_date?->format('Y-m-d') }}" @disabled($isInactive)>
                                </div>
                                <div class="form-group check_out_date">
                                    <label for="check_out_date">Check Out*:</label>
                                    <input type="date" id="check_out_date" name="check_out_date" class="form-input" value="{{ $isInactive ? '' : $selectedUser->resident->check_out_date?->format('Y-m-d') }}" @disabled($isInactive)>
                                </div>
                            </div>
                        @endif
                        <div class="form-buttons">
                            <button type="submit" class="btn-primary">Save Changes</button>
                            <button type="reset" class="btn-primary {{ $isInactive ? 'inactive-btn' : '' }}" @disabled($isInactive)>Restore</button>
                            <a href="{{ route('users.index', ['view' => request('view')]) }}" class="btn-primary">Close</a>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        {{-- confirmation --}}
        @if(session('success'))
            <div class="modal">
                <div class="card user-modal receipt-modal">
                    <h2 class="modal-title">{{ session('receipt.action') }}</h2>
                    <p style="text-align:center;">{{ session('success') }}</p>
                    @if(session('receipt'))
                        <div class="receipt-box">
                            <hr>
                            <h3>User Information</h3>
                            <div class="receipt-row"><strong>Last Name:</strong><span>{{ session('receipt.last_name') }}</span></div>
                            <div class="receipt-row"><strong>First Name:</strong><span>{{ session('receipt.first_name') }}</span></div>
                            <div class="receipt-row"> <strong>Middle Name:</strong> <span>{{ session('receipt.middle_name') }}</span> </div>
                            <div class="receipt-row"> <strong>Nickname:</strong> <span>{{ session('receipt.nickname') }}</span> </div>
                            <div class="receipt-row"> <strong>Birthdate:</strong> <span>{{ session('receipt.birthdate') }}</span> </div>
                            <div class="receipt-row"> <strong>Phone Number:</strong> <span>{{ session('receipt.phone_number') }}</span> </div>
                            <div class="receipt-row"> <strong>Address:</strong> <span>{{ session('receipt.address') }}</span> </div>
                            <div class="receipt-row"> <strong>Email:</strong> <span>{{ session('receipt.email') }}</span> </div>
                            <div class="receipt-row"> <strong>User Type:</strong> <span>{{ session('receipt.user_type') }}</span> </div>
                            <div class="receipt-row"> <strong>Status:</strong> <span>{{ session('receipt.status') }}</span> </div>
                            <div class="receipt-row"> <strong>Password Updated:</strong> <span>{{ session('receipt.password_updated') ? 'Yes' : 'No' }}</span> </div>
                            <hr>
                            @if(session('receipt.resident_type'))
                                <h3>Resident Information</h3>
                                <div class="receipt-row"><strong>Accommodation Type:</strong><span>{{ session('receipt.accommodation_type') }}</span></div>
                                <div class="receipt-row"><strong>Resident Type:</strong><span>{{ session('receipt.resident_type') }}</span></div>
                                <div class="receipt-row"><strong>Payment Schedule:</strong><span>{{ session('receipt.payment_schedule') }}</span></div>
                                <div class="receipt-row"><strong>Room Type:</strong><span>{{ session('receipt.room_type') }}</span></div>
                                <div class="receipt-row"><strong>Check In Date:</strong><span>{{ session('receipt.check_in_date') }}</span></div>
                                <div class="receipt-row"><strong>Check Out Date:</strong><span>{{ session('receipt.check_out_date') ?? 'N/A' }}</span></div>
                            @endif
                        </div>
                    @endif
                    <div class="form-buttons">
                        <button class="btn-primary" onclick="this.closest('.modal').remove()">OK</button>
                    </div>
                </div>
            </div>
        @endif
        @if(session('face_enrolled'))
            <div class="modal">
                <div class="card receipt-modal" style="background-color: var(--body-color);">
                    <h2 class="modal-title">FACE ENROLLED</h2>
                    <div class="form-buttons">
                        <button type="button" class="btn-primary" onclick="this.closest('.modal').remove()">OK</button>
                    </div>
                </div>
            </div>
        @endif
        
        {{-- error receipt --}}
            {{-- CANCEL FACE ENROLLMENT POP OUT --}}
        @if(session('face_cancelled'))
            <div class="modal">
                <div class="card receipt-modal" style="background-color: var(--body-color);">
                    <h2 class="modal-title">FACE ENROLLMENT CANCELLED</h2>
                    <div class="form-buttons">
                        <button type="button" class="btn-primary" onclick="this.closest('.modal').remove()">OK</button>
                    </div>
                </div>
            </div>
        @endif
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
</x-layout>