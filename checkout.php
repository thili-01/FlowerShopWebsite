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


/*------------- order placed -----------*/
if (isset($_POST['order-btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, 'appart no. '.$_POST['appart'].','.$_POST['street'].','.$_POST['city'].','.$_POST['pin']);
    $placed_on = date('d-M-Y');

    $cart_total=0;
    $cart_products[]='';
    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die ('query failed');

    if (mysqli_num_rows($cart_query)>0) {
        while($cart_item = mysqli_fetch_assoc($cart_query)){
            $cart_products[]=$cart_item['name'].'('.$cart_item['quantity'].')';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total+= $sub_total;
        }
    }
    $total_products = implode(',', $cart_products);
    // Insert order and check if it was successful
$insert_order = mysqli_query($conn, "INSERT INTO `orders`(`user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) 
VALUES ('$user_id','$name','$number','$email','$method','$address','$total_products','$cart_total','$placed_on','pending')");

if ($insert_order) {
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id='$user_id'");
    $message[] = 'Order placed successfully';
} else {
    $message[] = 'Failed to place order. Please try again!';
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
    <h1>Checkout</h1>
    <p> Themes and styles also help keep your document coordinated. When you click Design and choose a new </p>
</div>
<div class="checkout-form">
    <h1 class="title">Payment Process</h1>
    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
        
    echo '
        <div class="message">
            <span>'.$msg.'</span>
            <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
        </div>
    ';
}
}
?>
    <div class="display-order">
        <?php
$select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id'");

if(!$select_cart){
    die("Query Failed: " . mysqli_error($conn));
}

$total = 0;
$grand_total = 0;

if(mysqli_num_rows($select_cart)>0){
    while($fetch_cart=mysqli_fetch_assoc($select_cart)){
        $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
        $total += $total_price;
        $grand_total = $total;
?>
<span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity'];?>)</span>
<?php
    }
}
?>
        <span class="grand-total">Total Amount Payable : $<?=$grand_total; ?>/-</span>
    </div>

    <form method="post">
        <div class="input-field">
            <label>Your name</label>
            <input type="text" name="name" placeholder="enter your name">
        </div>
        <div class="input-field">
            <label>Your number</label>
            <input type="text" name="number" placeholder="enter your number">
        </div>
        <div class="input-field">
            <label>Your email</label>
            <input type="text" name="email" placeholder="enter your email">
        </div>
        <div class="input-field">
            <label>Select payement method</label><br>
            <select name="method">
                <option selected disabled> Select Payment Method</option>
                <option value="cash on delivery">Cash on delivery</option>
                <option value="credit card">Credit card</option>
                <option value="Online Transfer">Online Transfer</option>
                <option value="koko">KoKo Payment</option>
            </select>
        </div>
         <div class="input-field">
            <label>Address Line 1:</label>
            <input type="text" name="appart" placeholder="e.g appart no.">
        </div>
         <div class="input-field">
            <label>Address Line 2:</label>
            <input type="text" name="street" placeholder="e.g street name">
        </div>
         <div class="input-field">
            <label>City</label>
            <input type="text" name="city" placeholder="e.g Kurunegala">
        </div>
         <div class="input-field">
            <label>Pin code</label>
            <input type="number" name="pin" placeholder="e.g 60000">
        </div>
        <input type="submit" name="order-btn" class="btn" value="order now">
    </form>
</div>

<?php include 'footer.php'; ?>


<script src="script.js"></script>
</body>
</html>