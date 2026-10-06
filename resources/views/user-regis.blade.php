<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="shortcut icon" href="images/spumlogo.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            color: var(--primary-color);
        }
        
        body {
            background: var(--text-color) url('{{ asset('images/bg.png') }}') no-repeat fixed center;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        :root {
            --primary-color: #06362d;
            --secondary-color: #28a745;
            --body-color: #dee2b1;
            --text-color: #155332;
        }
        
        #page-title {
            font-size: 2vw;
            font-weight: 700;
            color: var(--text-color);
            padding: 1.5vh 0;
            text-align: center;
        }
        
        #registration-form {
            background-color: var(--body-color);
            border-radius: 10px;
            box-shadow: 20px 20px 50px var(--primary-color);
            padding: 1.5vh 3vw;
            display: flex;
            flex-direction: column;
            margin: 5vh auto;
        }

        #registration-form .form-group {
            margin-bottom: 1vw;
            display: flex;
            flex-direction: column;
            gap: 0.2vw;
        }

        #registration-form .form-group label {
            font-weight: bold;
            font-size: 1vw;
            color: var(--text-color);
        }

        #registration-form .fullname, .info, .contact, .login-details, .accommodation {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5vw;
        }
        
        #registration-form .lastname, .middlename {
            width: 25%;
        }

        #registration-form .firstname, .accommodation_type, .payment_schedule, .email, .password  {
            width: 50%;
        }

        #registration-form .nickname, .birthdate, .user_type, .cellphone {
            width: 33.33%;
        }

        #registration-form .address {
            width: 66.67%;
        }
        
        #registration-form .form-input, .form-cb {
            height: 5vh;
            font-size: 1vw;
            border: 1px solid #ccc;
            border-radius: 0.5vw;
            width: 100%;
            padding: 0 0.5vw;
        }

        #registration-form .btn-primary {
            background-color: var(--primary-color);
            color: var(--body-color);
            padding: 1vh 2vw;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 1vw;
            transition: background-color 0.3s;
        }

        #registration-form .btn-primary:hover {
            background-color: var(--secondary-color);
            color: var(--primary-color);
        }

        #link p {
            font-size: 1.8vh;
            text-align: center;
            margin-top: 1vh;
        }
        
        #link a {
            color: var(--secondary-color);
        }

        #link a:hover {
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <section id="registration-form" class="form-section container">
        <header id="page-title">Register to become a Dormer!</header>
        @if ($errors->any())
        <div>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form method="POST" action="{{ route('register') }}" class="form-container">
            @csrf
            <div class="fullname">
                <div class="form-group lastname">
                    <label for="lastname">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" required class="form-input">
                </div>
                <div class="form-group firstname">
                    <label for="firstname">First Name:</label>
                    <input type="text" id="firstname" name="firstname" required class="form-input">
                </div>
                <div class="form-group middlename">
                    <label for="middlename">Middle Name:</label>
                    <input type="text" id="middlename" name="middlename" class="form-input" placeholder="">
                </div>
            </div>
            <div class="info">
                <div class="form-group nickname">
                    <label for="nickname">Nickname:</label>
                    <input type="text" id="nickname" name="nickname" class="form-input">
                </div>
                <div class="form-group birthdate">
                    <label for="birthdate">Birth Date:</label>
                    <input type="date" id="birthdate" name="birthdate" required class="form-input">
                </div>
                <div class="form-group user_type">
                <label for="user_type">User Type:</label>
                <select id="user_type" name="user_type" required class="form-cb">
                    <option value="" selcted hidden></option>
                    <option value="Student">Student</option>
                    <option value="Employee">Employee</option>
                </select>
                </div>
            </div>
            <div class="contact">
                <div class="form-group address">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required class="form-input">
                </div>
                <div class="form-group cellphone">
                    <label for="cellphone">Cellphone Number:</label>
                    <input type="tel" id="cellphone" name="cellphone" required class="form-input">
                </div>
            </div>
            <div class="login-details">
                <div class="form-group email">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" required class="form-input">
                </div>
                <div class="form-group password">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required class="form-input">
                </div>
            </div>
            <div class="accommodation">
                <div class="form-group accommodation_type">
                    <label for="accommodation_type">Type of Accommodation:</label>
                    <select id="accommodation_type" name="accommodation_type" required class="form-cb">
                        <option value="" selcted hidden></option>
                        <p>St. Paul University Manila Campus</p>
                        <option value="8_in_room">8 in a room</option>
                        <option value="4_in_room">4 in a room</option>
                        <option value="3_in_room">3 in a room</option>
                        <option value="2_in_room">2 in a room</option>
                    </select>
                </div>
                <div class="form-group payment_schedule">
                    <label for="payment_schedule">Schedule of Payment:</label>
                    <select id="payment_schedule" name="payment_schedule" required class="form-cb">
                        <option value="" selcted hidden></option>
                        <option value="full_payment">Full Payment</option>
                        <option value="2_equal_payments">2 Equal Payments</option>
                        <option value="3_equal_payments">3 Equal Payments</option>
                        <option value="4_equal_payments">4 Equal Payments</option>
                    </select>
                </div>
            </div>
            <div style="text-align: center;">
                <button type="submit" class="btn-primary">Register</button>
            </div>
            <div id="link">
                <p>Already a Dormer? <a href="{{ route('login') }}">Sign in here</a>!</p>
            </div>
        </form>
    </section>
</body>
</html>