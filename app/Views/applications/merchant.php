<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merchant Application</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body, h1, p, ul, li, a, button, img, input, textarea, label {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            padding: 10px 20px;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .logo span {
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .login {
            position: relative;
        }

        .login a, .login .profile-icon {
            color: white;
            font-size: 24px;
            cursor: pointer;
            margin-left: 20px;
        }

        .login .dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background-color: #a19999;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(138, 135, 135, 0.1);
            overflow: hidden;
            z-index: 1;
        }

        .login .dropdown a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }

        .login .dropdown a:hover {
            background-color: #575757;
        }

        .content {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }

        .guidelines {
            flex: 1;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-right: 20px;
        }

        .form-container {
            flex: 1;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 20px;
        }

        ul {
            list-style-type: disc;
            margin-left: 20px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #9560d7;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #432188;
        }
    </style>
</head>
<body>
<nav>
    <div class="logo">
        <img src="<?= base_url('images/BidBox.jpg') ?>" alt="BidBox Logo">
        <span>BidBox</span>
    </div>

    <div class="login">
        <a href="<?= site_url('/') ?>" class="home-icon">
            <i class="fas fa-home"></i>
        </a>
        <i class="fas fa-user-circle profile-icon" onclick="toggleDropdown()"></i>
        <div class="dropdown" id="dropdownMenu">
            <a href="<?= site_url('login') ?>">Login</a>
            <a href="<?= site_url('register') ?>">Register</a>

        </div>
    </div>
</nav>
<div class="content">
    <div class="guidelines">
        <h1>Becoming a Merchant</h1>
        <p>Minimum guidelines for being a merchant in our system:</p>
        <ul>
            <li>The goods should be luxury items</li>
            <li>Goods sold must have authentication</li>
            <li>Must be 18yrs and older</li>
            <li>The luxury goods should be in pristine condition</li>
        </ul>
        <p>Documents are to be uploaded as a single pdf file:</p>
        <br>
        <p>Documents to be uploaded include:</p>
        <ul>
            <li>Copy of your Identification card</li>
            <li>Authentication documents for the brand of goods sold</li>
            <li>Certificate of good conduct</li>
            <li>List of referees with their contact information</li>
        </ul>
    </div>
    <div class="form-container">
        <?php if (session()->getFlashdata('error')): ?>
            <p><?= session()->getFlashdata('error') ?></p>
        <?php endif; ?>

        <form action="<?= site_url('application/submit') ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="type" value="merchant">
            <label for="applicant_name">Name:</label>
            <input type="text" id="applicant_name" name="applicant_name" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="message">Why do you want to join:</label>
            <textarea id="message" name="message" required></textarea><br>

            <label for="documents">Related documents:</label>
            <input type="file" id="documents" name="documents" required><br>

            <button type="submit">Submit</button>
        </form>
    </div>
</div>

<script>
    function toggleDropdown() {
        var dropdownMenu = document.getElementById('dropdownMenu');
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    }
</script>

</body>
</html>
