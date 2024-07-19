<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="d-flex">
        <?= view('sidebar'); ?>

        <div class="main-content container my-5">
            <h3>Your Cart</h3>
            <?php if (!empty($products)): ?>
                <div class="row">
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="<?= htmlspecialchars($product['picture']); ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']); ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($product['description']); ?></p>
                                    <p class="card-text">Minimum Price: Kshs <?= htmlspecialchars($product['minimum_price']); ?></p>
                                    <button class="btn btn-danger" onclick="removeFromCart(<?= $product['id']; ?>)">Remove from Cart</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function removeFromCart(productId) {
            $.ajax({
                url: "<?= site_url('cart/removeFromCart'); ?>",
                method: "POST",
                data: { product_id: productId },
                success: function(response) {
                    alert("Product removed from cart.");
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert("Error removing from cart: " + xhr.responseText);
                }
            });
        }
    </script>
</body>
</html>
