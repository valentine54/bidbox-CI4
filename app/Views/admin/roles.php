<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Roles Management</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .filter-buttons {
            margin-bottom: 20px;
        }
        .filter-buttons button {
            padding: 10px 20px;
            margin-right: 10px;
            border: none;
            background-color: #9560d7;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .filter-buttons button:hover {
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
        <a href="<?= site_url('admin/applications') ?>"><i class="fas fa-briefcase"></i> Application Management</a>
    </div>
    <div>
        <a href="<?= site_url('dashboard/logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>
<div class="content">
    <h2>User Role Management</h2>
    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($defaultUsers)): ?>
            <?php foreach ($defaultUsers as $user): ?>
                <tr>
                    <td><?= isset($user['Name']) ? esc($user['Name']) : 'No Name'; ?></td>
                    <td><?= isset($user['email']) ? esc($user['email']) : 'No Email'; ?></td>
                    <td><?= isset($user['role']) ? esc($user['role']) : 'No Role'; ?></td>

                    <td class="action-buttons">
                        <form method="post" action="<?= site_url('admin/update-role/' . $user['id']) ?>">
                            <select name="role" class="role-select">
                                <option value="seller">Seller</option>
                                <option value="bidder">Bidder</option>
                                <option value="auctioneer">Auctioneer</option>
                            </select>
                            <button type="submit" class="btn" style="color:midnightblue">Change Role</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No default users.All users assigned roles</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
