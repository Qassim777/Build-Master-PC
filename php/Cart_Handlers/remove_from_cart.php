<?php
session_start();

if (!isset($_SESSION['UserID'])) {
    header("Location: ../php/checklogin.php");
    exit();
}

if (isset($_POST['ProductID'])) {
    $product_id = $_POST['ProductID'];
    $user_id = $_SESSION['UserID'];

    // Connect to the database
    $database = mysqli_connect('localhost:3307:3307', 'root', '', 'build_master_pc');
    if (!$database) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get the CartID for the user
    $query = "SELECT CartID FROM cart WHERE User_UserID = $user_id";
    $result = mysqli_query($database, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $cart_id = $row['CartID'];

        // Remove the product from the cart items
        $query = "DELETE FROM cartitems WHERE Cart_CartID = $cart_id AND Product_ProductID = $product_id";
        if (!mysqli_query($database, $query)) {
            die("Error: " . mysqli_error($database));
        }

        // Optionally, remove the product from the session cart if the session is used to store cart items
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $index => $item) {
                if ($item['Product_ProductID'] == $product_id) {
                    unset($_SESSION['cart'][$index]);
                    $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array
                    break;
                }
            }
        }

        mysqli_close($database);
        header('Location: ../../Html/Cart.php');
        exit();
    } else {
        mysqli_close($database);
        die("Error: User cart not found");
    }
} else {
    echo "Invalid request.";
    header("Location: ../../Html/Cart.php");
    exit();
}
?>