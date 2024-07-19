<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="d-flex">
        <?= view('sidebar'); ?>

        <div class="main-content container my-5">
            <h3>Profile</h3>
            <form action="<?= site_url('profile/updateProfile'); ?>" method="post">
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($bidder['first_name']); ?>">
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($bidder['last_name']); ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($bidder['email']); ?>">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($bidder['phone']); ?>">
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>

            <h4 class="mt-5">Update Profile Image</h4>
            <form action="<?= site_url('profile/updateProfileImage'); ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="profile_image" class="form-label">Profile Image</label>
                    <input type="file" class="form-control" id="profile_image" name="profile_image">
                </div>
                <button type="submit" class="btn btn-primary">Update Profile Image</button>
            </form>

            <?php if (!empty($bidder['profile_image'])): ?>
                <h4 class="mt-5">Current Profile Image</h4>
                <img src="<?= base_url('uploads/profile_images/' . $bidder['profile_image']); ?>" alt="Profile Image" class="img-fluid">
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
