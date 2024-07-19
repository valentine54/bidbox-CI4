<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Bids</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="d-flex">
        <?= view('sidebar'); ?>

        <div class="main-content container my-5">
            <h3>Your Bids</h3>
            <?php if (!empty($bids)): ?>
                <div class="row">
                    <?php foreach ($bids as $bid): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($bid['product_name']); ?></h5>
                                    <p class="card-text">Category: <?= htmlspecialchars($bid['category_name']); ?></p>
                                    <p class="card-text">Bid Amount: Kshs <?= htmlspecialchars($bid['amount']); ?></p>
                                    <p class="card-text">Status: <?= htmlspecialchars($bid['status']); ?></p>
                                    <button class="btn btn-danger" onclick="withdrawBid(<?= $bid['id']; ?>)">Withdraw Bid</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>You have not placed any bids.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function withdrawBid(bidId) {
            $.ajax({
                url: "<?= site_url('yourbids/withdraw'); ?>/" + bidId,
                method: "POST",
                success: function(response) {
                    alert("Bid withdrawn.");
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert("Error withdrawing bid: " + xhr.responseText);
                }
            });
        }
    </script>
</body>
</html>
