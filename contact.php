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


/*------------- Send message -----------*/
if (isset($_POST['submit-btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email='$email' AND number = '$number' AND message='$message'") or die('query failed');
    if (mysqli_num_rows($select_message)>0) {
        echo 'message already send';
    }else{
        mysqli_query($conn, "INSERT INTO `message` (`user_id`,`name`,`email`,`number`,`message`) VALUES('$user_id','$name','$email','$number','$message')") or die ('query failed');
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
    <h1>Contact Us</h1>
    <p> Themes and styles also help keep your document coordinated. When you click Design and choose a new </p>
</div>

<div class="help">
    <h1 class="title">Need Help?</h1>
    <div class="box-container">
        <div class="box">
            <div>
                <img src="image/address.png">
                <h2>Address</h2>
            </div>
            <p>Reading is easier, too, in the new Reading view. You can collapse parts of the document and focus on the text you want.</p>
        </div>

         <div class="box">
            <div>
                <img src="image/open.png">
                <h2>Opening</h2>
            </div>
            <p>Reading is easier, too, in the new Reading view. You can collapse parts of the document and focus on the text you want.</p>
        </div>

         <div class="box">
            <div>
                <img src="image/contact.png">
                <h2>Our Contact</h2>
            </div>
            <p>Reading is easier, too, in the new Reading view. You can collapse parts of the document and focus on the text you want.</p>
        </div>
         <div class="box">
            <div>
                <img src="image/offers.png">
                <h2>Special Offers</h2>
            </div>
            <p>Reading is easier, too, in the new Reading view. You can collapse parts of the document and focus on the text you want.</p>
        </div>
    </div>
</div>
<div class="form-container">
    <div class="form-section">
        <form method="post">
            <h1>Send us your question</h1>
            <p>We'll get back to you within two days</p>
            <div class="input-field">
                <label>Your Name</label>
                <input type="text" name="name">
            </div>
            <div class="input-field">
                <label>Your Email</label>
                <input type="text" name="email">
            </div>
            <div class="input-field">
                <label>Your Number</label>
                <input type="number" name="number">
            </div>
            <div class="input-field">
                <label>Message</label>
                <textarea name="message"></textarea>
            </div>
            <input type="submit" name="submit-btn" class="btn" value="send message">
        </form>
    </div>
</div>


<?php include 'footer.php'; ?>


<script src="script.js"></script>
</body>
</html>