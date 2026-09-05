<?php
session_start();
include 'db_connect.php';
$logged_in = isset($_SESSION['customer_id']); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sweet Cake House - Shop</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
<style>
body{margin:0;font-family:'Poppins',sans-serif;background:#fff;color:#4A4A4A;}
header{background:#7B1E3A;color:white;padding:15px 60px;display:flex;justify-content:space-between;align-items:center;}
.logo{display:flex;align-items:center;gap:10px;color:white;font-family:'Playfair Display',serif;}
header a{color:white;text-decoration:none;margin:0 10px;}
header a:hover{ color:#D4AF37; }

/* Top Description */
.top-desc{text-align:center;padding:50px 20px;}
.top-desc h1{font-family:'Playfair Display', serif;font-size:40px;color:#7B1E3A;margin-bottom:10px;}
.top-desc p{font-size:18px;color:#4A4A4A;max-width:800px;margin:auto;line-height:1.6;}

/* Category Section */
.category{padding:50px 20px;}
.category h2{font-family:'Playfair Display', serif;font-size:32px;color:#7B1E3A;margin-bottom:20px;border-bottom:2px solid #7B1E3A;display:inline-block;padding-bottom:5px;}
.category p{font-size:16px;color:#4A4A4A;margin-bottom:30px;}

/* Products Grid */
.products{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;}
.product-card{position:relative;border-radius:20px;overflow:hidden;box-shadow:0 12px 30px rgba(212,175,55,0.2);transition:0.3s;}
.product-card:hover{transform:scale(1.05);box-shadow:0 18px 35px rgba(212,175,55,0.4);}
.product-card img{width:100%;height:350px;object-fit:cover;display:block;}

.product-info{position:absolute;bottom:0;width:100%;background:rgba(104,97,97,0.5);color:white;padding:6px;text-align:center;}
.product-info h3{font-family:'Playfair Display', serif;font-size:14px;margin:2px 0;}
.product-info p{font-size:12px;margin:2px 0;color:white;}
.product-info span{font-weight:bold;color:#D4AF37;font-size:18px;display:block;margin-bottom:3px;}
.product-info button{background:#7B1E3A;color:white;border:none;padding:6px 16px;border-radius:20px;cursor:pointer;font-size:12px;transition:0.3s;margin-bottom:10px;}
.product-info button:hover{transform:scale(1.05);}

@media(max-width:1100px){.products{grid-template-columns:repeat(3,1fr);}}
@media(max-width:800px){.products{grid-template-columns:repeat(2,1fr);}}
@media(max-width:500px){.products{grid-template-columns:1fr;}}
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

<div class="top-desc">
    <h1>Our Delicious Cakes</h1>
    <p>Explore our wide range of premium cakes for every occasion. Carefully crafted with love, freshness, and elegant designs.</p>
</div>

<?php
$categories = ['wedding'=>'Wedding Cakes','birthday'=>'Birthday Cakes','mini'=>'Mini Cakes'];

foreach($categories as $key => $title){
    echo '<div class="category">';
    echo '<h2>'.$title.'</h2>';
    if($key=='wedding') echo '<p>Elegant cakes for weddings and special occasions.</p>';
    if($key=='birthday') echo '<p>Fun and colorful cakes for birthday celebrations.</p>';
    if($key=='mini') echo '<p>Small and delightful mini cakes for every craving.</p>';

    echo '<div class="products">';
    $sql = "SELECT * FROM products WHERE category='$key'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Fallbacks for missing data
            $name = !empty($row["name"]) ? $row["name"] : "Cake";
            $desc = !empty($row["description"]) ? $row["description"] : "Delicious treat";
            $price = !empty($row["price"]) ? $row["price"] : "N/A";
            $image = !empty($row["image"]) ? $row["image"] : "images/default.jpg";

            echo '<div class="product-card">
                    <img src="'.$image.'" alt="'.$name.'">
                    <div class="product-info">
                        <h3>'.$name.'</h3>
                        <p>'.$desc.'</p>
                        <span>$'.$price.'</span>';

            if ($logged_in) {
                echo '<form method="post" action="cart.php">
                        <input type="hidden" name="id" value="'.$row['id'].'">
                        <input type="hidden" name="name" value="'.$name.'">
                        <input type="hidden" name="price" value="'.$price.'">
                        <input type="hidden" name="image" value="'.$image.'">
                        <button type="submit">Order Now</button>
                      </form>';
            } else {
                echo '<button onclick="loginAlert()">Order Now</button>';
            }

            echo '</div></div>';
        }
    } else {
        echo '<p>No products available.</p>';
    }

    echo '</div></div>';
}
$conn->close();
?>

<script>
function loginAlert(){
    alert("Please login first");
    window.location.href = "login.php";
}
</script>

</body>
</html>


