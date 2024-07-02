// app/Views/products/bid.php
<?= $this->include('layout/sidebar') ?>
<div>
    <h2>Bid on <?= $product['name'] ?></h2>
    <form action="<?= base_url('/product/placeBid') ?>" method="post">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <input type="hidden" name="bidder_id" value="1"> <!-- Static user ID for demo -->
        <label for="amount">Enter Amount:</label>
        <input type="number" name="amount" id="amount" required>
        <button type="submit">OK</button>
    </form>
    <p>Status: Awaiting to be approved or disapproved</p>
</div>
