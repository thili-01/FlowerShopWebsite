<?php
include 'connection.php';

if (isset($_POST['submit-btn'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);

    $select_user = mysqli_query(
        $conn,
        "SELECT * FROM users WHERE email = '$email'"
    ) or die(mysqli_error($conn));

    if (mysqli_num_rows($select_user) > 0) {
        $message[] = 'User already exists';
    } else {
        if ($password != $cpassword) {
            $message[] = 'Passwords do not match';
        } else {
            mysqli_query(
                $conn,
                "INSERT INTO users (name, email, password) VALUES ('$name','$email','$password')"
            ) or die(mysqli_error($conn));

            $message[] = 'Registered successfully';
            header('location:login.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <title>User Registration Page</title>
    </head>
    <body>
        <?php
            if (isset($message)) {
                foreach ($message as $message) {
                    echo '
                        <div class="message">
                            <span>' .$message.'</span>
                            <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
                        </div>
                        ';
                }
            }
        ?>
       <section class="form-container">
        <form action="" method="post">
            <h3>Register Now</h3>
            Name <input type="text" name="name" placeholder="Enter your name" required>
            <br>
            Email <input type="email" name="email" placeholder="Enter your email" required>
            Password <input type="password" name="password" placeholder="Enter your password" required>
            Confirm Password <input type="password" name="cpassword" placeholder="Renter your password" required>
            <input type="submit" name="submit-btn" class="btn" value="Register Now">
            <p><center> Already Have an Account? <a href="login.php">Login Now </a></p>
        </form>
        </section>
    </body> 
</html>