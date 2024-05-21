<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
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
            width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
            font-size: 24px;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
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
            background-color: #432188;
        }
        .login-link {
            text-align: center;
            margin-top: 16px;
        }
        .login-link a {
            color: #007bff;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
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
    <h2>User Registration</h2>
    <div class="errors">
        <?= session()->getFlashdata('errors') ? implode('<br>', session()->getFlashdata('errors')) : ''; ?>
        <?= session()->getFlashdata('error'); ?>
        <?= session()->getFlashdata('success'); ?>
    </div>
    <form method="post" action="<?= site_url('register/process') ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= old('name') ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= old('email') ?>" required>

        <div class="tooltip">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <span class="tooltiptext">
                <p>Password must be at least 5 characters long</p>
                <p>Include numbers</p>
                <p>Have a special character like !@#?</p>
            </span>
        </div>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required>

        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact" value="<?= old('contact') ?>" required>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" value="<?= old('age') ?>" required>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="">Select Role</option>
            <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="bidder" <?= old('role') == 'bidder' ? 'selected' : '' ?>>Bidder</option>
            <option value="seller" <?= old('role') == 'seller' ? 'selected' : '' ?>>Seller</option>
            <option value="auctioneer" <?= old('role') == 'auctioneer' ? 'selected' : '' ?>>Auctioneer</option>
        </select>

        <button type="submit">Register</button>
    </form>
    <div class="login-link">
        Already have an account? <a href="<?= site_url('login') ?>">Login</a>
    </div>
</div>
</body>
</html>