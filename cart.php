<?php
session_start();
include 'db_connect.php';

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Clean invalid cart items (avoid warnings)
foreach($_SESSION['cart'] as $key => $val){
    if(!is_array($val)){
        unset($_SESSION['cart'][$key]);
    }
}

// Add to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    if (isset($_SESSION['cart'][$id]) && is_array($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$id] = [
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'quantity' => 1
        ];
    }

    header('Location: cart.php');
    exit();
}

// Remove from cart
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    unset($_SESSION['cart'][$remove_id]);
    header('Location: cart.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Your Cart - Sweet Cake House</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
<style>
body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: #fff;
    color: #4A4A4A;
}
header {
    background: #7B1E3A;
    color: white;
    padding: 15px 60px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
header a {
    color: white;
    text-decoration: none;
    margin: 0 10px;
}
header a:hover {
    color: #D4AF37;
}
.logo {
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: 'Playfair Display', serif;
}
h1 {
    text-align: center;
    font-family: 'Playfair Display', serif;
    color: #7B1E3A;
    margin: 40px 0 20px;
}

.cart-container {
    width: 90%;
    margin: auto;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.cart-card {
    display: flex;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 12px 30px rgba(212,175,55,0.2);
    overflow: hidden;
    padding: 10px;
    align-items: center;
    transition: 0.3s;
}
.cart-card img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 15px;
    margin-right: 20px;
}
.cart-details {
    flex: 1;
}
.cart-details h3 {
    font-family: 'Playfair Display', serif;
    margin: 5px 0;
    color: #7B1E3A;
}
.cart-details p.price {
    font-weight: bold;
    margin: 5px 0;
}
.cart-details label {
    display: block;
    margin: 5px 0;
}
.cart-details p.subtotal {
    margin: 5px 0;
}
.remove-btn {
    background: #7B1E3A;
    color: white;
    border: none;
    padding: 5px 12px;
    border-radius: 20px;
    cursor: pointer;
    transition: 0.3s;
    margin-left: 20px;
    height: fit-content;
}
.remove-btn:hover {
    background: #D4AF37;
}

.total-container {
    width: 90%;
    margin: 30px auto;
    text-align: right;
    font-size: 18px;
}
.place-order {
    display: block;
    width: 200px;
    margin: 20px auto 50px;
    padding: 10px 20px;
    background: #7B1E3A;
    color: white;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    font-size: 16px;
    transition: 0.3s;
}
.place-order:hover {
    background: #D4AF37;
}
@media(max-width:600px){
    .cart-card {
        flex-direction: column;
        align-items: center;
    }
    .cart-card img {
        margin-right: 0;
        margin-bottom: 10px;
    }
    .remove-btn {
        margin-left: 0;
        margin-top: 10px;
    }
}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

<h1>Your Cart</h1>

<?php if (!empty($_SESSION['cart'])): ?>
<div class="cart-container">
    <?php 
    $total = 0;
    foreach($_SESSION['cart'] as $id => $item):
        if(!is_array($item)) continue; // skip invalid entries
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
    ?>
    <div class="cart-card" data-id="<?php echo $id; ?>">
        <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
        <div class="cart-details">
            <h3><?php echo $item['name']; ?></h3>
            <p class="price">$<?php echo $item['price']; ?></p>
            <label>Quantity: 
                <input type="number" class="qty" value="<?php echo $item['quantity']; ?>" min="1">
            </label>
            <p class="subtotal">Subtotal: $<?php echo $subtotal; ?></p>
        </div>
        <button class="remove-btn">Remove</button>
    </div>
    <?php endforeach; ?>
</div>

<div class="total-container">
    <strong>Total: $<span id="total"><?php echo $total; ?></span></strong>
</div>

<form method="post" action="checkout.php">
    <button class="place-order" type="submit">Place Order</button>
</form>

<?php else: ?>
<p style="text-align:center; margin-top:50px;">Your cart is empty.</p>
<?php endif; ?>

<script>
// Update quantity
$(document).on('change', '.qty', function(){
    var card = $(this).closest('.cart-card');
    var id = card.data('id');
    var qty = $(this).val();

    $.post('update_cart.php', {id: id, qty: qty}, function(response){
        var data = JSON.parse(response);
        card.find('.subtotal').text('Subtotal: $' + data.subtotal);
        $('#total').text(data.total);
    });
});

// Remove item
$(document).on('click', '.remove-btn', function(){
    var card = $(this).closest('.cart-card');
    var id = card.data('id');

    $.post('update_cart.php', {id: id, qty: 0}, function(response){
        location.reload();
    });
});
</script>

</body>
</html>
