<?php
session_start();
include 'db_connect.php';

// Optional: check admin login
// if(!isset($_SESSION['admin'])) { header('Location: login.php'); exit(); }

// Handle status update
if(isset($_POST['update_status'])){
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $conn->query("UPDATE orders SET status='$status' WHERE id=$order_id");
    header("Location: admin_dashboard.php");
    exit();
}

// Fetch all orders
$orders = $conn->query("
    SELECT o.id AS order_id, o.customer_id, o.total_amount, o.order_date, o.status,
    GROUP_CONCAT(CONCAT(p.name,' (',oi.quantity,')')) AS items
    FROM orders o
    LEFT JOIN order_items oi ON o.id = oi.order_id
    LEFT JOIN products p ON oi.product_id = p.id
    GROUP BY o.id
    ORDER BY o.order_date DESC
");

// Fetch product stats
$total_products = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'];
$total_orders = $conn->query("SELECT COUNT(*) as total FROM orders")->fetch_assoc()['total'];
$total_income = $conn->query("SELECT SUM(total_amount) as total FROM orders")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
<style>
body{margin:0;font-family:'Poppins',sans-serif;background:#f4f4f4;color:#333;}
header{background:#7B1E3A;color:white;padding:15px 40px;display:flex;justify-content:space-between;align-items:center;}
header h2{font-family:'Playfair Display',serif;}
nav a{color:white;text-decoration:none;margin-left:20px;}
nav a:hover{color:#D4AF37;}
.container{width:90%;margin:30px auto;}
.stats{display:flex;gap:20px;margin-bottom:30px;}
.stats div{flex:1;background:white;padding:20px;border-radius:15px;box-shadow:0 10px 20px rgba(0,0,0,0.1);text-align:center;}
table{width:100%;border-collapse:collapse;background:white;border-radius:10px;overflow:hidden;box-shadow:0 10px 20px rgba(0,0,0,0.1);}
th,td{padding:12px;text-align:left;border-bottom:1px solid #ddd;}
th{background:#7B1E3A;color:white;}
tr:hover{background:#f9f9f9;}
form select, form button{padding:5px 10px;border-radius:5px;border:1px solid #ccc;}
form button{background:#7B1E3A;color:white;border:none;cursor:pointer;transition:0.3s;}
form button:hover{background:#D4AF37;}
</style>
</head>
<body>

<header>
    <h2>Admin Dashboard</h2>
    <nav>
        <a href="manage_products.php">Manage Products</a>
         <a href="manage_users.php">Manage Users</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="container">
<h3>Statistics</h3>
<div class="stats">
    <div>
        <h4>Total Products</h4>
        <p><?php echo $total_products; ?></p>
    </div>
    <div>
        <h4>Total Orders</h4>
        <p><?php echo $total_orders; ?></p>
    </div>
    <div>
        <h4>Total Income</h4>
        <p>$<?php echo number_format($total_income,2); ?></p>
    </div>
</div>

<h3>Orders</h3>
<table>
    <tr>
        <th>Order ID</th>
        <th>Customer ID</th>
        <th>Items</th>
        <th>Total Amount</th>
        <th>Order Date</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php while($row = $orders->fetch_assoc()): ?>
    <tr>
        <td>
    <a href="order_details.php?order_id=<?php echo $row['order_id']; ?>">
        <?php echo $row['order_id']; ?>
    </a>
</td>

        <td><?php echo $row['customer_id']; ?></td>
        <td><?php echo $row['items']; ?></td>
        <td>$<?php echo number_format($row['total_amount'],2); ?></td>
        <td><?php echo $row['order_date']; ?></td>
        <td><?php echo $row['status']; ?></td>
        <td>
            <form method="post" style="display:flex;gap:5px;">
                <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                <select name="status">
                    <option value="Pending" <?php if($row['status']=='Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Completed" <?php if($row['status']=='Completed') echo 'selected'; ?>>Completed</option>
                </select>
                <button type="submit" name="update_status">Update</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
</div>

</body>
</html>
