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
                    <a href="{{ route('users.index', ['modal' => 'edit-user', 'user' => $admin->id, 'view' => request('view')]) }}">
                        <div class="card dorm-card {{ $admin->status === 'Inactive' ? 'inactive-card' : '' }}">
                            <div class="room-image"><img src="{{ asset($admin->profile_picture) }}"></div>
                            <div class="room-number"><p>{{ $admin->nickname }}</p></div>
                        </div>
                    </a>
                @empty
                    <p>No administrators found.</p>
                @endforelse
            </section>
        </section>
        <section class="dorm-section">
            <div class="residents-header">
                <a href="{{ route('users.index', ['view' => request('view') === 'transient' ? 'resident' : 'transient']) }}" class="btn-primary">{{ request('view') === 'transient' ? 'View Residents' : 'View Transients' }}</a>
                <div class="residents-title">
                    <h2>{{ request('view') === 'transient' ? 'Transients' : 'Residents' }}</h2>
                    <a href="{{ route('users.index', ['modal' => 'add-resident', 'view' => request('view')]) }}" class="btn-primary">+ Add {{ request('view') === 'transient' ? 'Transient' : 'Resident' }}</a>
                </div>
            </div>
            <hr>
            <div class="section-dormname" style="margin-top: 0; margin-bottom: 1rem;">
                <a href="{{ route('users.index', ['view' => request('view')]) }}" class="btn-primary">All Residents</a>
                <a href="{{ route('users.index', ['view' => request('view'), 'resident_type' => 'Student']) }}" class="btn-primary">Students</a>
                <a href="{{ route('users.index', ['view' => request('view'), 'resident_type' => 'Employee']) }}" class="btn-primary">Employees</a>
            </div>
            <section class="flex-view">
                @forelse ($residents as $resident)
                    <a href="{{ route('users.index', ['modal' => 'edit-user', 'user' => $resident->user->id, 'view' => request('view')]) }}">
                        <div class="card dorm-card {{ $resident->user->status === 'Inactive' ? 'inactive-card' : '' }}">
                            <div class="room-image"><img src="{{ asset($resident->user->profile_picture) }}"></div>
                            <div class="room-number"><p>{{ $resident->user->nickname }}</p></div>
                            <div class="room-info"><p>Room: {{ $resident->room?->room_number ?? 'Unassigned' }}</p></div>
                            <div class="room-info"><p>Dorm: {{ $resident->room?->dorm_name ?? 'Unassigned' }}</p></div>
                            <div class="room-info"><p>Resident Type: {{ $resident->resident_type }}</p></div>
                        </div>
                    </a>
                @empty
                    <p>No residents found.</p>
                @endforelse
            </section>
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
                                    <img id="preview-image" 
                                        src="{{ asset('images/users/user-profile.png') }}">
                                    <input
                                        type="file"
                                        name="profile_picture"
                                        id="profile_picture"
                                        accept="image/*">
                                </div>
                            </div>
                            <div class="user-details">
                                <div class="fullname">
                                    <div class="form-group last_name">
                                        <label for="last_name">Last Name:</label>
                                        <input type="text" id="last_name" name="last_name" class="form-input" value="{{ old('last_name') }}">
                                    </div>
                                    <div class="form-group first_name">
                                        <label for="first_name">First Name:</label>
                                        <input type="text" id="first_name" name="first_name" class="form-input" value="{{ old('first_name') }}">
                                    </div>
                                    <div class="form-group middle_name">
                                        <label for="middle_name">Middle Name:</label>
                                        <input type="text" id="middle_name" name="middle_name" class="form-input" value="{{ old('middle_name') }}">
                                    </div>
                                </div>
                                <div class="info">
                                    <div class="form-group nickname">
                                        <label for="nickname">Nickname:</label>
                                        <input type="text" id="nickname" name="nickname" class="form-input" value="{{ old('nickname') }}">
                                    </div>
                                    <div class="form-group birthdate">
                                        <label for="birthdate">Birthdate:</label>
                                        <input type="date" id="birthdate" name="birthdate" class="form-input" value="{{ old('birthdate') }}">
                                    </div>
                                    <div class="form-group phone_number">
                                        <label for="phone_number">Phone Number:</label>
                                        <input type="tel" id="phone_number" name="phone_number" class="form-input" value="{{ old('phone_number') }}">
                                    </div>
                                </div>
                                <div class="contact">
                                    <div class="form-group address">
                                        <label for="address">Address:</label>
                                        <input type="text" id="address" name="address" class="form-input" value="{{ old('address') }}">
                                    </div>
                                </div>
                                <div class="login-details">
                                    <div class="form-group email">
                                        <label for="email">Email Address:</label>
                                        <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}">
                                    </div>
                                    <div class="form-group password">
                                        <label for="password">Password:</label>
                                        <input type="password" id="password" name="password" class="form-input" placeholder="Default Password: spum123">
                                    </div>
                                </div>
                                <div class="account">
                                    <div class="form-group user_type">
                                        <label for="user_type">User Type:</label>
                                        <select id="user_type" name="user_type" class="form-cb">
                                            <option value="" selected disabled hidden>Select User Type</option>
                                            <option value="Admin" {{ old('user_type') === 'Admin' ? 'selected' : ''}}>Admin</option>
                                            <option value="Manager" {{ old('user_type') === 'Manager' ? 'selected' : '' }}>Manager</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-buttons">
                            <button type="submit" class="btn-primary">Save Changes</button>
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
                    <h2 class="modal-title">Add Resident / Transient</h2>
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- PERSONAL INFORMATION --}}
                        <div class="user-top-section">
                            <div class="sidebar">
                                <div class="image-upload" style="align-items: center;">
                                    <img id="preview-image" 
                                        src="{{ asset('images/users/user-profile.png') }}">
                                    <input
                                        type="file"
                                        name="profile_picture"
                                        id="profile_picture"
                                        accept="image/*">
                                </div>
                            </div>
                            <div class="user-details">
                                <div class="fullname">
                                    <div class="form-group last_name">
                                        <label for="last_name">Last Name:</label>
                                        <input type="text" id="last_name" name="last_name" class="form-input" value="{{ old('last_name') }}">
                                    </div>
                                    <div class="form-group first_name">
                                        <label for="first_name">First Name:</label>
                                        <input type="text" id="first_name" name="first_name" class="form-input" value="{{ old('first_name') }}">
                                    </div>
                                    <div class="form-group middle_name">
                                        <label for="middle_name">Middle Name:</label>
                                        <input type="text" id="middle_name" name="middle_name" class="form-input" value="{{ old('middle_name') }}">
                                    </div>
                                </div>
                                <div class="info">
                                    <div class="form-group nickname">
                                        <label for="nickname">Nickname:</label>
                                        <input type="text" id="nickname" name="nickname" class="form-input" value="{{ old('nickname') }}">
                                    </div>
                                    <div class="form-group birthdate">
                                        <label for="birthdate">Birthdate:</label>
                                        <input type="date" id="birthdate" name="birthdate" class="form-input" value="{{ old('birthdate') }}">
                                    </div>
                                    <div class="form-group phone_number">
                                        <label for="phone_number">Phone Number:</label>
                                        <input type="tel" id="phone_number" name="phone_number" class="form-input" value="{{ old('phone_number') }}">
                                    </div>
                                </div>
                                <div class="contact">
                                    <div class="form-group address">
                                        <label for="address">Address:</label>
                                        <input type="text" id="address" name="address" class="form-input" value="{{ old('address') }}">
                                    </div>
                                </div>
                                <div class="login-details">
                                    <div class="form-group email">
                                        <label for="email">Email Address:</label>
                                        <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}">
                                    </div>
                                    <div class="form-group password">
                                        <label for="password">Password:</label>
                                        <input type="password" id="password" name="password" class="form-input" placeholder="Default Password: spum123" value="{{ old('password') }}">
                                    </div>
                                </div>
                                <div class="account">
                                    <div class="form-group user_type">
                                        <label for="user_type">User Type:</label>
                                        <select id="user_type" name="user_type" class="form-cb">
                                            <option value="Resident" {{ old('user_type') === 'Resident' ? 'selected' : '' }}>Resident</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
 
                        {{-- resident section --}}
                        <hr style="margin: 0.5rem 0.5rem 1rem 0.5rem;">
                        <h2 class="modal-title">Resident Information</h2>
                        <div class="resident-type">
                            <div class="form-group accommodation_type">
                                <label for="accommodation_type">Accommodation Type:</label>
                                <select name="accommodation_type" id="accommodation_type" class="form-cb">
                                    <option value="Resident" {{ old('accommodation_type') === 'Resident' ? 'selected' : '' }}>Resident</option>
                                    <option value="Transient" {{ old('accommodation_type') === 'Transient' ? 'selected' : '' }}>Transient</option>
                                </select>
                            </div>
                            <div class="form-group resident_type">
                                <label for="resident_type">Resident Type:</label>
                                <select name="resident_type" id="resident_type" class="form-cb">
                                    <option value="Student" {{ old('resident_type') === 'Student' ? 'selected' : '' }}>Student</option>
                                    <option value="Employee" {{ old('resident_type') === 'Employee' ? 'selected' : '' }}>Employee</option>
                                </select>
                            </div>
                        </div>
                        <div class="lodging-type">
                            <div class="form-group payment_schedule">
                                <label for="payment_schedule">Payment Schedule:</label>
                                <select name="payment_schedule" id="payment_schedule" class="form-cb">
                                    <option value="Full Payment" {{ old('payment_schedule') == 'Full Payment' ? 'selected' : '' }}>Full Payment</option>
                                    <option value="4 Payments" {{ old('payment_schedule') == '4 Payments' ? 'selected' : '' }}>4 Payments</option>
                                    <option value="3 Payments" {{ old('payment_schedule') == '3 Payments' ? 'selected' : '' }}>3 Payments</option>
                                    <option value="2 Payments" {{ old('payment_schedule') == '2 Payments' ? 'selected' : '' }}>2 Payments</option>
                                    <option value="Monthly" {{ old('payment_schedule') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="Per Day" {{ old('payment_schedule') == 'Per Day' ? 'selected' : '' }}>Per Day</option>
                                </select>
                            </div>
                            <div class="form-group room_type">
                                <label for="room_type">Room Type:</label>
                                <select name="room_type" id="room_type" class="form-cb">
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
                                <label for="check_in_date">Check In:</label>
                                <input type="date" id="check_in_date" name="check_in_date" class="form-input" value="{{ old('check_in_date') }}">
                            </div>
                            <div class="form-group check_out_date">
                                <label for="check_out_date">Check Out:</label>
                                <input type="date" id="check_out_date" name="check_out_date" class="form-input" value="{{ old('check_out_date') }}">
                            </div>
                        </div>
                        <div class="form-buttons">
                            <button type="submit" class="btn-primary">Save Changes</button>
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
            <div class="modal">
                <div class="card user-modal">
                    <h2 class="modal-title">Edit User: <span>{{ $selectedUser->nickname }}</span></h2>
                    <form action="{{ route('users.update', $selectedUser) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        {{-- PERSONAL INFORMATION --}}
                        <div class="user-top-section">
                            <div class="sidebar">
                                <div class="image-upload" style="align-items: center;">
                                    <img id="preview-image" 
                                        src="{{ $selectedUser->profile_picture
                                            ? asset($selectedUser->profile_picture)
                                            : asset('images/user-profile.png') }}">
                                    <input
                                        type="file"
                                        name="profile_picture"
                                        id="profile_picture"
                                        accept="image/*"
                                        hidden>
                                    <label for="profile_picture" class="btn-primary">Choose File</label>
                                    <span id="file-name">No file chosen</span><br>
                                </div>
                                @if($selectedUser->resident)
                                    <p>Resident ID: <br><span>{{ $selectedUser->resident->id }}</span></p><br>
                                    <p>Room: <br><span>{{ $selectedUser->resident->room?->dorm_name ?? 'Unassigned' }} {{ $selectedUser->resident->room?->room_number ?? '' }}</span></p>
                                @else
                                    <p>User ID: <span>{{ $selectedUser->id }}</span></p>
                                @endif
                            </div>
                            <div class="user-details">
                                <div class="fullname">
                                    <div class="form-group last_name">
                                        <label for="last_name">Last Name:</label>
                                        <input type="text" id="last_name" name="last_name" class="form-input" value="{{ $selectedUser->last_name }}">
                                    </div>
                                    <div class="form-group first_name">
                                        <label for="first_name">First Name:</label>
                                        <input type="text" id="first_name" name="first_name" class="form-input" value="{{ $selectedUser->first_name }}">
                                    </div>
                                    <div class="form-group middle_name">
                                        <label for="middle_name">Middle Name:</label>
                                        <input type="text" id="middle_name" name="middle_name" class="form-input" value="{{ $selectedUser->middle_name }}">
                                    </div>
                                </div>
                                <div class="info">
                                    <div class="form-group nickname">
                                        <label for="nickname">Nickname:</label>
                                        <input type="text" id="nickname" name="nickname" class="form-input" value="{{ $selectedUser->nickname }}">
                                    </div>
                                    <div class="form-group birthdate">
                                        <label for="birthdate">Birthdate:</label>
                                        <input type="date" id="birthdate" name="birthdate" class="form-input" value="{{ $selectedUser->birthdate?->format('Y-m-d') }}">
                                    </div>
                                    <div class="form-group phone_number">
                                        <label for="phone_number">Phone Number:</label>
                                        <input type="tel" id="phone_number" name="phone_number" class="form-input" value="{{ $selectedUser->phone_number }}">
                                    </div>
                                </div>
                                <div class="contact">
                                    <div class="form-group address">
                                        <label for="address">Address:</label>
                                        <input type="text" id="address" name="address" class="form-input" value="{{ $selectedUser->address }}">
                                    </div>
                                </div>
                                <div class="login-details">
                                    <div class="form-group email">
                                        <label for="email">Email Address:</label>
                                        <input type="email" id="email" name="email" class="form-input" value="{{ $selectedUser->email }}">
                                    </div>
                                    <div class="form-group password">
                                        <label for="password">Password:</label>
                                        <input type="password" id="password" name="password" class="form-input" placeholder="Leave blank to keep current password">
                                    </div>
                                    <div class="reset-password-btn">
                                        <button type="submit" name="reset_password" value="1" class="btn-primary ">Reset</button>
                                    </div>
                                </div>
                                <div class="account">
                                    <div class="form-group user_type">
                                        <label for="user_type">User Type:</label>
                                        <select id="user_type" name="user_type" class="form-cb">
                                            <option value="Admin" {{ $selectedUser->user_type === 'Admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="Manager" {{ $selectedUser->user_type === 'Manager' ? 'selected' : '' }}>Manager</option>
                                            <option value="Resident" {{ $selectedUser->user_type === 'Resident' ? 'selected' : '' }}>Resident</option>
                                        </select>
                                    </div>
                                    <div class="form-group user-status">
                                        <label for="user-status">User Status:</label>
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
                            <div class="resident-type">
                                <div class="form-group accommodation_type">
                                    <label for="accommodation_type">Accommodation Type:</label>
                                    <select name="accommodation_type" id="accommodation_type" class="form-cb">
                                        <option value="Resident" {{ $selectedUser->resident->accommodation_type === 'Resident' ? 'selected' : '' }}>Resident</option>
                                        <option value="Transient" {{ $selectedUser->resident->accommodation_type === 'Transient' ? 'selected' : '' }}>Transient</option>
                                    </select>
                                </div>
                                <div class="form-group resident_type">
                                    <label for="resident_type">Resident Type:</label>
                                    <select name="resident_type" id="resident_type" class="form-cb">
                                        <option value="Student" {{ $selectedUser->resident->resident_type === 'Student' ? 'selected' : '' }}>Student</option>
                                        <option value="Employee" {{ $selectedUser->resident->resident_type === 'Employee' ? 'selected' : '' }}>Employee</option>
                                    </select>
                                </div>
                            </div>
                            <div class="lodging-type">
                                <div class="form-group payment_schedule">
                                    <label for="payment_schedule">Payment Schedule:</label>
                                    <select name="payment_schedule" id="payment_schedule" class="form-cb">
                                        @foreach ($paymentOptions as $paymentOption)
                                            <option value="{{ $paymentOption }}" @selected($selectedUser->resident->payment_schedule == $paymentOption)>{{ $paymentOption }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group room_type">
                                    <label for="room_type">Room Type:</label>
                                    <select name="room_type" id="room_type" class="form-cb">
                                        <option value="8 persons" {{ $selectedUser->resident->room_type === '8 persons' ? 'selected' : '' }}>8 persons</option>
                                        <option value="4 persons" {{ $selectedUser->resident->room_type === '4 persons' ? 'selected' : '' }}>4 persons</option>
                                        <option value="3 persons" {{ $selectedUser->resident->room_type === '3 persons' ? 'selected' : '' }}>3 persons</option>
                                        <option value="2 persons" {{ $selectedUser->resident->room_type === '2 persons' ? 'selected' : '' }}>2 persons</option>
                                        <option value="1 person" {{ $selectedUser->resident->room_type === '1 person' ? 'selected' : '' }}>1 person</option>
                                    </select>
                                </div>
                            </div>
                            <div class="checkin-checkout">
                                <div class="form-group check_in_date">
                                    <label for="check_in_date">Check In:</label>
                                    <input type="date" id="check_in_date" name="check_in_date" class="form-input" value="{{ $selectedUser->resident->check_in_date?->format('Y-m-d') }}">
                                </div>
                                <div class="form-group check_out_date">
                                    <label for="check_out_date">Check Out:</label>
                                    <input type="date" id="check_out_date" name="check_out_date" class="form-input" value="{{ $selectedUser->resident->check_out_date?->format('Y-m-d') }}">
                                </div>
                            </div>
                        @endif
                        <div class="form-buttons">
                            <button type="submit" class="btn-primary">Save Changes</button>
                            <button type="reset" class="btn-primary">Restore</button>
                            <a href="{{ route('users.index', ['view' => request('view')]) }}" class="btn-primary">Close</a>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        {{-- confirmation / error receipt --}}
        @if(session('success'))
            <div class="modal">
                <div class="card user-modal receipt-modal">
                    <h2 class="modal-title">USER RECEIPT</h2>
                    <p style="text-align:center;">{{ session('success') }}</p>
                    @if(session('receipt'))
                        <div class="receipt-box">
                            <p><strong>Action: </strong>{{ session('receipt.action') }}</p>
                            <hr>
                            <p><strong>Last Name: </strong>{{ session('receipt.last_name') }}</p>
                            <p><strong>First Name: </strong>{{ session('receipt.first_name') }}</p>
                            <p><strong>Middle Name: </strong>{{ session('receipt.middle_name') }}</p>
                            <p><strong>Nickname: </strong>{{ session('receipt.nickname') }}</p>
                            <p><strong>Birthdate: </strong>{{ session('receipt.birthdate') }}</p>
                            <p><strong>Phone Number: </strong>{{ session('receipt.phone_number') }}</p>
                            <p><strong>Address: </strong>{{ session('receipt.address') }}</p>
                            <p><strong>Email: </strong>{{ session('receipt.email') }}</p>
                            <p><strong>User Type: </strong>{{ session('receipt.user_type') }}</p>
                            <p><strong>Status: </strong>{{ session('receipt.status') }}</p>
                            <p><strong>Password Updated: </strong>{{ session('receipt.password_updated') ? 'Yes' : 'No' }}</p>
                            <hr>
                            @if(session('receipt.resident_type'))
                                <h3>Resident Information</h3>
                                <p><strong>Accommodation Type: </strong>{{ session('receipt.accommodation_type') }}</p>
                                <p><strong>Resident Type: </strong>{{ session('receipt.resident_type') }}</p>
                                <p><strong>Payment Schedule: </strong>{{ session('receipt.payment_schedule') }}</p>
                                <p><strong>Room Type: </strong>{{ session('receipt.room_type') }}</p>
                                <p><strong>Check In Date: </strong>{{ session('receipt.check_in_date') }}</p>
                                <p><strong>Check Out Date: </strong>{{ session('receipt.check_out_date') ?? 'N/A' }}</p>
                            @endif
                        </div>
                    @endif
                    <div class="form-buttons">
                        <button class="btn-primary" onclick="this.closest('.modal').remove()">OK</button>
                    </div>
                </div>
            </div>
        @endif
    </section>
</x-layout>