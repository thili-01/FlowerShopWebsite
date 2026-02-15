<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'connection.php';

// Redirect to login if user not logged in
if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit;
}

$user_id    = $_SESSION['user_id'] ?? null;
$user_name  = $_SESSION['user_name'] ?? '';
$user_email = $_SESSION['user_email'] ?? '';

if (isset($_POST['logout'])) {
    session_destroy();
    header('location:login.php');
    exit;
}

/* Wishlist count */
$wishlist_num_rows = 0;
$cart_num_rows = 0;

if ($user_id) {
    $select_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id = '$user_id'");
    $wishlist_num_rows = mysqli_num_rows($select_wishlist);

    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'");
    $cart_num_rows = mysqli_num_rows($select_cart);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>BloomsBy Thilini</title>
   // <link rel="stylesheet" href="main.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<header class="header">
    <div class="flex">

        <a href="index.php" class="logo">
            BloomsBy <span>Thilini</span>
        </a>

        <nav class="navbar">
            <a href="index.php">Home</a>
            <a href="shop.php">Shop</a>
            <a href="orders.php">Orders</a>
            <a href="about.php">About us</a>
            <a href="contact.php">Contact us</a>
        </nav>

        <div class="icons">
            <i class="bi bi-person" id="user-btn"></i>
            <?php
                $select_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');
                $wishlist_num_rows = mysqli_num_rows($select_wishlist);
            ?>
            <a href="wishlist.php">
                <i class="bi bi-heart"></i>
                <span>(<?php echo $wishlist_num_rows; ?>)</span></a>
            <?php
                $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                $cart_num_rows = mysqli_num_rows($select_cart);
            ?>
            <a href="cart.php"><i class="bi bi-cart"></i><span>(<?php echo $cart_num_rows; ?>)</span></a>
            <i class="bi bi-list" id="menu-btn"></i>
            
        </div>

        <!-- USER INFO BOX -->
        <div class="user-box">
            <p>Username :
                <span><?php echo htmlspecialchars($user_name); ?></span>
            </p>
            <p>Email :
                <span><?php echo htmlspecialchars($user_email); ?></span>
            </p>

            <form method="post">
                <button type="submit" name="logout" class="logout-btn">
                    LOG OUT
                </button>
            </form>
        </div>

    </div>
</header>