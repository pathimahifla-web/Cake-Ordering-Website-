<?php
session_start();
include 'db_connect.php';

$error = "";

/* ================= REDIRECT IF ALREADY LOGGED IN ================= */
if (isset($_SESSION['admin'])) {
    header("Location: admin_dashboard.php");
    exit();
}

if (isset($_SESSION['customer_id'])) {
    header("Location: shop.php");
    exit();
}
/* ================================================================ */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    /* ================= ADMIN LOGIN ================= */
    if ($email === "admin@gmail.com" && $password === "admin123") {
        $_SESSION['admin'] = true;
        $_SESSION['admin_email'] = $email;
        header("Location: admin_dashboard.php");
        exit();
    }
    /* ================================================= */

    /* ================= CUSTOMER LOGIN ================= */
    $sql = "SELECT * FROM customers WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['customer_id'] = $row['id'];
            $_SESSION['username'] = $row['name'];

            $redirect = $_GET['redirect'] ?? 'shop.php';
            header("Location: $redirect");
            exit();
        } else {
            $error = "Incorrect password";
        }
    } else {
        $error = "Account not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login | Sweet Cake House</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(to right,#FFF1EA,#F5E6DC);
    font-family:'Poppins',sans-serif;
}

.login-box{
    background:white;
    width:380px;
    padding:45px;
    border-radius:30px;
    text-align:center;
    box-shadow:0 18px 40px rgba(0,0,0,0.25);
    animation:popup 0.8s ease;
}

.login-box h2{
    font-family:'Playfair Display',serif;
    color:#7B1E3A;
    margin-bottom:10px;
}

.login-box p.subtitle{
    font-size:15px;
    color:#777;
    margin-bottom:25px;
}

.login-box input{
    width:100%;
    padding:14px;
    margin:12px 0;
    border-radius:30px;
    border:1px solid #ccc;
    font-size:15px;
}

.login-box button{
    background:#7B1E3A;
    color:white;
    border:none;
    width:100%;
    padding:14px;
    border-radius:35px;
    font-size:17px;
    font-weight:600;
    cursor:pointer;
    margin-top:15px;
    box-shadow:0 8px 20px rgba(226,93,100,0.5);
    transition:0.3s;
}

.login-box button:hover{
    transform:scale(1.08);
    box-shadow:0 12px 28px rgba(212,175,55,0.6);
}

.login-box a{
    color:#7B1E3A;
    text-decoration:none;
    font-weight:500;
}

.login-box a:hover{
    color:#D4AF37;
}

.error{
    color:red;
    font-size:14px;
    margin-bottom:10px;
}

@keyframes popup{
    from{opacity:0; transform:translateY(30px);}
    to{opacity:1; transform:translateY(0);}
}
</style>
</head>

<body>

<div class="login-box">
    <h2>Welcome Back</h2>
    <p class="subtitle">Login to continue your sweet journey 🍰</p>

    <?php if($error != ""){ ?>
        <p class="error"><?php echo $error; ?></p>
    <?php } ?>

    <form method="post">
        <input type="email" name="email" placeholder="Email address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <p style="margin-top:20px;">New here?
        <a href="register.php">Create an account</a>
    </p>
</div>

</body>
</html>
