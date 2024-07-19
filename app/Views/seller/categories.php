<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Categories</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <?= $this->include('seller/sidebar') ?>

    <div class="main-content">
        <div class="container my-5">
            <h2>Categories</h2>
            <?php if(session()->has('success')): ?>
                <div class="alert alert-success"><?= session()->get('success') ?></div>
            <?php endif; ?>
            <?php if(session()->has('error')): ?>
                <div class="alert alert-danger"><?= session()->get('error') ?></div>
            <?php endif; ?>
            <a class="btn btn-primary mb-3" href="<?= site_url('seller/addCategory') ?>">Add New Category</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?= $category['id'] ?></td>
                            <td><?= $category['name'] ?></td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="<?= site_url('seller/viewProducts/'.$category['id']) ?>">View Products</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
