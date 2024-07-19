<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        label {
            margin-bottom: 6px;
            font-weight: bold;
        }
        input, select {
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
        }
        button {
            padding: 10px 20px;
            background-color: #9560d7;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #7e3fd7;
        }
        .error {
            color: red;
            margin-top: 5px;
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
            text-align: left;
            border-radius: 6px;
            padding: 5px 10px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -110px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
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
<div class="container">
    <h2>Reset Password</h2>
    <?php if (session()->has('error')) : ?>
        <div class="error"><?= session('error') ?></div>
    <?php endif; ?>
    <form action="<?= base_url('reset-password/update') ?>" method="post">
        <input type="hidden" name="token" value="<?= esc($token) ?>">
        <input type="hidden" name="email" value="<?= esc($email) ?>">
        <div class="tooltip">
            <label for="password">New Password</label>
            <input type="password" id="password" name="password" required>
            <span class="tooltiptext">
                <p>Password must be at least 5 characters long</p>
                <p>Include numbers</p>
                <p>Have a special character like !@#?</p>
            </span>
        </div>
        <div class="tooltip">
            <label for="confirm_password">Confirm New Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit">Reset Password</button>
    </form>
</div>
</body>
</html>
