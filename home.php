<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sweet Cake House</title>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500&family=Dancing+Script:wght@500;600&display=swap" rel="stylesheet">

<style>
/* -------- BASE -------- */
body{
    margin:0;
    font-family:'Poppins',sans-serif;
    background:#FFFFFF; 
    color:#4A4A4A;
}

h1,h2{
    font-family:'Playfair Display',serif;
    color:#7B1E3A;
    font-weight:600;}

/* -------- BUTTON -------- */
button{
    background:#7B1E3A;
    color:white;
    border:none;
    padding:14px 32px;
    font-size:18px;
    font-weight:600;
    border-radius:35px;
    cursor:pointer;
    box-shadow:0 8px 20px rgba(226, 93, 100, 0.5);
    transition:0.3s;
   
}

.logo{
    display:flex;
    align-items:center;
    gap:10px;
    color:white;
    font-family:'Playfair Display',serif;
}

button a{
      text-decoration:none;
      color:white;
}
button:hover{
    transform: scale(1.1);
    box-shadow:0 12px 25px rgba(226, 93, 100, 0.5);
}

/* -------- HEADER -------- */
header{
    background:#7B1E3A;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 60px;
}

.logo img{
    width:45px;
}

nav a{
    text-decoration:none;
    color:white;
    margin:0 15px;
    font-weight:500;
}
nav a:hover{
    color:#D4AF37;
}

/* -------- HERO -------- */
.hero{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:70px;
    background:linear-gradient(to right,#FFF1EA,#F5E6DC);
    animation:popup 1s ease;
}

.hero-text{
    width:50%;
}

.hero-text h1{
    font-size:48px;
    color:#7B1E3A;
    text-shadow: 2px 2px 6px rgba(212,175,55,0.5);
}

.hero-text p{
    font-size:20px;
    line-height:1.6;
}

.hero-images{
    position: relative;
    width: 570px; /* slightly wider container */
    height: 300px; /* slightly taller */
}

/* Hero image common style */
.hero-img{
    position: absolute;
    width: 220px; /* increased width */
    border-radius:20px;
    box-shadow:0 15px 30px rgba(0,0,0,0.25);
    transition: transform 0.3s, box-shadow 0.3s;
}

/* Hover effect */
.hero-img:hover{
    transform: scale(1.1) rotate(0deg);
    box-shadow:0 20px 35px rgba(212,175,55,0.5);
}

/* Individual positions & rotation */
.img1{
    top:0;
    left:0;
    transform: rotate(-5deg);
    z-index:3;
}

.img2{
    top:30px;
    left:140px;
    transform: rotate(5deg);
    z-index:2;
}

.img3{
    top:60px;
    left:280px;
    transform: rotate(-3deg);
    z-index:1;
}




/* -------- COLLAGE -------- */
.collage-section{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:70px;
}

/* -------- COLLAGE SIDE TEXT -------- */
.side-text{
    width:20%;
    font-family: 'Dancing Script', cursive;
    font-size:55px;
    font-weight:500;
    color:#7B1E3A;
    text-align:center;
    line-height:1.5;
    word-wrap: break-word;
    transition: transform 0.3s, color 0.3s;
}
.side-text:hover{
    transform: scale(1.05);
    color:#F4C846;
}

/* Collage Grid */
.collage{
    display:grid;
    grid-template-columns:260px 130px;
    grid-template-rows:150px 150px;
    gap:15px;
}

.collage img{
    width:100%;
    height:100%;
    object-fit:cover;
    border-radius:20px;
    transition: transform 0.3s, box-shadow 0.3s;
}

.collage img:hover{
    transform: scale(1.08);
    box-shadow: 0 15px 30px rgba(212,175,55,0.5);
}

.collage .big{
    grid-row:span 2;
}

/* -------- ABOUT -------- */
.about{
   background: #d2a8b4ff;
    padding:80px;
    text-align:center;
    border-top:3px solid #7B1E3A;
    border-bottom:3px solid #7B1E3A;
    border-radius:25px;
}

.about p{
    max-width:750px;
    margin:auto;
    font-size:20px;
    line-height:1.8;
    color: #ffffffff;
    font-family:'Playfair Display',serif;
}
    

/* -------- BEST DESIGNS -------- */
.best{
    padding:70px;
    text-align:center;
}

.best-box{
    display:flex;
    justify-content:center;
    gap:30px;
    margin-top:40px;
}

.best-box img{
    width:260px;
    border-radius:25px;
    border:2px solid #7B1E3A;
    box-shadow:0 10px 25px rgba(0,0,0,0.25);
    transition:0.3s;
}
.best-box img:hover{
    transform:scale(1.05);
}

/* -------- FOOTER -------- */
footer{
    background:#7B1E3A;
    text-align:center;
    padding:25px;
    color:white;
    font-size:16px;
    font-weight:500;
    letter-spacing:1px;
}

/* -------- ANIMATION -------- */
@keyframes popup{
    from{opacity:0; transform:translateY(30px);}
    to{opacity:1; transform:translateY(0);}
}
</style>
</head>

<body>

<!-- HEADER -->
<header>
   <div class="logo">
        
        <h2>Sweet Cake House</h2>
    </div>
    <nav>
        <a href="#">Home</a>
        <a href="shop.php">Cakes</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <a href="login.php">Login</a>
    </nav>
</header>

<!-- HERO -->
<section class="hero">
    <div class="hero-text">
        <h1>Luxury Cakes for<br>Every Celebration</h1>
        <p>Wedding, Birthday & Custom cakes crafted with premium flavours.</p><br>
        <button><a href="shop.php">Order Now</a></button>
    </div>

    <div class="hero-images">
        <img src="images/20.jpg" class="hero-img img1">
        <img src="images/8.jpg" class="hero-img img2">
        <img src="images/25.jpg" class="hero-img img3">
    </div>
</section>


<!-- COLLAGE -->
<section class="collage-section">
    <div class="side-text">
    Premium ingredients used<br>
    for the finest cakes<br>
    crafted with love
    </div>

    <div class="collage">
        <img src="images/16.jpg" class="big">
        <img src="images/30.jpg">
        <img src="images/26.jpg">
        <img src="images/23.jpg">
        <img src="images/22.jpg" class="big">
    </div>

    <div class="side-text">
    Elegant designs that<br>
    make celebrations<br>
    unforgettable
    </div>
</section>

<!-- ABOUT -->
<section class="about">
    <h2>About Our Cake Shop</h2>
    <p>
        Sweet Cake House offers a wide variety of delicious flavours and
        beautifully designed cakes. Every cake is freshly baked with love,
        bringing sweetness and elegance to your special moments.
    </p>
</section>

<!-- BEST DESIGNS -->
<section class="best">
    <h2>Our Best Designs</h2>
    <div class="best-box">
        <img src="images/17.jpg">
        <img src="images/13.jpg">
        <img src="images/14.jpg">
    </div>
</section>

<!-- FOOTER -->
<footer>
    © 2025 Sweet Cake House | Designed with Love
</footer>

</body>
</html>
