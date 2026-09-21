<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
        
        #login-form {
            background-color: var(--body-color);
            border-radius: 10px;
            box-shadow: 20px 20px 50px var(--primary-color);
            padding: 1.5vh 3vw;
            display: flex;
            flex-direction: column;
            margin: 5vh auto;
        }

        #login-form .form-group {
            margin-bottom: 1vw;
            display: flex;
            flex-direction: column;
            gap: 0.2vw;
        }

        #login-form .form-group label {
            font-weight: bold;
            font-size: 1vw;
            color: var(--text-color);
        }
        
        #login-form .form-input, .form-cb {
            height: 5vh;
            font-size: 1vw;
            border: 1px solid #ccc;
            border-radius: 0.5vw;
            width: 100%;
            padding: 0 0.5vw;
        }

        #login-form .btn-primary {
            background-color: var(--primary-color);
            color: var(--body-color);
            padding: 1vh 2vw;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 1vw;
            transition: background-color 0.3s;
        }

        #login-form .btn-primary:hover {
            background-color: var(--secondary-color);
            color: var(--primary-color);
        }

        #link p {
            font-size: 1.8vh;
            text-align: center;
            margin-top: 1vh;
        }
        
        a {
            color: var(--secondary-color);
        }

        a:hover {
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <section id="login-form" class="form-section container">
        <header id="page-title">Login!</header>
        @if ($errors->any())
        <div>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form method="POST" action="{{ route('login.attempt') }}" class="form-container">
            @csrf
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="email" name="email" id="username" placeholder="" required class="form-input">
            </div>
            <div class="form-group">
                <label for="address">Password:</label>
                <input type="password" id="password" name="password" placeholder="" required class="form-input">
                <a href="#">Forgot Password?</a>
            </div>
            <div style="text-align: center;">
                <button type="submit" class="btn-primary">Login</button>
            </div>
            <div id="link">
                <p>No account yet? <a href="{{ route('Registration') }}">Become a Dormer Now</a>!</p>
            </div>
        </form>
    </section>
</body>
</html>