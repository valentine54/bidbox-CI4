<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - All Products</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="d-flex">
        <?= view('sidebar'); ?>

        <div class="main-content container my-5">
            <h2>Welcome! </h2>
            <h3>All Products</h3>
            <div class="row">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <?php
                            $bidEndTime = strtotime($product['bid_end_time']);
                            $currentTime = time();
                            $isActiveBid = $bidEndTime > $currentTime;
                        ?>
                        <div class="col-md-4 mb-4 <?= $isActiveBid ? '' : 'inactive-bid'; ?>">
                            <div class="card">
                                <img src="<?= htmlspecialchars($product['picture']); ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']); ?>" width="200">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($product['description']); ?></p>
                                    <p class="card-text">Minimum Price: Kshs <?= htmlspecialchars($product['minimum_price']); ?></p>
                                    <?php if ($isActiveBid): ?>
                                        <p>Bid ends in: <span id="countdown-<?= $product['id']; ?>"></span></p>
                                        <button class="btn btn-primary" onclick="toggleBidForm(<?= $product['id']; ?>)">Bid</button>
                                        <button class="btn btn-success" onclick="addToCart(<?= $product['id']; ?>)">Add to Cart</button>
                                        <div id="bid-form-<?= $product['id']; ?>" style="display: none;">
                                            <form id="form-<?= $product['id']; ?>" onsubmit="placeBid(event, <?= $product['id']; ?>)">
                                                <label for="amount">Bid Amount:</label>
                                                <input type="number" step="0.01" min="<?= $product['minimum_price']; ?>" name="amount" required>
                                                <button type="submit" class="btn btn-primary">Place Bid</button>
                                            </form>
                                        </div>
                                    <?php else: ?>
                                        <p>Bid has ended.</p>
                                        <button class="btn btn-success" onclick="addToCart(<?= $product['id']; ?>)">Add to Cart</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No products available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function updateCountdown(endTime, productId) {
            var now = new Date().getTime();
            var distance = endTime - now;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("countdown-" + productId).innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

            if (distance < 0) {
                clearInterval(updateInterval);
                document.getElementById("countdown-" + productId).innerHTML = "Bid has ended";
            }
        }

        <?php foreach ($products as $product): ?>
            <?php if ($isActiveBid): ?>
                var endTime = new Date("<?= date('Y-m-d H:i:s', strtotime($product['bid_end_time'])); ?>").getTime();
                var updateInterval = setInterval(function() {
                    updateCountdown(endTime, <?= $product['id']; ?>);
                }, 1000);
            <?php endif; ?>
        <?php endforeach; ?>

        function toggleBidForm(productId) {
            var bidForm = document.getElementById('bid-form-' + productId);
            if (bidForm.style.display === "none") {
                bidForm.style.display = "block";
            } else {
                bidForm.style.display = "none";
            }
        }

        function placeBid(event, productId) {
            event.preventDefault();
            var form = document.getElementById('form-' + productId);
            var formData = new FormData(form);
            formData.append('product_id', productId);

            $.ajax({
                url: "<?= site_url('bid/placeBid'); ?>",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert("Bid placed successfully!");
                },
                error: function(xhr, status, error) {
                    alert("Error placing bid: " + xhr.responseText);
                }
            });
        }

        function addToCart(productId) {
            $.ajax({
                url: "<?= site_url('cart/addToCart'); ?>",
                method: "POST",
                data: { product_id: productId },
                success: function(response) {
                    alert(response.message);
                    document.getElementById('cart-count').textContent = response.cart_count;
                },
                error: function(xhr, status, error) {
                    alert("Error adding to cart: " + xhr.responseText);
                }
            });
        }
    </script>
</body>
</html>
