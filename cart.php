<?php
include 'connection.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

/* ---------- UPDATE QUANTITY ---------- */
if (isset($_POST['update_qty'])) {
    $cart_id = $_POST['cart_id'];
    $qty = (int)$_POST['quantity'];

    mysqli_query(
        $conn,
        "UPDATE `cart` SET quantity = $qty WHERE id = $cart_id"
    ) or die(mysqli_error($conn));

    header('location:cart.php');
    exit;
}

/* ---------- DELETE ONE ---------- */
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = $delete_id");
    header('location:cart.php');
    exit;
}

/* ---------- DELETE ALL ---------- */
if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = $user_id");
    header('location:cart.php');
    exit;
}
?>

<style>
<?php include 'main.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Flower Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="banner">
    <h1>My Cart</h1>
    <p>hdsbfhdsvfbhsvfghsvfgfvg</p>
</div>

<div class="shop">
    <h1 class="title">Products added in cart</h1>

    <div class="box-container">
        <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'");

        if (mysqli_num_rows($select_cart) > 0) {

            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {

                $price = (float)$fetch_cart['price'];
                $qty   = (int)$fetch_cart['quantity'];
                $total_amt = $price * $qty;
                $grand_total += $total_amt;
        ?>
            <div class="box">
                <div class="icon">
                    <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="bi bi-x"></a>
                </div>

                <img src="image/<?php echo $fetch_cart['image']; ?>">

                <div class="name"><?php echo $fetch_cart['name']; ?></div>
                <div class="price">$<?php echo $price; ?>/-</div>

                
                <form method="post" class="qty">
                    <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                    <input type="number" name="quantity" min="1" value="<?php echo $qty; ?>">
                    <input type="submit" name="update_qty" value="Update">
                </form>

                <div class="total-amt">
                    Total Amount :
                    <span>$<?php echo $total_amt; ?>/-</span>
                </div>
            </div>
        <?php
            }
        } else {
            echo '
                <div class="empty-wishlist">
                    <img src="image/emptycart.jpg">
                    <p class="empty">No products in your cart yet!</p>
                </div>
            ';
        }
        ?>
    </div>

   
    <div class="dlt-center">
        <a href="cart.php?delete_all"
           class="btn2 <?php echo ($grand_total > 0) ? '' : 'disabled'; ?>"
           onclick="return confirm('Delete all items from cart?')">
           Delete all
        </a>
    </div>

    <div class="wishlist_total">
        <p>Total amount payable : <span>$<?php echo $grand_total; ?>/-</span></p>
        <a href="shop.php" class="btn2">Continue Shopping</a>
        <a href="checkout.php"
           class="btn2 <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">
           Checkout
        </a>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
