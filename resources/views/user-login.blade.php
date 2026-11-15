<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
        
        #login-form {
            background-color: var(--body-color);
            border-radius: 10px;
            box-shadow: 20px 20px 50px var(--primary-color);
            padding: 1.5vh 3vw;
            display: flex;
            flex-direction: column;
            margin: 5vh auto;
            width: 30%;
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

        .modal {
            position: fixed !important;
            inset: 0;
            display: flex !important;
            justify-content: center;
            align-items: center;
            background: rgba(113, 121, 119, 0.7);
            z-index: 1000;
        }

        .user-modal {
            background-color: var(--body-color) !important;
            width: min(1300px, 95vw);
            padding: 1rem 3rem 2rem 3rem;
            border-radius: 10px;
            box-shadow: 20px 20px 50px var(--primary-color);
            max-height: 95vh;
            overflow-y: auto;
        }

        .receipt-modal {
            width: min(700px, 90vw) !important;
            padding: 1.5rem !important;
        }

    </style>
</head>
<body>
    <section id="login-form" class="form-section container">
        <header id="page-title">Login!</header>
        <form method="POST" action="{{ route('login.attempt') }}" class="form-container">
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
        <input type="email" name="email" id="email" placeholder="" required class="form-input" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label for="address">Password:</label>
                <input type="password" id="password" name="password" placeholder="" required class="form-input">
                <a href="#">Forgot Password?</a>
            </div>
            <div style="text-align: center;">
                <button type="submit" class="btn-primary">Login</button>
            </div>
        </form>

        @if($errors->any())
            <div class="modal">
                <div class="card user-modal receipt-modal" style="text-align: center;">
                    <h2 class="modal-title">ERROR</h2>
                    <div class="receipt-box" style="padding: 1rem;">
                        @foreach($errors->all() as $error)
                            <p style="padding: 0.5rem;">{{ $error }}</p>
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