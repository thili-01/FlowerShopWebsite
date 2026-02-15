<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$admin_name  = $_SESSION['admin_name'] ?? 'Admin';
$admin_email = $_SESSION['admin_email'] ?? 'Not available';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<title>Document</title>
</head>
<body>
<header class="header">
    <div class="flex">

        <a href="admin.php" class="logo">
            Admin<span>Panel</span>
        </a>

        <nav class="navbar">
            <a href="admin.php">Home</a>
            <a href="admin_product.php">Products</a>
            <a href="admin_orders.php">Orders</a>
            <a href="admin_user.php">Users</a>
            <a href="admin_message.php">Message</a>
        </nav>

        <div class="icons">
            <i class="bi bi-list" id="menu-btn"></i>
            <i class="bi bi-person" id="user-btn"></i>
        </div>

        <div class="user-box">
            <p>Username :
                <span><?php echo htmlspecialchars($admin_name); ?></span>
            </p>
            <p>Email :
                <span><?php echo htmlspecialchars($admin_email); ?></span>
            </p>

            <form method="post" class="logout">
                <button type="submit" name="logout" class="logout-btn">
                    LOG OUT
                </button>
            </form>
        </div>

    </div>
</header>