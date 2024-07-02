// app/Views/products/index.php
<?= $this->include('layout/sidebar') ?>
<div>
    <h2>Products</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product['name'] ?></td>
                <td><?= $product['description'] ?></td>
                <td><?= $product['price'] ?></td>
                <td><img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" width="50"></td>
                <td><a href="<?= base_url('/product/bid/' . $product['id']) ?>">Bid</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
