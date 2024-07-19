<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container my-5">
    <h2>Categories</h2>
    <form method="POST" action="<?= site_url('categories/viewProducts'); ?>">
        <div class="mb-3">
            <label for="category" class="form-label">Select Category</label>
            <select id="category" name="category_id" class="form-control" required>
                <option value="">Select a category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">View Products</button>
    </form>
    <?php if (isset($products)): ?>
        <h2>Products</h2>
        <?php foreach ($products as $product): ?>
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <?php if (!empty($product['picture']) && file_exists($product['picture'])): ?>
                            <img src="<?= base_url($product['picture']); ?>" class="img-fluid rounded-start" alt="<?= $product['name']; ?>">
                        <?php else: ?>
                            <p>No image available</p>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text"><?= htmlspecialchars($product['description']); ?></p>
                            <p class="card-text">Minimum Price: <?= htmlspecialchars($product['minimum_price']); ?></p>
                            <button class="btn btn-primary" onclick="showBidForm(<?= $product['id']; ?>)">Bid</button>
                            <form method="POST" action="<?= site_url('cart/add'); ?>" style="display:inline;">
                                <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                <button type="submit" class="btn btn-warning">Add to Cart</button>
                            </form>
                            <form method="POST" action="<?= site_url('bids/place'); ?>">
                                <div class="mb-3" id="bid-form-<?= $product['id']; ?>" style="display:none;">
                                   <label for="bid_amount" class="form-label">Bid Amount</label>
                                   <input type="number" class="form-control" id="bid_amount" name="amount" required>
                                   <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                   <input type="hidden" name="bidder_id" value="<?= session('bidder_id'); ?>">
                                   <button type="submit" class="btn btn-success mt-2">Place Bid</button>
                                </div>
                            </form>   
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
    function showBidForm(productId) {
        document.getElementById('bid-form-' + productId).style.display = 'block';
    }
</script>

<?= $this->endSection() ?>
