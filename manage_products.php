<?php
session_start();
include 'db_connect.php';

// Optional: check if admin is logged in
// if(!isset($_SESSION['admin'])) { header('Location: login.php'); exit(); }

// Handle Add Product
if(isset($_POST['add_product'])){
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Handle image upload
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $image_name = time().'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], 'images/'.$image_name);
        $image_path = 'images/'.$image_name;
    } else {
        $image_path = '';
    }

    $conn->query("INSERT INTO products (name, category, description, price, image) VALUES ('$name','$category','$description','$price','$image_path')");
    header("Location: manage_products.php");
    exit();
}

// Handle Delete Product
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $conn->query("DELETE FROM products WHERE id=$id");
    header("Location: manage_products.php");
    exit();
}

// Fetch all products
$products = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Products - Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
<style>
body{margin:0;font-family:'Poppins',sans-serif;background:#f4f4f4;color:#333;}
header{background:#7B1E3A;color:white;padding:15px 40px;display:flex;justify-content:space-between;align-items:center;}
header h2{font-family:'Playfair Display',serif;}
nav a{color:white;text-decoration:none;margin-left:20px;}
nav a:hover{color:#D4AF37;}
.container{width:90%;margin:30px auto;}
form{background:white;padding:20px;border-radius:15px;box-shadow:0 10px 20px rgba(0,0,0,0.1);margin-bottom:30px;}
form input, form select, form textarea, form button{display:block;width:100%;margin-bottom:15px;padding:10px;border-radius:10px;border:1px solid #ccc;}
form button{background:#7B1E3A;color:white;border:none;cursor:pointer;transition:0.3s;}
form button:hover{background:#D4AF37;}
table{width:100%;border-collapse:collapse;background:white;border-radius:10px;overflow:hidden;box-shadow:0 10px 20px rgba(0,0,0,0.1);}
th,td{padding:12px;text-align:left;border-bottom:1px solid #ddd;}
th{background:#7B1E3A;color:white;}
tr:hover{background:#f9f9f9;}
img.product-img{width:80px;height:80px;object-fit:cover;border-radius:10px;}
.btn a{
    text-decoration:none;
    color:maroon;
}
</style>
</head>
<body>

<header>
    <h2>Manage Products</h2>
    <nav>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="container">

<h3>Add New Product</h3>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Product Name" required>
    <select name="category" required>
        <option value="">Select Category</option>
        <option value="wedding">Wedding</option>
        <option value="birthday">Birthday</option>
        <option value="mini">Mini</option>
    </select>
    <textarea name="description" placeholder="Description" required></textarea>
    <input type="number" step="0.01" name="price" placeholder="Price" required>
    <input type="file" name="image" required>
    <button type="submit" name="add_product">Add Product</button>
</form>

<h3>All Products</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Name</th>
        <th>Category</th>
        <th>Description</th>
        <th>Price</th>
        <th>Action</th>
    </tr>
    <?php while($row = $products->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><img src="<?php echo $row['image']; ?>" class="product-img" alt=""></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['category']; ?></td>
        <td><?php echo $row['description']; ?></td>
        <td>$<?php echo number_format($row['price'],2); ?></td>
        <td>
            <div class="btn">
            <a href="edit_product.php?id=<?php echo $row['id']; ?>">Edit</a> | 
            <a href="manage_products.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
    </div>
        </td>

    </tr>
    <?php endwhile; ?>
</table>

</div>

</body>
</html>
