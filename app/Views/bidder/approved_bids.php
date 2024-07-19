<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container my-5">
    <h2>Approved Bids</h2>
    <?php if ($approvedBids): ?>
        <?php foreach ($approvedBids as $bid): ?>
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?= base_url($bid['picture']); ?>" class="img-fluid rounded-start" alt="<?= $bid['product_name']; ?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $bid['product_name']; ?></h5>
                            <p class="card-text">Amount: <?= number_format($bid['amount'], 2); ?></p>
                            <a href="<?= site_url('delivery?bid_id='.$bid['id'].'&amount='.$bid['amount']); ?>" class="btn btn-primary">Proceed to Payment</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No approved bids found.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
