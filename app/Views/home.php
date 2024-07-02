
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BidBox Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <style>

            /* Reset some default browser styles */
        body, h3, p, ul, li, a, button, img {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        nav {
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

        .icon-container {
            display: flex;
            align-items: center;
        }

        .icon-container .icon {
            position: relative;
            margin-left: 20px;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }

        .dropdown {
            display: none;
            position: absolute;
            background-color: white;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            right: 0;
            min-width: 200px;
            z-index: 1;
            border-radius: 4px;
        }

        .dropdown a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown a:hover {
            background-color: #f1f1f1;
        }

        .icon:hover .dropdown {
            display: block;
        }

        .category-nav {
            background-color: #444;
            padding: 10px 20px;
        }

        .category-nav ul {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .category-nav li {
            margin-right: 20px;
        }

        .category-nav a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 5px 10px;
        }

        .category-nav a.active, .category-nav a:hover {
            background-color: #575757;
            border-radius: 4px;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px;
        }

        .product-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 20px;
            padding: 20px;
            width: 300px;
            text-align: center;
        }

        .product-card img {
            max-width: 100%;
            border-radius: 8px 8px 0 0;
        }

        .product-card h3 {
            font-size: 22px;
            margin: 10px 0;
        }

        .product-card p {
            font-size: 16px;
            margin: 10px 0;
        }

        .product-card button {
            background-color: #9560d7;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .product-card button:hover {
            background-color: #432188;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="<?= base_url('images/BidBox.jpg') ?>" width="40" height="40" class="d-inline-block align-top" alt="BidBox Logo">
            BidBox
        </a>
        <div class="icon-container">
            <div class="icon">
                <i class="fas fa-user-circle profile-icon"></i>
                <div class="dropdown">
                    <a class="dropdown-item" href="<?= site_url('login') ?>">Login</a>
                    <a class="dropdown-item" href="<?= site_url('register') ?>">Register</a>
                </div>
            </div>
            <div class="icon">
                <i class="fas fa-briefcase application-icon"></i>
                <div class="dropdown">
                    <a class="dropdown-item" href="<?= site_url('merchant-application') ?>">Merchant Application</a>
                    <a class="dropdown-item" href="<?= site_url('auctioneer-application') ?>">Auctioneers Application</a>
                </div>
            </div>
        </div>
    </div>
</nav>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark category-nav">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#categoryNav" aria-controls="categoryNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            Categories
        </button>
        <div class="collapse navbar-collapse" id="categoryNav">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link <?= $current_category == 'all' ? 'active' : '' ?>" href="<?= site_url('/') ?>">All</a>
                </li>
                <?php foreach ($categories as $category): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $current_category == $category['id'] ? 'active' : '' ?>" href="<?= site_url('home/index/' . $category['id']) ?>"><?= esc($category['name']) ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="product-container">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <img src="<?= base_url($product['image']) ?>" alt="<?= esc($product['name']) ?>">
                <h3><?= esc($product['name']) ?></h3>
                <p><?= esc($product['description']) ?></p>
                <p>Minimum Price: <?= esc($product['minimum_price']) ?></p>
                <?php if (session()->get('isLoggedIn')): ?>
                    <button class="btn btn-primary bid-button">Bid</button>
                <?php else: ?>
                    <button class="btn btn-primary bid-button" data-toggle="modal" data-target="#loginModal">Bid</button>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login or Register</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>You need to be logged in to place a bid.</p>
                <p>Already have an account? <a href="<?= site_url('login') ?>">Login</a></p>
                <p>Don't have an account yet? <a href="<?= site_url('register') ?>">Register</a></p>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('.bid-button').click(function() {
            <?php if (!session()->get('isLoggedIn')): ?>
            $('#loginModal').modal('show');
            console.log('Modal should be displayed');
            <?php else: ?>
            console.log('User is logged in');
            <?php endif; ?>
        });
    });
</script>
</body>
</html>

