<!-- app/Views/activation_notice.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Activation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .activation-notice {
            text-align: center;
            padding: 20px;
            border-radius: 8px;
            background-color: #9560d7;
            color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .activation-notice h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .activation-notice p {
            font-size: 16px;
        }
    </style>
</head>
<body>
<div class="activation-notice">
    <h1>Account Activation</h1>
    <p>Thank you for registering! Please check your email at <strong><?= esc($email) ?></strong> to activate your account.</p>
</div>
</body>
</html>
