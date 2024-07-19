<!-- app/Views/product_bids.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Bids</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/all.min.css') ?>">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="container my-5">
            <h2>List of Products with Approved Bids</h2>
            <br>
            <div class="row">
                <div class="col-md-7">
                    <?= form_open(base_url('product_bids'), ['method' => 'get']) ?>
                        <div class="input-group mb-3">
                            <input type="text" name="search" value="<?= set_value('search', '') ?>" class="form-control" placeholder="Search for products">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    <?= form_close() ?>
                </div>
            </div>
            <br>
            <div class="row">
                <?php if (!empty($products)) : ?>
                    <?php foreach ($products as $product) : ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="<?= base_url('uploads/' . $product['product_picture']) ?>" class="card-img-top" alt="<?= esc($product['product_name']) ?>" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?= esc($product['product_name']) ?></h5>
                                    <p class="card-text"><?= esc($product['product_description']) ?></p>
                                    <p class="card-text"><strong>Minimum Price:</strong> Kshs <?= esc($product['minimum_price']) ?></p>
                                    <p class="card-text"><strong>Bid Amount:</strong> Kshs <?= esc($product['bid_amount']) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="col-md-12">
                        <p>No products with approved bids found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
