<?php
session_start();
include 'db_connect.php';

// Optional: check if admin is logged in
// if(!isset($_SESSION['admin'])) { header('Location: login.php'); exit(); }

if(!isset($_GET['id'])){
    header("Location: manage_products.php");
    exit();
}

$id = $_GET['id'];

// Fetch product
$result = $conn->query("SELECT * FROM products WHERE id=$id");
if($result->num_rows == 0){
    header("Location: manage_products.php");
    exit();
}

$product = $result->fetch_assoc();

// Handle update
if(isset($_POST['update_product'])){
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $image_path = $product['image']; // default existing image

    // Handle image upload if new image is selected
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $image_name = time().'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], 'images/'.$image_name);
        $image_path = 'images/'.$image_name;
    }

    $conn->query("UPDATE products SET name='$name', category='$category', description='$description', price='$price', image='$image_path' WHERE id=$id");
    header("Location: manage_products.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Product - Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
<style>
body{margin:0;font-family:'Poppins',sans-serif;background:#f4f4f4;color:#333;}
header{background:#7B1E3A;color:white;padding:15px 40px;display:flex;justify-content:space-between;align-items:center;}
header h2{font-family:'Playfair Display',serif;}
nav a{color:white;text-decoration:none;margin-left:20px;}
nav a:hover{color:#D4AF37;}
.container{width:90%;margin:30px auto;}
form{background:white;padding:20px;border-radius:15px;box-shadow:0 10px 20px rgba(0,0,0,0.1);}
form input, form select, form textarea, form button{display:block;width:100%;margin-bottom:15px;padding:10px;border-radius:10px;border:1px solid #ccc;}
form button{background:#7B1E3A;color:white;border:none;cursor:pointer;transition:0.3s;}
form button:hover{background:#D4AF37;}
img.product-img{width:120px;height:120px;object-fit:cover;border-radius:10px;margin-bottom:10px;}
</style>
</head>
<body>

<header>
    <h2>Edit Product</h2>
    <nav>
        <a href="manage_products.php">Back</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="container">
<h3>Edit Product: <?php echo $product['name']; ?></h3>
<form method="post" enctype="multipart/form-data">
    <label>Product Name:</label>
    <input type="text" name="name" value="<?php echo $product['name']; ?>" required>

    <label>Category:</label>
    <select name="category" required>
        <option value="wedding" <?php if($product['category']=='wedding') echo 'selected'; ?>>Wedding</option>
        <option value="birthday" <?php if($product['category']=='birthday') echo 'selected'; ?>>Birthday</option>
        <option value="mini" <?php if($product['category']=='mini') echo 'selected'; ?>>Mini</option>
    </select>

    <label>Description:</label>
    <textarea name="description" required><?php echo $product['description']; ?></textarea>

    <label>Price:</label>
    <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>

    <label>Current Image:</label>
    <img src="<?php echo $product['image']; ?>" class="product-img" alt="Product Image">

    <label>Change Image (optional):</label>
    <input type="file" name="image">

    <button type="submit" name="update_product">Update Product</button>
</form>
</div>

</body>
</html>
