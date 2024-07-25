<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Login</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="auth-container">
        <h2>Login</h2>
        <form id="login-form">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <div class="password-container" style="position: relative; display: flex; align-items: center;">
                    <input type="password" id="password" name="password" required style="padding-right: 30px; width: 100%;">
                    <i class="fa fa-eye" id="togglePassword" style="cursor: pointer; position: absolute; right: 10px; color: #888;"></i>
                </div>
            </div>
            <button type="submit" style="padding: 8px; background-color: blue; border: none; border-radius: 4px; color: #fff; cursor: pointer; font-size: 14px;">Login</button>
            <div id="login-error" class="error-message" style="color: red; margin-top: 10px;"></div>
        </form>
        <p>Don't have an account? <a href="registerform.php">Register here</a></p>
    </div>
    <script>
        $(document).ready(function () {
            $('#login-form').on('submit', function (e) {
                e.preventDefault();

                let username = $('#username').val().trim();
                let password = $('#password').val().trim();
                let errorMessage = $('#login-error');

                errorMessage.text('');

                if (username === '' || password === '') {
                    errorMessage.text('Please fill in all fields.');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: 'login.php',
                    data: { username: username, password: password },
                    success: function (response) {
                        if (response === 'success') {
                            window.location.href = 'portal.php';
                        } else {
                            errorMessage.text(response);
                        }
                    }
                });
            });

            $('#togglePassword').on('click', function () {
                let passwordField = $('#password');
                let passwordFieldType = passwordField.attr('type');

                if (passwordFieldType === 'password') {
                    passwordField.attr('type', 'text');
                    $(this).removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });

    </script>
</body>

</html>
