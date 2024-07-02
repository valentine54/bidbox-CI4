// app/Views/payments/index.php
<?= $this->include('layout/sidebar') ?>
<div>
    <h2>Payments</h2>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payments as $payment): ?>
            <tr>
                <td><?= $payment['product_id'] ?></td>
                <td><?= $payment['amount'] ?></td>
                <td><a href="<?= base_url('/payment/makePayment/' . $payment['id']) ?>">Make Payment</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
