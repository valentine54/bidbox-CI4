<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
            margin: 0;
        }
        .sidebar {
            width: 250px;
            background-color: #333;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 15px;
            display: block;
        }
        .sidebar a:hover {
            background-color: #575757;
        }
        .sidebar .profile {
            text-align: center;
            padding: 20px;
        }
        .sidebar .profile img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], input[type="email"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            padding: 10px 20px;
            background-color: #9560d7;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #432188;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <div>
        <div class="profile">
            <img src="<?= base_url('images/Admin.png') ?>" alt="Profile Picture">
            <h3>Administrator</h3>
        </div>
        <a href="<?= site_url('admin/dashboard') ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="<?= site_url('admin/users') ?>"><i class="fas fa-users"></i> Users</a>
        <a href="<?= site_url('admin/roles') ?>"><i class="fas fa-user-tag"></i> Assign Roles</a>
        <a href="<?= site_url('admin/sales-history') ?>"><i class="fas fa-history"></i> Sales History</a>
        <a href="<?= site_url('admin/application-management') ?>"><i class="fas fa-briefcase"></i> Application Management</a>
    </div>
    <div>
        <a href="<?= site_url('dashboard/logout') ?>" id="logoutLink"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>
<div class="content">
    <h2>Edit User</h2>
    <form method="post" action="<?= site_url('admin/update-user/' . $user['id']) ?>">
        <label for="name">Name:</label>
        <input type="text" id="Name" name="Name" value="<?= esc($user['Name']) ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= esc($user['email']) ?>" required>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
            <option value="seller" <?= ($user['role'] == 'seller') ? 'selected' : '' ?>>Seller</option>
            <option value="bidder" <?= ($user['role'] == 'bidder') ? 'selected' : '' ?>>Bidder</option>
            <option value="auctioneer" <?= ($user['role'] == 'auctioneer') ? 'selected' : '' ?>>Auctioneer</option>
            <option value="user" <?= ($user['role'] == 'user') ? 'selected' : '' ?>>User</option>
        </select>

        <label for="contact">Contact:</label>
        <input type="tel" id="contact" name="contact" value="<?= esc($user['contact']) ?>" required>

        <button type="submit">Update User</button>
    </form>
</div>
</body>
</html>
