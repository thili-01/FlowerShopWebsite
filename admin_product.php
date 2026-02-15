<?php
include 'connection.php';
session_start();

// ---------- LOGOUT ----------
if (isset($_POST['logout'])) {
    session_destroy();
    header('location:login.php');
    exit();
}

// ---------- ADD PRODUCT ----------
if (isset($_POST['add_product'])) {

    $product_name   = mysqli_real_escape_string($conn, $_POST['name']);
    $product_price  = mysqli_real_escape_string($conn, $_POST['price']);
    $product_detail = mysqli_real_escape_string($conn, $_POST['detail']);

    $image_name = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'image/' . $image_name;

    $select_product = mysqli_query($conn, "SELECT name FROM products WHERE name = '$product_name'") or die(mysqli_error($conn));

    if (mysqli_num_rows($select_product) > 0) {
        $message[] = 'Product name already exists';
    } else {
        $insert_product = mysqli_query(
            $conn,
            "INSERT INTO products (name, price, product_detail, image)
             VALUES ('$product_name', '$product_price', '$product_detail', '$image_name')"
        ) or die(mysqli_error($conn));

        if ($insert_product) {
            if ($image_size > 2000000) {
                $message[] = 'Product image size is too large';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Product added successfully';
            }
        }
    }
}

/*------- deleting products -------*/
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $select_delete_image = mysqli_query($conn, "SELECT image FROM products WHERE id = $delete_id") or die(mysqli_error($conn));
    $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);

    if (!empty($fetch_delete_image['image'])) {
        unlink('image/' . $fetch_delete_image['image']);
    }

    mysqli_query($conn, "DELETE FROM products WHERE id = $delete_id") or die(mysqli_error($conn));
    mysqli_query($conn, "DELETE FROM cart WHERE pid = $delete_id") or die(mysqli_error($conn));
    mysqli_query($conn, "DELETE FROM wishlist WHERE pid = $delete_id") or die(mysqli_error($conn));

   header('location:admin_product.php');
}

/*------------update products---------------*/
if (isset($_POST['update_product'])) {
    $update_p_id = $_POST['update_p_id'];
    $update_p_name = mysqli_real_escape_string($conn, $_POST['update_p_name']);
    $update_p_price = mysqli_real_escape_string($conn, $_POST['update_p_price']);
    $update_p_detail = mysqli_real_escape_string($conn, $_POST['update_p_detail']);

    mysqli_query($conn, "UPDATE products 
         SET name='$update_p_name',
             price='$update_p_price',
             product_detail='$update_p_detail'
         WHERE id=$update_p_id") or die(mysqli_error($conn));

    if (!empty($_FILES['update_p_image']['name'])) {
        $update_p_image = $_FILES['update_p_image']['name'];
        $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
        $update_p_image_size = $_FILES['update_p_image']['size'];
        $update_p_image_folder = 'image/' . $update_p_image;

        if ($update_p_image_size > 2000000) {
            $message[] = 'Image size too large';
        } else {
            $old_image_query = mysqli_query($conn, "SELECT image FROM products WHERE id=$update_p_id");
            $old_image = mysqli_fetch_assoc($old_image_query)['image'];

            if (!empty($old_image)) {
                unlink('image/' . $old_image);
            }

            move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
            mysqli_query($conn, "UPDATE products SET image='$update_p_image' WHERE id=$update_p_id") or die(mysqli_error($conn));
        }
    }

    $message[] = 'Product updated successfully';
    header('location:admin_product.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="css/style.css">
<title>Manage Products</title>
</head>
<body>

<?php include 'admin_header.php'; ?>

<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '<div class="message"><span>' . $msg . '</span>
        <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
        </div>';
    }
}
?>

<!-- ADD PRODUCT FORM -->
<section class="add-products">
    <form method="post" enctype="multipart/form-data">
        <h1 class="title">Add New Product</h1>

        <div class="input-field">
            <label>Product name</label>
            <input type="text" name="name" required>
        </div>

        <div class="input-field"> 
            <label>Product price</label>
            <input type="text" name="price" required>
        </div>

        <div class="input-field">
            <label>Product detail</label>
            <textarea name="detail" required></textarea>
        </div>

        <div class="input-field">
            <label>Product image</label>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" required>
        </div>

        <input type="submit" name="add_product" value="Add Product" class="btn">
    </form>
</section>

<!-- SHOW PRODUCTS -->
<section class="show-products">
<div class="box-container">
<?php
$select_products = mysqli_query($conn, "SELECT * FROM `products`") or die ('query failed');
if(mysqli_num_rows($select_products) > 0){
    while ($fetch_products = mysqli_fetch_assoc($select_products)) {
?>
<div class="box">
    <img src="image/<?php echo $fetch_products['image']; ?>">
    <p>price : $ <?php echo $fetch_products['price']; ?></p>
    <h4><?php echo $fetch_products['name']; ?></h4>
    <p class="detail"><?php echo $fetch_products['product_detail']; ?></p>
    <a href="admin_product.php?edit=<?php echo $fetch_products['id'] ?>" class="edit">edit</a>
    <a href="admin_product.php?delete=<?php echo $fetch_products['id'] ?>" class="delete" onclick="return confirm('delete this product');">delete</a>
</div>
<?php } } ?>
</div>
</section>

<!-- UPDATE PRODUCT FORM -->
<section class="add-products update-container <?php echo isset($_GET['edit']) ? 'active' : ''; ?>">
<?php
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = $edit_id") or die("query failed");
    if (mysqli_num_rows($edit_query) > 0) {
        $fetch_edit = mysqli_fetch_assoc($edit_query);
?>
<form method="post" enctype="multipart/form-data">
    <h1 class="title">Update Product</h1>

    <div class="input-field">
        <label>Product name</label><br>
        <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['id']; ?>">
        <input type="text" name="update_p_name" value="<?php echo $fetch_edit['name']; ?>" required>
    </div>

    <div class="input-field"> 
        <label>Product price</label><br>
        <input type="number" min="0" name="update_p_price" value="<?php echo $fetch_edit['price']; ?>" required>
    </div>

    <div class="input-field">
        <label>Product detail</label><br>
        <textarea name="update_p_detail" required><?php echo $fetch_edit['product_detail']; ?></textarea>
    </div>

    <div class="input-field">
        <label>Product image</label><br>
        <img src="image/<?php echo $fetch_edit['image']; ?>" alt="product image" class="preview-img"><br>
        <input type="file" name="update_p_image" accept="image/png,image/jpg,image/jpeg,image/webp">
    </div>

    <input type="submit" name="update_product" value="Update" class="btn">
    <input type="reset" value="Cancel" class="btn" id="close-edit">
</form>
<?php } } ?>
</section>

<script src="script.js"></script>
</body>
</html>