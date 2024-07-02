<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applications</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            margin: 0;
            height: 100vh;
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
            overflow-x: auto; /* Allow horizontal scrolling within content if necessary */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            vertical-align: top; /* Ensure content alignment */
            border: 1px solid #ccc; /* Border for cells */
            word-wrap: break-word; /* Break long words if needed */
        }
        th {
            background-color: #f4f4f4;
        }
        .message-column {
            max-width: 500px; /* Adjust based on your design */
        }
        .filter-buttons {
            margin-bottom: 20px;
        }
        .filter-buttons button {
            padding: 10px 20px;
            margin-right: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .approve-button {
            background-color: #260d75; /* Green */
            color: white;
        }
        .disapprove-button {
            background-color: #f44336; /* Red */
            color: white;
        }
        .filter-buttons button:hover {
            opacity: 0.8;
        }
        /* Modal styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4); /* Black background with opacity */
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.2);
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
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
    <h1>Applications</h1>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Type</th>
            <th>Message</th>
            <th>Documents</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($applications as $application): ?>
            <tr>
                <td><?= esc($application['id']) ?></td>
                <td><?= esc($application['applicant_name']) ?></td>
                <td><?= esc($application['email']) ?></td>
                <td><?= esc($application['type']) ?></td>
                <td><?= esc($application['message']) ?></td>
                <td><a href="<?= base_url('uploads/' . $application['documents']) ?>" target="_blank">View</a></td>
                <td><?= esc($application['status']) ?></td>
                <td>
                    <button class="approve-button" onclick="updateStatus('<?= $application['id'] ?>', 'approved')">Approve</button>
                    <br>
                    <br>
                    <button class="disapprove-button" onclick="openDisapproveModal('<?= $application['id'] ?>')">Disapprove</button>
                    <!-- Modal for entering disapproval reason -->
                    <div id="disapproveModal<?= $application['id'] ?>" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeDisapproveModal('<?= $application['id'] ?>')">&times;</span>
                            <h2>Enter Reason for Disapproval</h2>
                            <form id="disapproveForm<?= $application['id'] ?>" onsubmit="submitDisapprovalReason(event, '<?= $application['id'] ?>')">
                                <textarea id="reason<?= $application['id'] ?>" name="reason" rows="4" cols="50" required></textarea><br>
                                <button type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    function updateStatus(id, status) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'http://localhost:8080/index.php/admin/update_status', true);
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    console.log('Success:', response.message);
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                }
            } else {
                try {
                    const response = JSON.parse(xhr.responseText);
                    console.error('Error:', response.message);
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                }
            }
        };

        xhr.onerror = function() {
            console.error('Request error');
        };

        const data = JSON.stringify({ id: id, status: status });
        xhr.send(data);
    }


    function openDisapproveModal(id) {
        var modal = document.getElementById('disapproveModal' + id);
        modal.style.display = 'block';
    }

    function closeDisapproveModal(id) {
        var modal = document.getElementById('disapproveModal' + id);
        modal.style.display = 'none';
    }

    function submitDisapprovalReason(event, id) {
        event.preventDefault();
        var reason = document.getElementById('reason' + id).value;

        // Example AJAX call to submit the reason
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= site_url('admin/disapprove') ?>', true);
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Optionally handle success response
                    alert('Application disapproved successfully.');
                    closeDisapproveModal(id); // Close modal after submission
                    // Optionally update UI to reflect the disapproval
                } else {
                    // Optionally handle error response
                    alert('Failed to disapprove application. Please try again.');
                }
            }
        };

        var data = JSON.stringify({ id: id, reason: reason });
        xhr.send(data);
    }
</script>

</body>
</html>
