<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Category</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="main-content">
        <div class="container my-5">
            <h2>Add New Category</h2>
            <form method="POST" action="<?= site_url('seller/addcategory') ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Category</button>
                <a href="<?= site_url('categories') ?>" class="btn btn-secondary">Back to Categories</a>
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // CodeIgniter will handle database operations in the Controller
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
