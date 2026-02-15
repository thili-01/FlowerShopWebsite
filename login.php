<?php
include 'connection.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ---------- LOGIN LOGIC ---------- */
if (isset($_POST['submit-btn'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $select_user = mysqli_query(
        $conn,
        "SELECT * FROM users WHERE email = '$email' LIMIT 1"
    ) or die(mysqli_error($conn));

    if (mysqli_num_rows($select_user) > 0) {

        $row = mysqli_fetch_assoc($select_user);

        // ✅ PLAIN PASSWORD CHECK (your current DB)
        if ($password == $row['password']) {

            // ---------- ADMIN LOGIN ----------
            if ($row['user_type'] === 'admin') {

                $_SESSION['admin_id']    = $row['id'];
                $_SESSION['admin_name']  = $row['name'];
                $_SESSION['admin_email'] = $row['email'];

                header('location:admin.php');
                exit;

            }
            // ---------- USER LOGIN ----------
            else {

                $_SESSION['user_id']    = $row['id'];
                $_SESSION['user_name']  = $row['name'];
                $_SESSION['user_email'] = $row['email'];

                header('location:index.php');
                exit;
            }

        } else {
            $_SESSION['message'] = 'Wrong email or password';
        }

    } else {
        $_SESSION['message'] = 'Wrong email or password';
    }

    header('location:login.php');
    exit;
}

/* ---------- MESSAGE HANDLING ---------- */
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
</head>
<body>

<?php
if (isset($message)) {
    echo '
        <div class="message">
            <span>'.$message.'</span>
            <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
        </div>
    ';
}
?>

<section class="form-container">
    <form action="" method="post">
        <h3>Login</h3>

        Email
        <input type="email" name="email" placeholder="Enter your email" required>

        Password
        <input type="password" name="password" placeholder="Enter your password" required>

        <input type="submit" name="submit-btn" class="btn" value="Login Now">

        <p style="text-align:center;">
            Do not have an account?
            <a href="register.php">Register Now</a>
        </p>
    </form>
</section>

</body>
</html>