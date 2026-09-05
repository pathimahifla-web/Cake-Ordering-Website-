<?php
session_start();
include 'db_connect.php';

// Optional: admin login check
// if(!isset($_SESSION['admin'])) { header('Location: login.php'); exit(); }

if(!isset($_GET['order_id'])){
    header("Location: admin_dashboard.php");
    exit();
}

$order_id = $_GET['order_id'];

// Handle status update
if(isset($_POST['update_status'])){
    $new_status = $_POST['status'];
    $conn->query("UPDATE orders SET status='$new_status' WHERE id=$order_id");
    header("Location: order_details.php?order_id=$order_id");
    exit();
}

// Fetch order info
$order_res = $conn->query("SELECT * FROM orders WHERE id=$order_id");
if($order_res->num_rows == 0){
    header("Location: admin_dashboard.php");
    exit();
}
$order = $order_res->fetch_assoc();

// Fetch order items with product info
$items_res = $conn->query("
    SELECT oi.quantity, oi.price, p.name, p.image
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id=$order_id
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Order Details - Admin</title>
<style>
body{font-family:'Poppins',sans-serif;background:#f4f4f4;margin:0;padding:0;}
header{background:#7B1E3A;color:white;padding:15px 40px;display:flex;justify-content:space-between;align-items:center;}
header h2{font-family:'Playfair Display', serif;}
header a{color:white;text-decoration:none;margin-left:20px;}
header a:hover{color:#D4AF37;}
.container{width:90%;margin:30px auto;}
table{width:100%;border-collapse:collapse;background:white;border-radius:10px;overflow:hidden;box-shadow:0 10px 20px rgba(0,0,0,0.1);}
th,td{padding:12px;text-align:left;border-bottom:1px solid #ddd;}
th{background:#7B1E3A;color:white;}
tr:hover{background:#f9f9f9;}
img{width:80px;height:80px;object-fit:cover;border-radius:10px;}
form{margin-top:15px;}
select, button{padding:6px 12px;margin-right:10px;}
</style>
</head>
<body>
<header>
<h2>Order Details</h2>
<a href="admin_dashboard.php">Back to Dashboard</a>
</header>

<div class="container">
<h3>Order ID: <?php echo $order['id']; ?></h3>
<p>Customer ID: <?php echo $order['customer_id']; ?></p>
<p>Total Amount: $<?php echo number_format($order['total_amount'],2); ?></p>
<p>Order Date: <?php echo $order['order_date']; ?></p>

<!-- Status Update Form -->
<form method="post">
    <label>Status: </label>
    <select name="status">
        <option value="Pending" <?php if($order['status']=='Pending') echo 'selected'; ?>>Pending</option>
        <option value="Completed" <?php if($order['status']=='Completed') echo 'selected'; ?>>Completed</option>
    </select>
    <button type="submit" name="update_status">Update Status</button>
</form>

<h4>Items</h4>
<table>
<tr>
<th>Product</th>
<th>Image</th>
<th>Quantity</th>
<th>Price</th>
<th>Subtotal</th>
</tr>
<?php
while($item = $items_res->fetch_assoc()){
    $subtotal = $item['price'] * $item['quantity'];
    echo "<tr>
            <td>{$item['name']}</td>
            <td><img src='{$item['image']}' alt='{$item['name']}'></td>
            <td>{$item['quantity']}</td>
            <td>\${$item['price']}</td>
            <td>\$$subtotal</td>
          </tr>";
}
?>
</table>
</div>
</body>
</html>
