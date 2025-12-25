<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Success</title>
</head>
<body>
    <script>
        // Save JWT token to localStorage only
        const token = '{{ $token }}';
        const redirect = '{{ $redirect }}';

        if (token && token.trim() !== '') {
            // Save token under unified key used across the app
            localStorage.setItem('auth_token', token);
            console.log('✓ Token saved to localStorage (auth_token)');

            // Redirect immediately to dashboard
            window.location.href = redirect;
        } else {
            console.error('✗ No token received');
            window.location.href = '/login';
        }
    </script>
</body>
</html>
