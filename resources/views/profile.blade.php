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
                                    <label for="birthdate">Birthdate:</label>
                                    <input type="date" id="birthdate" name="birthdate" class="form-input" value="{{ $user->birthdate?->format('Y-m-d') }}">
                                </div>
                                <div class="form-group birthdate">
                                        <label for="gender">Gender*:</label>
                                        <select id="gender" name="gender" class="form-cb" @disabled(!$isAdmin && !$isManager)>
                                            <option value="" selected disabled hidden></option>
                                            <option value="Female" {{ $user->gender === 'Female' ? 'selected' : ''}}>Female</option>
                                            <option value="Male" {{ $user->gender === 'Male' ? 'selected' : '' }}>Male</option>
                                        </select>
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
                            </div>
                            <div class="form-group resident_type">
                                <label for="resident_type">Resident Type*:</label>
                                <select name="resident_type" id="resident_type" class="form-cb" @disabled(!$isAdmin && !$isManager)>
                                    <option value="Student" {{ $user->resident->resident_type === 'Student' ? 'selected' : '' }} @disabled(!$isAdmin && !$isManager)>Student</option>
                                    <option value="Employee" {{ $user->resident->resident_type === 'Employee' ? 'selected' : '' }} @disabled(!$isAdmin && !$isManager)>Employee</option>
                                </select>
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
                            </div>
                        </div>
                        <div class="checkin-checkout">
                            <div class="form-group check_in_date">
                                <label for="check_in_date">Check In*:</label>
                                <input type="date" id="check_in_date" name="check_in_date" class="form-input" value="{{ $user->resident->check_in_date?->format('Y-m-d') }}" @disabled(!$isAdmin && !$isManager)>
                            </div>
                            <div class="form-group check_out_date">
                                <label for="check_out_date">Check Out*:</label>
                                <input type="date" id="check_out_date" name="check_out_date" class="form-input" value="{{ $user->resident->check_out_date?->format('Y-m-d') }}" @disabled(!$isAdmin && !$isManager)>
                            </div>
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
</x-layout>