<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Registration</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <?php
    session_start();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    ?>
    <div class="auth-container">
        <h2>Register</h2>
        <form id="register-form" method="POST" action="">
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
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <button type="submit" style="padding: 8px; background-color: blue; border: none; border-radius: 4px; color: #fff; cursor: pointer; font-size: 14px;">Register</button>
            <div id="register-error" class="error-message" style="color: red; margin-top: 10px;"></div>
            <div id="register-success" class="success-message" style="color: green; margin-top: 10px;"></div>
        </form>
        <p>Already have an account? <a href="loginform.php">Login here</a></p>
    </div>
    <script>
        $(document).ready(function () {
            $('#register-form').on('submit', function (e) {
                e.preventDefault();

                let username = $('#username').val().trim();
                let password = $('#password').val().trim();
                let csrfToken = $('input[name="csrf_token"]').val();
                let errorMessage = $('#register-error');
                let successMessage = $('#register-success');

                errorMessage.text('');
                successMessage.text('');

                if (username === '' || password === '') {
                    errorMessage.text('Please fill in all fields.');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: 'register.php',
                    data: { username: username, password: password, csrf_token: csrfToken },
                    success: function (response) {
                        if (response === 'success') {
                            successMessage.text('Registration successful. Please log in.');
                            setTimeout(() => {
                                window.location.href = 'login.html';
                            }, 2000);
                        } else {
                            errorMessage.text(response);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        errorMessage.text('An error occurred: ' + textStatus + ' ' + errorThrown);
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
