<?php
session_start();
include 'db_connect.php';

// Redirect if not logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    if (!empty($_SESSION['cart'])) {
        // Calculate grand total
        $grand_total = 0;
        foreach ($_SESSION['cart'] as $item) {
            if(!is_array($item)) continue;
            $grand_total += $item['price'] * $item['quantity'];
        }

        // Safely collect form data
        $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
        $address  = isset($_POST['address']) ? trim($_POST['address']) : '';
        $phone    = isset($_POST['phone']) ? trim($_POST['phone']) : '';
        $status   = "Pending";

        if ($fullname && $address && $phone) {
            $sql = "INSERT INTO orders (customer_id, total_amount, order_date, status, fullname, address, phone) 
                    VALUES (?, ?, NOW(), ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("idssss", $customer_id, $grand_total, $status, $fullname, $address, $phone);
            $stmt->execute();

            $order_id = $conn->insert_id;

            // Insert items
            foreach ($_SESSION['cart'] as $id => $item) {
                if(!is_array($item)) continue;
                $product_id = $id;
                $quantity   = $item['quantity'];
                $price      = $item['price'];

                $sql_item = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
                $stmt_item = $conn->prepare($sql_item);
                $stmt_item->bind_param("iiid", $order_id, $product_id, $quantity, $price);
                $stmt_item->execute();
            }

            $_SESSION['cart'] = [];
            $success_message = "Thank you, $fullname! Your order has been placed successfully.";
        } else {
            $error_message = "Please fill in all required fields.";
        }
    } else {
        $error_message = "Your cart is empty.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout - Sweet Cake House</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
<style>
body{margin:0;font-family:'Poppins',sans-serif;background:#fff;color:#4A4A4A;}
header{background:#7B1E3A;color:white;padding:15px 60px;display:flex;justify-content:space-between;align-items:center;}
.logo{display:flex;align-items:center;gap:10px;color:white;font-family:'Playfair Display',serif;}
header a{color:white;text-decoration:none;margin:0 10px;}
header a:hover{color:#D4AF37;}

.container{max-width:1000px;margin:50px auto;padding:20px;}
h1{font-family:'Playfair Display',serif;color:#7B1E3A;text-align:center;margin-bottom:30px;}
table{width:100%;border-collapse:collapse;margin-bottom:30px;}
table th, table td{border:1px solid #ddd;padding:12px;text-align:center;}
table th{background:#7B1E3A;color:white;font-family:'Playfair Display',serif;}
table td img{width:80px;height:80px;object-fit:cover;border-radius:10px;}
.total{font-size:20px;font-weight:bold;color:#7B1E3A;text-align:right;margin-top:20px;}
button{background:#7B1E3A;color:white;border:none;padding:10px 20px;border-radius:25px;cursor:pointer;font-size:16px;transition:0.3s;}
button:hover{background:#D4AF37;color:#7B1E3A;}
.message{padding:15px;border-radius:10px;margin-bottom:20px;text-align:center;}
.success{background:#D4AF37;color:#7B1E3A;}
.error{background:#ffcccc;color:#7B1E3A;}

.checkout-form{max-width:600px;margin:30px auto;}
.checkout-form label{display:block;margin:10px 0 5px;font-weight:500;}
.checkout-form input, .checkout-form textarea{
    width:100%;padding:10px;border:1px solid #ccc;border-radius:10px;font-size:14px;
}
</style>
</head>
<body>

<header>
    <div class="logo"><h2>Sweet Cake House</h2></div>
    <nav>
        <a href="home.php">Home</a>
        <a href="shop.php">Cakes</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <a href="login.php">Login</a>
    </nav>
</header>

<div class="container">
    <h1>Checkout</h1>

    <?php if(isset($success_message)) echo '<div class="message success">'.$success_message.'</div>'; ?>
    <?php if(isset($error_message)) echo '<div class="message error">'.$error_message.'</div>'; ?>

    <?php if(!empty($_SESSION['cart'])): ?>
    <form method="post">
        <table>
            <tr>
                <th>Image</th>
                <th>Cake</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            <?php 
            $grand_total = 0;
            foreach($_SESSION['cart'] as $item): 
                if(!is_array($item)) continue;
                $quantity = $item['quantity'];
                $total = $item['price'] * $quantity;
                $grand_total += $total;
            ?>
            <tr>
                <td><img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>"></td>
                <td><?php echo $item['name']; ?></td>
                <td>$<?php echo number_format($item['price'],2); ?></td>
                <td><?php echo $quantity; ?></td>
                <td>$<?php echo number_format($total,2); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <div class="total">Grand Total: $<?php echo number_format($grand_total,2); ?></div>

        <!-- Checkout Form -->
        <div class="checkout-form">
            <label for="fullname">Full Name</label>
            <input type="text" name="fullname" id="fullname" required>

            <label for="address">Delivery Address</label>
            <textarea name="address" id="address" rows="3" required></textarea>

            <label for="phone">Phone Number</label>
            <input type="text" name="phone" id="phone" required>

            <div style="text-align:center;margin-top:20px;">
                <button type="submit" name="checkout">Confirm Order</button>
            </div>
        </div>
    </form>
    <?php else: ?>
        <p style="text-align:center;">Your cart is empty.</p>
    <?php endif; ?>
</div>

</body>
</html>
