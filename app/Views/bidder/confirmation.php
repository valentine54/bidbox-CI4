<div class="sidebar">
    <div class="profile">
        <img src="<?= base_url($user['profile_image'] ?: 'uploads/defaultBidder.jpeg'); ?>" alt="Profile Image">
        <a href="#" id="editProfileLink"><i class="fas fa-user"></i> Edit</a>
    </div>

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
