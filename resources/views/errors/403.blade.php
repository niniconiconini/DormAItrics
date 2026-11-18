<!DOCTYPE html>
<html>
<head>
    <title>403 Forbidden</title>
</head>
<body style="font-family: Montserrat, sans-serif; display:flex; justify-content:center; align-items:center; min-height:100vh;">
    <div style="text-align:center;">
        <h1>403</h1>
        <p>This action is unauthorized.</p>

        <a href="{{ auth()->check() ? route('home') : route('login') }}"
           style="display:inline-block; margin-top:20px; padding:10px 20px; background:#06362d; color:#dee2b1; text-decoration:none; border-radius:5px;">
            Back to dormAItrics
        </a>
    </div>
</body>
</html>