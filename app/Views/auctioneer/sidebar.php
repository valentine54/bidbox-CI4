<?php
$user = session()->get('user');
$userName = $user['Name'];
$profilePicture = base_url($user['profile_picture']); // Ensure this path is relative to 'public' directory
?>

<div class="sidebar">
    <div>
        <div class="profile">
            <img src="<?= $profilePicture ?>" alt="Profile Picture">
            <h3>Welcome, <?= $userName ?></h3>
        </div>
        <a href="<?= site_url('auctioneer/view-sellers') ?>"><i class="fas fa-users"></i> View Sellers</a>
        <a href="<?= site_url('auctioneer/view-bidders') ?>"><i class="fa fa-user-circle" aria-hidden="true"></i> View Bidders</a>
        <a href="<?= site_url('auctioneer/view-bids') ?>"><i class="fas fa-gavel"></i> View Bids</a>
        <a href="<?= site_url('auctioneer/manage-bids') ?>"><i class="fas fa-tasks"></i> Manage Bids</a>
        <a href="<?= site_url('profile/edit') ?>"><i class="fas fa-user-edit"></i> Edit Profile</a>
    </div>
    <div>
        <a href="<?= site_url('dashboard/logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>


