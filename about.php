<?php
include 'connection.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Allow ONLY logged users */
if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit;
}
// Make $user_id available for all blocks
$user_id = $_SESSION['user_id'];


?>
<style type="text/css"><?php include 'main.css'; ?></style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <title>Flower Shop</title>
</head>
<body>

<?php include 'header.php'; ?>
    
<div class="banner">
    <h1>About us</h1>
    <p>hdsbfhdsvfbhsvfghsvfgfvg</p>
</div>
<div class="about">
    <div class="row">
        <div class="detail">
            <h1>Visit our showrooms...</h1>
            <p><b>Save time in Word with new buttons that show up where you need them. To change the way a picture fits in your document, click it and a button for layout options appears next to it. When you work on a table, click where you want to add a row or a column, and then click the plus sign.</b></p>
            <a href="shop.php" class="btn2">Shop now</a>
        </div>
        <div class="img-box">
            <img src="image/3.jpg">
        </div>
    </div>
</div>
<div class="banner-2">
    <h1>Let us make your wedding flawless</h1>
    <a href="shop.php" class="btn2">Shop now</a>
</div>

<div class="services">
    <h1 class="title">Our Services</h1>
    <div class="box-container">
        <div class="box">
            <i class="bi bi-percent"></i>
            <h2>30% OFF + FREE SHIPPING</h2>
            <p>StartinG at $30/mo. Plus, get $120 credit1year on regualar orders</p>
        </div>
        <div class="box">
            <i class="bi bi-asterisk"></i>
            <h2>FRESHEST BLOOMS</h2>
            <p>Exclusive farm-fresh flowers with our Happiness Gurantee</p>
        </div>
        <div class="box">
            <i class="bi bi-alarm"></i>
            <h2>SUPER FLEXIBLE</h2>
            <p>Customize recepient,date, or flowers. Skip or cancel anytime</p>
        </div>
    </div>
</div>
<div class="stylist">
    <h1 class="title">Floral stylist</h1>
    <p>Meet the team that nakes miracles happen...</p>
    <div class="box-container">
        <div class="box">
            <div class="img-box">
                <img src="image/6.jpg">
                <div class="social-links">
                    <i class="bi bi-instagram"></i>
                    <i class="bi bi-facebook"></i>
                    <i class="bi bi-tiktok"></i>
                    <i class="bi bi-whatsapp"></i>
                </div>
            </div>
            <h2>Thilini Senarathne</h2>
            <p>Developer</p>
        </div>
        <div class="box">
            <div class="img-box">
                <img src="image/7.jpg">
                <div class="social-links">
                    <i class="bi bi-instagram"></i>
                    <i class="bi bi-facebook"></i>
                    <i class="bi bi-tiktok"></i>
                    <i class="bi bi-whatsapp"></i>
                </div>
            </div>
            <h2>Piumi Senarathne</h2>
            <p>Developer</p>
        </div>
        <div class="box">
            <div class="img-box">
                <img src="image/9.jpg">
                <div class="social-links">
                    <i class="bi bi-instagram"></i>
                    <i class="bi bi-facebook"></i>
                    <i class="bi bi-tiktok"></i>
                    <i class="bi bi-whatsapp"></i>
                </div>
            </div>
            <h2>Sarani Senarathne</h2>
            <p>Developer</p>
        </div>
    </div>
</div>
<div class="testimonial-container">
    <h1 class="title">What People Say</h1>

    <div class="testimonial-grid">

        <div class="testimonial-box">
            <img src="image/6.jpg" alt="Thilini Senarathne">
            <h2>Thilini Senarathne</h2>
            <p>Video provides a powerful way to help you prove your point...</p>
        </div>

        <div class="testimonial-box">
            <img src="image/7.jpg" alt="Piumi Senarathne">
            <h2>Piumi Senarathne</h2>
            <p>Video provides a powerful way to help you prove your point...</p>
        </div>

        <div class="testimonial-box">
            <img src="image/9.jpg" alt="Sarani Senarathne">
            <h2>Sarani Senarathne</h2>
            <p>Video provides a powerful way to help you prove your point...</p>
        </div>

    </div>
</div>
<?php include 'footer.php'; ?>


<script src="script.js"></script>
</body>
</html>