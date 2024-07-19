<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: left;
        }

        .login-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-container label {
            display: inline-block;
            width: 100px; /* Fixed width for labels */
            vertical-align: middle;
        }

        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 250px; /* Adjust width based on label width */
            padding: 10px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #995fd5;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: #432188;
        }

        .error {
            color: red;
            margin-bottom: 16px;
        }

        .login-container .remember-me {
            display: flex;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .login-container .remember-me input {
            margin-right: 5px;
        }
        .login-container .remember-me label{
            text-align: left;
        }

        .login-container .register-link {
            text-align: center;
            margin-top: 10px;
        }
        .login-container .forgot-password-link {
            text-align: center;
            margin-top: 10px;
        }

        /* Password input hover effect */
        #password:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        /* Tooltip styling */
        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 220px;
            background-color: #555;
            color: #fff;
            text-align: left; /* Align text to the left */
            border-radius: 6px;
            padding: 5px 10px; /* Add some padding */
            position: absolute;
            z-index: 1;
            bottom: 125%; /* Position the tooltip above the text */
            left: 50%;
            margin-left: -110px; /* Center the tooltip */
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%; /* Arrow at the bottom of the tooltip */
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h1>Login</h1>
    <?php if(session()->getFlashdata('error')): ?>
        <p class="error"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <form action="<?= base_url('login/authenticate') ?>" method="post">
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="tooltip">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>



            <span class="tooltiptext">
                <p>Password must be at least 5 characters long</p>
                <p>Include numbers</p>
                <p>Have a special character like !@#?</p>
            </span>
        </div>
        <div class="remember-me">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">RememberMe</label>
        </div>
        <button type="submit">Login</button>
    </form>
    <div class="register-link">
        <a href="<?= base_url('register') ?>">Don't have an account? Register</a>
    </div>
    <div class="forgot-password-link">
        <a href="<?= base_url('forgot-password') ?>">Forgot your password?</a>
    </div>
</div>
</body>
</html>
