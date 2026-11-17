<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    @vite(['resources/css/main.css', 'resources/js/app.js']) {{-- css stylesheet --}}
</head>
<body style="background: url('{{ asset('images/bg.png') }}') no-repeat fixed center;">
    <section>
        <div class="modal">
            <div class="card user-modal">
                <h2 class="modal-title">Register to become an SPUM Resident!</h2>
                <form action="{{ route('users.applicant') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- PERSONAL INFORMATION --}}
                    <div class="user-top-section">
                        <div class="user-details">
                            <img src="images/users/user-profile.png" hidden>
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
                                    <label for="add-resident-birthdate">Birthdate*:</label>

                                    <div class="birthday-picker" data-birthday-picker>
                                        <input type="date" id="add-resident-birthdate" name="birthdate" class="form-input"
                                            value="{{ old('birthdate') }}" data-role="input">

                                        <button type="button" aria-label="Open birthday calendar" aria-expanded="false" data-role="toggle">
                                            <span aria-hidden="true">▦</span>
                                        </button>

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
                                        <input type="password" id="password" name="password" class="form-input">
                                    </div>
                                </div>
                            </div>
                            <div class="account">
                                <div class="form-group user_type">
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
                            <select name="accommodation_type" id="accommodation_type" class="form-cb">
                                <option value="" selected disabled hidden></option>
                                <option value="Resident" {{ old('accommodation_type') === 'Resident' ? 'selected' : '' }}>Resident</option>
                                <option value="Transient" {{ old('accommodation_type') === 'Transient' ? 'selected' : '' }}>Transient</option>
                            </select>
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
                            <select name="payment_schedule" id="payment_schedule" class="form-cb">
                                <option value="" selected disabled hidden></option>
                                <option value="Full Payment" {{ old('payment_schedule') == 'Full Payment' ? 'selected' : '' }}>Full Payment</option>
                                <option value="4 Payments" {{ old('payment_schedule') == '4 Payments' ? 'selected' : '' }}>4 Payments</option>
                                <option value="3 Payments" {{ old('payment_schedule') == '3 Payments' ? 'selected' : '' }}>3 Payments</option>
                                <option value="2 Payments" {{ old('payment_schedule') == '2 Payments' ? 'selected' : '' }}>2 Payments</option>
                                <option value="Monthly" {{ old('payment_schedule') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="Per Day" {{ old('payment_schedule') == 'Per Day' ? 'selected' : '' }}>Per Day (transients only)</option>
                            </select>
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
                    <div class="form-buttons">
                        <button type="submit" class="btn-primary">Apply</button>
                        <button type="reset" class="btn-primary">Clear</button>
                    </div>
                </form>
            </div>
        </div>
        @if(session('application_submitted'))
            <div class="modal">
                <div style="background-color: var(--body-color);" class="card receipt-modal">
                    <h2 class="modal-title">APPLICATION SUBMITTED!</h2>
                    <p style="text-align: center; padding-bottom: 1rem;">Your application has been submitted successfully.
                        <br>Please check your email for further updates.<br>
                    </p>
                    <div class="form-buttons">
                        <a href="{{ route('login') }}" class="btn-primary">
                            Proceed to Login
                        </a>
                    </div>
                </div>
            </div>
        @endif
        @if($errors->any())
            <div class="modal">
                <div class="card user-modal receipt-modal">
                    <h2 class="modal-title">ERROR</h2>
                    <div class="receipt-box">
                        @foreach($errors->all() as $error)
                            <p style="padding:0.5rem;">{{ $error }}</p>
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
</body>
</html>