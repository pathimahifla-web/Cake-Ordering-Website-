<?php
include 'db_connect.php';

$success = "";
$error = "";

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    if(!empty($name) && !empty($email) && !empty($subject) && !empty($message)){
        $stmt = $conn->prepare("INSERT INTO messages (fullname, email, topic, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if($stmt->execute()){
            $success = "Your message has been sent successfully!";
        } else {
            $error = "Something went wrong. Please try again!";
        }
        $stmt->close();
    } else {
        $error = "Please fill in all fields!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Contact Sweet Cake House</title>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:'Poppins',sans-serif;
        background:linear-gradient(to right,#FFF1EA,#F5E6DC);
    color:#4A4A4A;
}
.logo{
    display:flex;
    align-items:center;
    gap:10px;
    color:white;
    font-family:'Playfair Display',serif;
}
header{
    background:#7B1E3A;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 60px;
    color:white;
}
header a{ color:white; text-decoration:none; margin:0 10px; }
header a:hover{ color:#D4AF37; }

.container{
    max-width:800px;
    margin:50px auto;
    padding:0 20px;
}

/* CONTACT FORM */
.contact-form{
    background: white;
    padding:40px;
    border-radius:25px;
    
}
.contact-form h2{
    font-family:'Playfair Display', serif;
    font-size:32px;
    color:#7B1E3A;
    margin-bottom:25px;
    text-align:center;
}
.contact-form input, .contact-form textarea{
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:10px;
    border:1px solid #ccc;
    font-size:16px;
}
.contact-form button{ 
    background:#7B1E3A;
    color:white;
    border:none;
    padding:14px 30px;
    font-size:18px;
    border-radius:25px;
    cursor:pointer;
    width:100%;
    transition:0.3s;
}
.contact-form button:hover{
    transform:scale(1.05);
    box-shadow:0 12px 25px rgba(234, 126, 126, 0.5);
}
.success{ color:green; margin-bottom:15px; text-align:center; }
.error{ color:red; margin-bottom:15px; text-align:center; }

/* CONTACT CARDS */
.contact-cards{
    display:flex;
    flex-wrap:wrap;
    gap:20px;
    margin-top:40px;
    justify-content:space-between;
}
.card{
    flex:1;
    min-width:180px;
    background: #d2a8b4ff;
    padding:25px;
    border-radius:20px;
    text-align:center;
    box-shadow:0 12px 30px rgba(227, 148, 136, 0.2);
    transition: transform 0.3s, box-shadow 0.3s;
    cursor:pointer;
}
.card:hover{
    transform:scale(1.05);
    box-shadow:0 20px 35px rgba(228, 119, 119, 0.5);
}
.card h4{
    font-family:'Playfair Display', serif;
    color:#7B1E3A;
    margin-bottom:10px;
}
.card p{
    font-size:16px;
    line-height:1.6;
}
</style>
</head>
<body>

<header>
    <div class="logo">
    <h2>Sweet Cake House</h2>
</div>
    <nav>
        <a href="home.php">Home</a>
        <a href="shop.php">Cakes</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <a href="login.php">Login</a>
    </nav>
</header>

<div class="container">

    <!-- CONTACT FORM -->
    <div class="contact-form">
        <h2>Contact Us</h2>
        <?php if($success) echo "<p class='success'>$success</p>"; ?>
        <?php if($error) echo "<p class='error'>$error</p>"; ?>
        <form method="post" action="">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <input type="text" name="subject" placeholder="Subject" required>
            <textarea name="message" rows="6" placeholder="Your Message" required></textarea>
            <button type="submit" name="submit">Send Message</button>
        </form>
    </div>

    <!-- CONTACT DETAILS CARDS -->
    <div class="contact-cards">
        <div class="card">
            <h4>Email</h4>
            <p>info@sweetcakehouse.com</p>
        </div>
        <div class="card">
            <h4>Phone</h4>
            <p>+94 123 456 789</p>
        </div>
        <div class="card">
            <h4>Address</h4>
            <p>12 Cake Street, Kurunegala, Sri Lanka</p>
        </div>
        <div class="card">
            <h4>Working Hours</h4>
            <p>Mon-Sat 8:00am - 7:00pm</p>
        </div>
    </div>

</div>

</body>
</html>
