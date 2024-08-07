<?php
// Start session (if not already started)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fetch user details (adjust this based on your actual implementation)
$user = $this->fetchUserDetails();
?>

<div class="sidebar">
    <!-- Profile Image and Edit Link -->
    <div class="profile">
        <img src="<?= base_url($user['profile_image'] ?: 'uploads/defaultBidder.jpeg'); ?>" alt="Profile Image">
        <a href="#" id="editProfileLink"><i class="fas fa-user"></i> Edit</a>
    </div>

    <!-- Sidebar Navigation Links -->
    <a href="<?= site_url('home/index/'.$user['id']); ?>">
        <i class="fas fa-home"></i> Home
    </a>
    <a href="<?= site_url('bids/yourBids/'.$user['id']); ?>">
        <i class="fas fa-gavel"></i> Your Bids
    </a>
    <a href="<?= site_url('approved_bids/index/'.$user['id']); ?>">
        <i class="fas fa-check-circle"></i> Approved Bids
    </a>
    <a href="<?= site_url('categories/index/'.$user['id']); ?>">
        <i class="fas fa-list"></i> Categories
    </a>
    <a href="<?= site_url('cart/index/'.$user['id']); ?>">
        <i class="fas fa-shopping-cart"></i> Cart <span class="cart-count"><?= $cartCount ?></span>
    </a>
    <a href="<?= site_url('contact/index/'.$user['id']); ?>">
        <i class="fas fa-phone"></i> Contact
    </a>
</div>

<!-- Edit Profile Form -->
<div id="editProfileForm" style="display: none;">
    <div class="main-content">
        <div class="container my-5">
            <h2>Edit Profile</h2>
            <form method="POST" action="<?= site_url('seller/updateProfile') ?>" enctype="multipart/form-data">
                <input type="hidden" name="seller_id" value="<?= isset($seller['seller_id']) ? $seller['seller_id'] : ''; ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= isset($seller['name']) ? htmlspecialchars($seller['name']) : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= isset($seller['email']) ? htmlspecialchars($seller['email']) : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password">
                </div>
                <div class="mb-3">
                    <label for="contact" class="form-label">Contact</label>
                    <input type="text" class="form-control" id="contact" name="contact" value="<?= isset($seller['contact']) ? htmlspecialchars($seller['contact']) : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="profile_image" class="form-label">Profile Image</label>
                    <input type="file" class="form-control" id="profile_image" name="profile_image">
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
                <button type="button" class="btn btn-secondary" id="backButton">Back</button>
            </form>
        </div>
    </div>
</div>

<style>
.sidebar {
    height: 100vh;
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #343a40;
    padding-top: 20px;
}

.sidebar .profile {
    text-align: center;
    margin-bottom: 20px;
}

.sidebar .profile img {
    width: 120px; /* Adjust size as needed */
    height: 120px; /* Adjust size as needed */
    border-radius: 50%; /* Rounded profile image */
    object-fit: cover;
    object-position: center;
    border: 2px solid #fff; /* Optional: Add border */
}

.sidebar a {
    padding: 10px 15px;
    text-align: left;
    display: block;
    color: white;
    text-decoration: none;
}

.sidebar a:hover {
    background-color: #575d63;
}

.sidebar .logout-btn {
    position: absolute;
    bottom: 20px;
    width: 100%;
}

.main-content {
    margin-left: 260px;
    padding: 20px;
}

#editProfileForm {
    position: fixed; /* Position the form fixed on the screen */
    top: 50%; /* Center vertically */
    left: 50%; /* Center horizontally */
    transform: translate(-50%, -50%); /* Adjust to center */
    z-index: 100; /* Ensure form is in front of the sidebar */
    background-color: white; /* Optional: add background color */
    padding: 20px; /* Optional: add padding */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Optional: add shadow */
    border-radius: 10px; /* Optional: add rounded corners */
    width: 80%; /* Adjust width as needed */
    max-width: 500px; /* Set maximum width */
}

/* Adjust form controls within the form if necessary */
#editProfileForm form {
    max-width: 100%; /* Ensure form fills the container */
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('editProfileLink').addEventListener('click', function(event) {
        event.preventDefault();
        var editProfileForm = document.getElementById('editProfileForm');
        editProfileForm.style.display = 'block';
    });

    document.getElementById('backButton').addEventListener('click', function() {
        var editProfileForm = document.getElementById('editProfileForm');
        editProfileForm.style.display = 'none';
    });
});
</script>
