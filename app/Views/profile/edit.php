<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <title>Edit Profile</title>
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
        .content {
            display: flex;
            flex-direction: column;
            align-items: center; /* Center horizontally */
            margin: 10px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }


        button:hover {
            background-color: #432188;
        }

        .errors {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            width: 100%;
            max-width: 400px; /* Adjust form width */
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

        .sidebar {
            width: 200px;
            background-color: #333;
            color: white;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 15px;
            display: block;
        }
        .sidebar a:hover {
            background-color: #575757;
        }
        .sidebar .profile {
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar .profile img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <?php include('profile_sidebar.php'); ?>
</div>
<div class="content">
    <h2>Edit Profile</h2>
    <?php
    $userId = session()->get('user')['id'];
    $userName = session()->get('user')['Name'];
    ?>
    <div class="errors">
        <?= session()->getFlashdata('validation') ? implode('<br>', session()->getFlashdata('validation')->getErrors()) : ''; ?>
        <?= session()->getFlashdata('error'); ?>
        <?= session()->getFlashdata('success'); ?>
    </div>

    <form method="post" action="<?= site_url('profile/update') ?>" enctype="multipart/form-data">
        <label for="Name">Name:</label>
        <input type="text" id="Name" name="Name" value="<?= isset($user['Name']) ? $user['Name'] : '' ?>" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= isset($user['email']) ? $user['email'] : '' ?>" required>
        <br>
        <label for="contact">Contact:</label>
        <br>
        <input type="tel" name="contact" id="contact" value="<?= isset($user['contact']) ? $user['contact'] : '' ?>" required>
        <br>
        <label for="profile_picture">Profile Picture:</label>
        <input type="file" id="profile_picture" name="profile_picture" accept=".jpg,.jpeg,.png">
        <br>

        <button type="submit">Update Profile</button>
    </form>

</div>
<script>
    $(document).ready(function() {
        var input = document.querySelector("#contact");
        var iti = window.intlTelInput(input, {
            initialCountry: "auto",
            geoIpLookup: function(callback) {
                $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "us";
                    callback(countryCode);
                });
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"
        });

        function setMask() {
            var countryData = iti.getSelectedCountryData();
            var dialCode = countryData.dialCode;
            var exampleNumber = iti.getNumberPlaceholder().replace(/[0-9]/g, '9');
            var phoneNumberLength = exampleNumber.length;

            $('#contact').inputmask('remove');
            $('#contact').inputmask({
                mask: exampleNumber,
                placeholder: "",
                clearMaskOnLostFocus: true
            });
        }

        input.addEventListener('countrychange', function() {
            input.value = "+" + iti.getSelectedCountryData().dialCode;
            setMask();
        });

        input.value = "+" + iti.getSelectedCountryData().dialCode;
        setMask();
    });
</script>
</body>
</html>
