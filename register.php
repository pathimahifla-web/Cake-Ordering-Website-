<?php
include 'db_connect.php';

$error = "";
$success = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if email already exists
    $check = $conn->query("SELECT * FROM customers WHERE email='$email'");
    if($check->num_rows > 0){
        $error = "Email already registered. Please login.";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $conn->query("INSERT INTO customers(name,email,password) VALUES('$name','$email','$password_hash')");
        $success = "Account created successfully! You can now <a href='login.php'>login</a>.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register | Sweet Cake House</title>

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

.register-box{
    background:white;
    width:400px;
    padding:45px;
    border-radius:30px;
    text-align:center;
    box-shadow:0 18px 40px rgba(0,0,0,0.25);
    animation:popup 0.8s ease;
}

.register-box h2{
    font-family:'Playfair Display',serif;
    color:#7B1E3A;
    margin-bottom:10px;
}

.register-box p.subtitle{
    font-size:15px;
    color:#777;
    margin-bottom:25px;
}

.register-box input{
    width:100%;
    padding:14px;
    margin:12px 0;
    border-radius:30px;
    border:1px solid #ccc;
    font-size:15px;
}

.register-box button{
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

.register-box button:hover{
    transform:scale(1.08);
    box-shadow:0 12px 28px rgba(212,175,55,0.6);
}

.register-box a{
    color:#7B1E3A;
    text-decoration:none;
    font-weight:500;
}

.register-box a:hover{
    color:#D4AF37;
}

.error{
    color:red;
    font-size:14px;
    margin-bottom:10px;
}

.success{
    color:green;
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

<div class="register-box">
    <h2>Create Account</h2>
    <p class="subtitle">Join Sweet Cake House today 🎂</p>

    <?php if($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <?php if($success): ?>
        <p class="success"><?= $success ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>

    <p style="margin-top:20px;">
        Already have an account?
        <a href="login.php">Login</a>
    </p>
</div>

</body>
</html>
