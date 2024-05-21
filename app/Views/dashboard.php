<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        /* Basic styling for the lock screen */
        #lockScreen {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            text-align: center;
            padding-top: 20%;
            z-index: 1000; /* Ensure it's on top */
        }
        #content {
            display: block; /* Ensure it's visible by default */
        }

        /* Hide the content when the lock screen is shown */
        .lockScreen.active ~ #content {
            display: none;
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
            bottom: 150%; /* Position the tooltip above the text */
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

        .tooltip input:focus + .tooltiptext {
            visibility: visible;
            opacity: 1;
        }

        /* Logout button styling */
        .logout-button {
            position: fixed;
            bottom: 10px;
            left: 10px;
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .logout-button:hover {
            background-color: #d32f2f;
        }
    </style>
    <script>
        window.onload = function() {
            let timer;
            const lockScreen = document.getElementById('lockScreen');
            const content = document.getElementById('content');

            function resetTimer() {
                clearTimeout(timer);
                timer = setTimeout(showLockScreen, 1 * 60 * 1000); // 1 minute for testing, change to 2 minutes
            }

            function showLockScreen() {
                lockScreen.style.display = 'block';
                lockScreen.classList.add('active');
                content.style.display = 'none';
                document.getElementById('password').value = '';
            }

            function hideLockScreen() {
                lockScreen.style.display = 'none';
                lockScreen.classList.remove('active');
                content.style.display = 'block';
            }

            document.onmousemove = resetTimer;
            document.onkeydown = resetTimer;
            document.onmousedown = resetTimer;

            function unlockScreen() {
                const password = document.getElementById('password').value;
                fetch('/dashboard/unlock', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ password: password })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            hideLockScreen();
                        } else {
                            alert('Invalid password');
                        }
                    });
            }

            function logout() {
                fetch('/dashboard/logout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => {
                        if (response.ok) {
                            window.location.href = 'http://localhost:8080/login';
                        } else {
                            console.error('Failed to logout:', response.statusText);
                        }
                    })
                    .catch(error => {
                        console.error('Error during logout:', error);
                    });
            }


            // Attach unlock function to button
            document.getElementById('unlockButton').onclick = unlockScreen;

            // Attach logout function to button
            document.getElementById('logoutButton').onclick = logout;

            // Prevent back navigation
            if (window.history && window.history.pushState) {
                window.history.pushState(null, null, window.location.href);
                window.onpopstate = function() {
                    window.history.pushState(null, null, window.location.href);
                };
            }

            // Start the inactivity timer
            resetTimer();
        };
    </script>
</head>
<body>
<div id="lockScreen" class="lockScreen">
    <h1>Session Locked</h1>
    <p>Please enter your password to continue:</p>
    <div class="tooltip">
        <input type="password" id="password" name="password_field_123" autocomplete="off" />
        <span class="tooltiptext">
            <p>Password must be at least 5 characters long</p>
            <p>Include numbers</p>
            <p>Have a special character like !@#?</p>
        </span>
    </div>
    <button id="unlockButton">Unlock</button>
</div>

<div id="content">
    <h1>Welcome to our home page!</h1>
    <button id="logoutButton" class="logout-button" onclick="logout()">Logout</button>
    <!-- Rest of your dashboard content -->
</div>
</body>
</html>
