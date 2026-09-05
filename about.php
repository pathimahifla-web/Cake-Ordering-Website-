<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>About Sweet Cake House</title>

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

/* HEADINGS */
h1,h2,h3{
    font-family:'Playfair Display',serif;
}

/* HEADER */
header{
    background:#7B1E3A;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 60px;
}

.logo{
    display:flex;
    align-items:center;
    gap:10px;
    color:white;
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

/* ABOUT MAIN */
.about{
    background: linear-gradient(to right,#FFF1EA,#F5E6DC);
    padding:80px 50px;
    text-align:center;
    border-radius:30px;
    border-top:4px solid #D4AF37;
    border-bottom:4px solid #D4AF37;
    box-shadow:0 15px 35px rgba(212,175,55,0.2);
}

.about h2{
    font-size:42px;
    color:#7B1E3A;
    margin-bottom:25px;
    text-shadow: 1px 1px 4px rgba(212,175,55,0.3);
}

.about p{
    font-size:20px;
    line-height:1.8;
    max-width:800px;
    margin:auto;
    color:#4A4A4A;
}

.about img{
    width:400px;
    border-radius:25px;
    margin-top:40px;
    box-shadow:0 12px 25px rgba(0,0,0,0.25);
    transition: transform 0.3s, box-shadow 0.3s;
}

.about img:hover{
    transform: scale(1.05);
    box-shadow:0 20px 35px rgba(212,175,55,0.5);
}

/* OUR STORY */
.story{
    padding:70px 50px;
    text-align:center;
}

.story h3{
    font-size:36px;
    color:#7B1E3A;
    margin-bottom:20px;
}

.story p{
    font-size:18px;
    max-width:750px;
    margin:auto;
    line-height:1.7;
}

/* WHY CHOOSE US */
.features{
    display:flex;
    justify-content:space-around;
    align-items:flex-start;
    padding:80px 50px;
    gap:20px;
    flex-wrap:wrap;
}

.feature-box{
   background: #d2a8b4ff;
    padding:40px 25px;
    width:250px;
    border-radius:25px;
    box-shadow:0 12px 30px rgba(218, 162, 169, 0.2);
    transition: transform 0.3s, box-shadow 0.3s;
}

.feature-box:hover{
    transform: scale(1.05);
    box-shadow:0 20px 35px rgba(223, 123, 131, 0.4);
}

.feature-box h3{
    font-size:24px;
    color:#7B1E3A;
    margin-bottom:15px;
}

.feature-box p{
    font-size:16px;
    line-height:1.6;
    color:white;
}

/* GALLERY / MINI COLLAGE */
.gallery{
    display:flex;
    justify-content:center;
    gap:20px;
    padding:70px 50px;
    flex-wrap:wrap;
}

.gallery img{
    width:220px;
    border-radius:20px;
    box-shadow:0 12px 25px rgba(0,0,0,0.25);
    transition: transform 0.3s, box-shadow 0.3s;
}

.gallery img:hover{
    transform: scale(1.1);
    box-shadow:0 20px 35px rgba(212,175,55,0.5);
}

/* FOOTER */
footer{
    background:#7B1E3A;
    text-align:center;
    padding:25px;
    color:white;
    font-size:16px;
    font-weight:500;
    letter-spacing:1px;
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
        <a href="home.php">Home</a>
        <a href="shop.php">Cakes</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <a href="login.php">Login</a>
    </nav>
</header>

<!-- ABOUT MAIN -->
<section class="about">
    <h2>About Our Cake Shop</h2>
    <p>
        At Sweet Cake House, we create premium cakes with love and elegance. 
        Every flavour is carefully crafted, and every design is made to impress. 
        From birthdays to weddings, our cakes bring sweetness and sophistication 
        to every celebration. Our team of expert bakers uses only the finest ingredients.
    </p>
    <img src="images/29.jpg" alt="Delicious Cakes">
</section>

<!-- OUR STORY -->
<section class="story">
    <h3>Our Story</h3>
    <p>
        Sweet Cake House was founded with a passion for creating cakes that delight both eyes and taste buds. 
        Over the years, we have served hundreds of celebrations, making every occasion memorable with our signature designs.
    </p>
</section>

<!-- WHY CHOOSE US -->
<section class="features">
    <div class="feature-box">
        <h3>Premium Ingredients</h3>
        <p>We use only the finest ingredients to ensure the perfect taste in every bite.</p>
    </div>
    <div class="feature-box">
        <h3>Custom Designs</h3>
        <p>Every cake is designed uniquely to match your celebration and personal style.</p>
    </div>
    <div class="feature-box">
        <h3>Fresh & Delicious</h3>
        <p>All our cakes are baked fresh daily and with love, guaranteeing top quality and flavor.</p>
    </div>
</section>

<!-- GALLERY / MINI COLLAGE -->
<section class="gallery">
    <img src="images/35.jpg" alt="Cake 1">
    <img src="images/28.jpg" alt="Cake 2">
    <img src="images/12.jpg" alt="Cake 3">
    <img src="images/23.jpg" alt="Cake 4">
</section>

<!-- FOOTER -->
<footer>
    © 2025 Sweet Cake House | Designed with Love
</footer>

</body>
</html>
