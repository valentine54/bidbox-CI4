<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        .main-content {
            position: relative; /* Ensure relative positioning for container */
        }
        #addProductForm {
            position: absolute; /* Position form absolutely */
            top: 50px; /* Adjust top position as needed */
            left: 50%; /* Center horizontally */
            transform: translateX(-50%); /* Center horizontally */
            background: #fff; /* Ensure form background is white */
            padding: 20px; /* Add padding for spacing */
            border: 1px solid #ccc; /* Optional: Add border for visual separation */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Optional: Add box shadow for depth */
            z-index: 1000; /* Ensure form is above other content */
            display: none; /* Hide form initially */
        }
        .back-button {
            margin-right: 10px; /* Adjust margin as needed */
        }
    </style>
</head>
<body>
    <?= $this->include('seller/sidebar') ?>

    <div class="main-content">
        <div class="container my-5">
            <h2>List of Products</h2>
            <button id="addProductButton" class="btn btn-primary">New Product</button>
            
            <!-- Add Product Form (Initially Hidden) -->
            <div id="addProductForm">
                <form id="productForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                    <div class="form-group">
                        <label for="minimum_price">Minimum Price</label>
                        <input type="text" class="form-control" id="minimum_price" name="minimum_price" required>
                    </div>
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="picture">Picture</label>
                        <input type="file" class="form-control-file" id="picture" name="picture" required>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button id="cancelButton" class="btn btn-secondary back-button">Cancel</button>
                    </div>
                </form>
            </div>
            
            <!-- Table of Products -->
            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Minimum Price</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product['id'] ?></td>
                            <td><?= $product['name'] ?></td>
                            <td><?= $product['description'] ?></td>
                            <td><?= $product['minimum_price'] ?></td>
                            <td><?= $product['category_name'] ?></td>
                            <td>
                            <td>
            <?php
            $currentTimestamp = time();
            $endTime = strtotime($product['end_time']);
            $remainingTime = $endTime - $currentTimestamp;

            if ($remainingTime > 0) {
                $hours = floor($remainingTime / 3600);
                $minutes = floor(($remainingTime % 3600) / 60);
                echo "Bidding ends in: $hours hours $minutes minutes";
            } else {
                echo "Bidding closed";
            }
            ?>
        </td>
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="<?= site_url('seller/editProduct/'.$product['id']) ?>">Edit</a>
                                <a class="btn btn-danger btn-sm" href="<?= site_url('seller/deleteProduct/'.$product['id']) ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#addProductButton').click(function() {
                $('#addProductForm').toggle(); // Show/hide the form
            });

            $('#cancelButton').click(function() {
                $('#addProductForm').hide(); // Hide the form
            });

            $('#productForm').submit(function(event) {
                event.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: '<?= site_url('seller/saveProduct') ?>',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert('Product added successfully');
                        $('#addProductForm').hide();
                        location.reload(); // Refresh the page to see the new product
                    },
                    error: function() {
                        alert('Failed to add product');
                    }
                });
            });
        });
    </script>
</body>
</html>
