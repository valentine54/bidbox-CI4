<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.min.css">
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
            overflow-y: auto;
        }
        .tile {
            display: inline-block;
            width: 150px;
            height: 80px;
            background-color: #575757;
            color: white;
            padding: 10px;
            margin: 10px;
            border-radius: 8px;
            text-align: center;
            vertical-align: top;
            box-shadow: 0 0 20px rgb(78, 66, 105);
        }
        .chart-container {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }
        .small-chart-container {
            width: 45%;
        }
        canvas {
            width: 100% !important;
            height: auto !important;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 20px rgb(153, 95, 213);
            background-color: #fff;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
            color: #532b7c;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
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
        <a href="<?= site_url('admin/sales-history') ?>"><i class="fas fa-history"></i> Bid history</a>
        <a href="<?= site_url('admin/applications') ?>"><i class="fas fa-briefcase"></i> Application Management</a>
    </div>
    <div>
        <a href="<?= site_url('dashboard/logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>
<div class="content">
    <div class="tile">
        <h4>Total Users</h4>
        <p id="total-users"></p>
    </div>
    <div class="tile">
        <h4>Total Bidders</h4>
        <p id="total-bidders"></p>
    </div>
    <div class="tile">
        <h4>Total Auctioneers</h4>
        <p id="total-auctioneers"></p>
    </div>
    <div class="tile">
        <h4>Total Sellers</h4>
        <p id="total-sellers"></p>
    </div>
    <div class="tile">
        <h4>Banned Users</h4>
        <p id="banned-users"></p>
    </div>
    <div class="tile">
        <h4>Inactive Accounts</h4>
        <p id="inactive-accounts"></p>
    </div>
    <div class="tile">
        <h4>Active Accounts</h4>
        <p id="active-accounts"></p>
    </div>
    <div class="tile">
        <h4>Total Bids</h4>
        <p id="total-bids"></p>
    </div>

    <div class="chart-container">
        <div class="small-chart-container">
            <canvas id="role-pie-chart"></canvas>
        </div>
        <div class="small-chart-container">
            <canvas id="monthly-revenue-bar-chart"></canvas>
        </div>
    </div>
    <h2>Active Accounts</h2>
    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Role</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($activeAccounts as $account): ?>
            <tr>
                <td><?= esc($account['Name']) ?></td>
                <td><?= esc($account['email']) ?></td>
                <td><?= esc($account['contact']) ?></td>
                <td><?= esc($account['role']) ?></td>
                <td><?= esc($account['status'] == 1 ? 'Active' : 'Inactive') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <h2>Inactive Accounts</h2>
    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Role</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($inactiveAccounts as $account): ?>
            <tr>
                <td><?= esc($account['Name']) ?></td>
                <td><?= esc($account['email']) ?></td>
                <td><?= esc($account['contact']) ?></td>
                <td><?= esc($account['role']) ?></td>
                <td><?= esc($account['status'] == 1 ? 'Active' : 'Inactive') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <h2>Applications</h2>
    <table>
        <thead>
        <tr>
            <th>Applicant Name</th>
            <th>Email</th>
            <th>Type</th>
            <th>Documents</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($applications as $application): ?>
            <tr>
                <td><?= esc($application['applicant_name']) ?></td>
                <td><?= esc($application['email']) ?></td>
                <td><?= esc($application['type']) ?></td>
                <td><?= esc($application['documents']) ?></td>
                <td>
                    <?php
                    $status = '';
                    switch ($application['status']) {
                        case 'approved':
                            $status = '<span style="color: green;">Approved</span>';
                            break;
                        case 'disapproved':
                            $status = '<span style="color: red;">Disapproved</span>';
                            break;
                        case 'awaiting_approval':
                            $status = '<span style="color: orange;">Awaiting Approval</span>';
                            break;
                        default:
                            $status = 'Unknown';
                            break;
                    }
                    echo $status;
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>



</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.min.js"></script>
<script>
    // Sample data for demonstration purposes
    const totalUsers = 6;
    const totalBidders = 1;
    const totalAuctioneers = 2;
    const totalSellers = 2;
    const bannedUsers = 2;
    const inactiveAccounts =1 ;
    const activeAccounts = totalUsers - inactiveAccounts;
    const totalBids = 1;

    // Update tiles with data
    document.getElementById('total-users').innerText = totalUsers;
    document.getElementById('total-bidders').innerText = totalBidders;
    document.getElementById('total-auctioneers').innerText = totalAuctioneers;
    document.getElementById('total-sellers').innerText = totalSellers;
    document.getElementById('banned-users').innerText = bannedUsers;
    document.getElementById('inactive-accounts').innerText = inactiveAccounts;
    document.getElementById('active-accounts').innerText = activeAccounts;
    document.getElementById('total-bids').innerText = totalBids;

    // Role distribution pie chart
    const rolePieCtx = document.getElementById('role-pie-chart').getContext('2d');
    const rolePieChart = new Chart(rolePieCtx, {
        type: 'pie',
        data: {
            labels: ['Bidders', 'Sellers', 'Auctioneers'],
            datasets: [{
                data: [totalBidders, totalSellers, totalAuctioneers],
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });

    // Monthly revenue bar chart
    const monthlyRevenueCtx = document.getElementById('monthly-revenue-bar-chart').getContext('2d');
    const monthlyRevenueChart = new Chart(monthlyRevenueCtx, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [{
                label: 'Revenue in dollars ',
                data: [1200, 1900, 3000, 5000, 2000, 3000, 4000, 2500, 3000, 4500, 4000, 5000], // Sample data
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
</body>
</html>
