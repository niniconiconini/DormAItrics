<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            background: url('{{ asset('images/bg.png') }}') no-repeat fixed center;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .overlay {
            position: fixed;
            inset: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(113, 121, 119, 0.7);
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
        
        #login-form .form-input {
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
            width: min(850px, 94vw) !important;
            max-width: 94vw;
            padding: 2.5rem !important;
        }

        .confirmation-modal .modal-title {
            margin-bottom: 1.5rem;
            font-size: clamp(1.6rem, 2.5vw, 2rem);
        }

        .confirmation-modal p {
            font-size: clamp(1.05rem, 1.5vw, 1.25rem);
            line-height: 1.8;
        }

        .confirmation-modal button {
            padding: 0.85rem 1.2rem;
            font-size: 1.05rem;
        }

        @media (max-width: 600px) {
            .confirmation-modal {
                padding: 1.5rem !important;
            }
        }
        
        /* show password design */
        #login-form .password-field {
            position: relative;
            width: 100%;
        }

        #login-form .password-field .form-input {
            padding-right: 4.5rem;
        }

        #login-form .password-toggle {
            position: absolute;
            top: 50%;
            right: 0.75rem;
            transform: translateY(-50%);
            border: 0;
            padding: 0;
            background: transparent;
            color: var(--primary-color);
            cursor: pointer;
            font-size: clamp(0.75rem, 0.8vw, 0.95rem);
            font-weight: 600;
        }

        #login-form .password-toggle:focus-visible {
            outline: 2px solid var(--secondary-color);
            outline-offset: 3px;
        }    

        #login-form .login-lockout-message {
            width: 100%;
            margin-bottom: 1rem;
            padding: 0.75rem;
            border-radius: 0.5rem;
            background: #f8d7da;
            color: #842029;
            text-align: center;
            font-size: clamp(0.8rem, 1vw, 1rem);
        }   

        .login-error-message {
            white-space: pre-line;
        } 
        
    </style>
</head>
<body>
    <div class="overlay">
        <section id="login-form" class="form-section container">
            <header id="page-title">Login!</header>
            @if ($lockoutNotice)
                <p class="login-lockout-message" role="alert">{{ $lockoutNotice }}</p>
            @endif
            <form method="POST" action="{{ route('login.attempt') }}" class="form-container">
                @csrf
                <div class="form-group">
                    <label for="email">Email:</label>
            <input type="email" name="email" id="email" required class="form-input" value="{{ old('email', $lockedOutEmail) }}">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <div class="password-field">
                        <input type="password" id="password" name="password" required class="form-input" autocomplete="current-password">
                        <button type="button" id="togglePassword" class="password-toggle" aria-controls="password" aria-pressed="false">Show</button>
                    </div>
                    <a href="?modal=forgot">Forgot Password?</a>
                </div>
                <div style="text-align: center;">
                    <button type="submit" class="btn-primary">Login</button>
                </div>
                <p style="padding-top: 1rem; text-align: center;">Don't have an account? <a href="{{ route('apply') }}">Sign Up</a></p>
            </form>

            @if(request('modal') === 'forgot')
                <div class="modal">
                    <div class="card user-modal receipt-modal confirmation-modal" style="text-align: center;">
                        <h2 class="modal-title">Forgot Password?</h2>
                        <div class="receipt-box" style="padding: 1rem;">
                            <p style="padding: 0.5rem;">Please contact the dormitory administrator to reset your password.</p>
                        </div>
                        <div class="form-buttons">
                            <button type="button" class="btn-primary" onclick="window.location='{{ route('login') }}'">OK</button>
                        </div>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="modal">
                    <div class="card user-modal receipt-modal confirmation-modal" style="text-align: center;">
                        <h2 class="modal-title">ERROR</h2>
                        <div class="receipt-box" style="padding: 1rem;">
                            @foreach($errors->all() as $error)
                                <p class="login-error-message" style="padding: 0.5rem;">{{ $error }}</p>
                            @endforeach
                        </div>
                        <div class="form-buttons">
                            <button type="button" class="btn-primary" onclick="this.closest('.modal').remove()">OK</button>
                        </div>
                    </div>
                </div>
            @endif
        </section>
    </div>
    <script>
        const passwordInput = document.getElementById('password');
        const togglePasswordButton = document.getElementById('togglePassword');

        if (passwordInput && togglePasswordButton) {
            togglePasswordButton.addEventListener('click', () => {
                const shouldShowPassword = passwordInput.type === 'password';
                passwordInput.type = shouldShowPassword ? 'text' : 'password';

                togglePasswordButton.textContent = shouldShowPassword ? 'Hide' : 'Show';
                togglePasswordButton.setAttribute('aria-pressed', String(shouldShowPassword));
            });
        }
    </script>
</body>
</html>