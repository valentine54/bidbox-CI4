<!-- app/Views/reset_link_sent.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Link Sent</title>
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

        .reset-link-sent {
            text-align: center;
            padding: 20px;
            border-radius: 8px;
            background-color: #9560d7;
            color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .reset-link-sent h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .reset-link-sent p {
            font-size: 16px;
        }
    </style>
</head>
<body>
<div class="reset-link-sent">
    <h1>Password Reset Link Sent</h1>
    <p>Please check your email at <strong><?= esc($email) ?></strong> for the password reset link.</p>
</div>
</body>
</html>

