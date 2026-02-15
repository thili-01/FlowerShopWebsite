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

/*------------- adding products to wishlist -----------*/
if (isset($_POST['add_to_wishlist'])) {

    $product_id    = $_POST['product_id'];
    $product_name  = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    // check wishlist
    $wishlist_number = mysqli_query(
        $conn,
        "SELECT * FROM `wishlist` 
         WHERE name = '$product_name' AND user_id = '$user_id'"
    ) or die('wishlist query failed');

    // check cart
    $cart_number = mysqli_query(
        $conn,
        "SELECT * FROM `cart` 
         WHERE name = '$product_name' AND user_id = '$user_id'"
    ) or die('cart query failed');

    if (mysqli_num_rows($wishlist_number) > 0) {
        $message[] = 'Product already exists in wishlist';

    } elseif (mysqli_num_rows($cart_number) > 0) {
        $message[] = 'Product already exists in cart';

    } else {
        mysqli_query(
            $conn,
            "INSERT INTO `wishlist` (user_id, pid, name, price, image) 
             VALUES ('$user_id','$product_id','$product_name','$product_price','$product_image')"
        ) or die('insert query failed');

        $message[] = 'Product successfully added to wishlist';
    }
}
/*------------- adding products to cart -----------*/
if (isset($_POST['add_to_cart'])) {

    $product_id    = $_POST['product_id'];
    $product_name  = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    // check cart
    $cart_number = mysqli_query(
        $conn,
        "SELECT * FROM `cart` 
         WHERE name = '$product_name' AND user_id = '$user_id'"
    ) or die('cart query failed');

    if (mysqli_num_rows($cart_number) > 0) {
        $message[] = 'Product already exists in cart';

    } else {
        mysqli_query(
            $conn,
            "INSERT INTO `cart` (user_id, pid, name, price, quantity,image) 
             VALUES ('$user_id','$product_id','$product_name','$product_price','$product_quantity','$product_image')"
        ) or die('insert query failed');

        $message[] = 'Product successfully added to cart';
    }
}
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
    <h1>Product details</h1>
    <p> Themes and styles also help keep your document coordinated. When you click Design and choose a new </p>
</div>
<?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '<div class="message">
                <span>'.$message.'</span>
                <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i></div>';
        }
    }
    ?>
    
    <div class="view_page">
   <?php
    if (isset($_GET['pid'])) {
        $pid = $_GET['pid'];

        $select_products = mysqli_query($conn, "SELECT * FROM products WHERE id = '$pid' LIMIT 1") or die('query failed');

        if (mysqli_num_rows($select_products) > 0) {
            $fetch_products = mysqli_fetch_assoc($select_products);
   ?>
    <form action="" method="post" class="product-box">
        <!-- Left: Product Image -->
        <div class="product-image">
            <img src="image/<?php echo $fetch_products['image']; ?>" alt="">
        </div>

        <!-- Right: Product Details -->
        <div class="product-details">
            <h2 class="name"><?php echo $fetch_products['name']; ?></h2>
            <p class="price">$<?php echo $fetch_products['price']; ?>/-</p>
            <p class="description"><?php echo $fetch_products['product_detail']; ?></p>

            <div class="actions">
                <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">

                <button type="submit" name="add_to_wishlist" class="wishlist-btn bi bi-heart" title="Add to Wishlist"></button>

                <input type="number" name="product_quantity" value="1" min="1" class="quantity">
                
                <button type="submit" name="add_to_cart" class="cart-btn bi bi-cart" title="Add to Cart"></button>
            </div>
        </div>
    </form>
   <?php 
        } 
    } 
   ?>
</div>
<?php include 'footer.php'; ?>

<script src="script.js"></script>
</body>
</html>