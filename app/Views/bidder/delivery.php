<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Delivery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="d-flex">
  <?php include 'sidebar.php'; ?>
  <div class="main-content">
    <div class="container my-5">
        <h2>Product Delivery</h2>
        <form method="POST" action="">
            <input type="hidden" name="bid_id" value="<?= $bid_id; ?>">
            <input type="hidden" name="amount" value="<?= $amount; ?>">
            <div class="mb-3">
                <label for="street_address" class="form-label">Street Address</label>
                <input type="text" class="form-control" id="street_address" name="street_address" required>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" required>
            </div>
            <div class="mb-3">
                <label for="zipcode" class="form-label">Zipcode</label>
                <input type="text" class="form-control" id="zipcode" name="zipcode" required>
            </div>
            <div class="mb-3">
                <label for="contact" class="form-label">Contact</label>
                <input type="text" class="form-control" id="contact" name="contact" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= isset($_SESSION['delivery']['phone']) ? htmlspecialchars($_SESSION['delivery']['phone']) : ''; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Proceed to Payment</button>
        </form>

        <!-- M-Pesa Payment Form -->
        <form id="paymentForm" class="form m-5">
            <div class="row">
                <div class="col-sm-5">
                    <img style="max-width: 80%" src="uploads/mpesalogo.png" alt="mpesa logo">
                </div>
                <div class="form-group col-sm-7 mb-4">
                    <label for="mpesa_phone">Enter phone to Pay</label>
                    <input type="number" id="mpesa_phone" class="form-control" value="<?= isset($_SESSION['delivery']['phone']) ? htmlspecialchars($_SESSION['delivery']['phone']) : ''; ?>">
                    <div id="phoneErr" class="text-danger"></div>
                </div>
                <button id="paynow" type="button" class="btn btn-lg btn-success">Pay Now</button>
            </div>
        </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('paynow').addEventListener('click', function() {
        var phoneInput = document.getElementById('mpesa_phone');
        var phoneErr = document.getElementById('phoneErr');

        // Ensure the phone number is 12 digits long
        if (phoneInput.value.length !== 12) {
            phoneErr.innerHTML = 'Phone number must be 12 digits';
            return;
        }

        // Clear any previous error messages
        phoneErr.innerHTML = '';

        // Convert the phone number to the international format
        var phoneNumber = phoneInput.value;
        if (phoneNumber.startsWith('0')) {
            phoneNumber = '254' + phoneNumber.slice(1);
        }

        // Prepare form data
        var formData = new FormData();
        formData.append('bid_id', '<?= htmlspecialchars($bid_id, ENT_QUOTES); ?>');
        formData.append('amount', '<?= htmlspecialchars($amount, ENT_QUOTES); ?>');
        formData.append('phone', phoneNumber);

        // Create and send XMLHttpRequest
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'api/stk.php', true);
        xhr.onload = function() {
            console.log('Response Text:', xhr.responseText);
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    console.log(response);
                    if (response.status === 'success') {
                        // Display success message to the user
                        alert(response.response.CustomerMessage);
                        // Redirect to confirmation page
                        window.location.href = 'confirmation.php?bid_id=<?= htmlspecialchars($bid_id, ENT_QUOTES); ?>';
                    } else {
                        // Display error message to the user
                        if (response.response.errorMessage) {
                            alert('Payment request failed: ' + response.response.errorMessage);
                        } else {
                            alert('Payment request failed. Please check your M-Pesa account balance.');
                        }
                        // Redirect to confirmation page to show the failed status
                        window.location.href = 'confirmation.php?bid_id=<?= htmlspecialchars($bid_id, ENT_QUOTES); ?>';
                    }
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                    console.error('Response Text:', xhr.responseText);
                }
            } else {
                // Handle HTTP errors
                console.error('Error:', xhr.statusText);
                alert('Payment request failed: ' + xhr.statusText);
            }
        };
        xhr.onerror = function() {
            // Network errors
            console.error('Request failed.');
            alert('Payment request failed. Please check your network connection.');
        };
        xhr.send(formData);
    });

    // Tooltip for the "Pay Now" button
    var payNowBtn = document.getElementById('paynow');
    payNowBtn.addEventListener('mouseover', function() {
        var tooltip = document.createElement('div');
        tooltip.className = 'tooltip';
        tooltip.innerHTML = 'Number must start with 2547xxxxxxxx';

        // Position tooltip relative to the button
        var rect = payNowBtn.getBoundingClientRect();
        tooltip.style.left = rect.left + 'px';
        tooltip.style.top = (rect.top - 30) + 'px'; // Adjust as needed for positioning
        document.body.appendChild(tooltip);

        // Remove tooltip on mouseout
        payNowBtn.addEventListener('mouseout', function() {
            document.body.removeChild(tooltip);
        });
    });
});
</script>
</body>
</html>
