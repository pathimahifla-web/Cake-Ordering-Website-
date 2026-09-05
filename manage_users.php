<?php
session_start();
include 'db_connect.php';

// Delete user
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM customers WHERE id = $id");
    header("Location: manage_users.php");
    exit();
}

// Fetch users
$result = mysqli_query($conn, "SELECT * FROM customers");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <style>
        body {
            font-family: Poppins, sans-serif;
            background: #f5f5f5;
        }
        .container {
            width: 90%;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
        }
        h2 {
            color: #7b1e3a;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background: #7b1e3a;
            color: white;
            padding: 10px;
        }
        td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        a.delete {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }
        a.delete:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Manage Users</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Registered Date</th>
            <th>Action</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['created_at']; ?></td>
            <td>
                <a class="delete" href="manage_users.php?delete=<?php echo $row['id']; ?>"
                   onclick="return confirm('Are you sure you want to delete this user?')">
                   Delete
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
