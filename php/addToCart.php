<?php
session_start();

if (!isset($_SESSION['UserID'])) {
    header("Location: ./checklogin.php");
    exit;
}

// Initialize the cart if it is not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Check if the required POST data is present
if (isset($_POST['ProductID']) && isset($_POST['Pro_Name']) && isset($_POST['Price']) && isset($_POST['picture']) && isset($_POST['Quantity'])) {
    $product_id = $_POST['ProductID'];
    $product_name = $_POST['Pro_Name'];
    $product_price = $_POST['Price'];
    $product_image = $_POST['picture'];
    $quantity = intval($_POST['Quantity']); // Get the quantity from the form

    // Connect to the database
    $database = mysqli_connect('localhost:3307:3307', 'root', '', 'build_master_pc');
    if (!$database) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if the user already has a cart
    $user_id = $_SESSION['UserID'];
    $query = "SELECT CartID FROM cart WHERE User_UserID = $user_id";
    $result = mysqli_query($database, $query);

    if (mysqli_num_rows($result) > 0) {
        // If the user already has a cart, get the CartID
        $row = mysqli_fetch_assoc($result);
        $cart_id = $row['CartID'];
    } else {
        // If the user does not have a cart, create one
        $query = "INSERT INTO cart (User_UserID) VALUES ($user_id)";
        if (!mysqli_query($database, $query)) {
            die("Error: " . mysqli_error($database));
        }
        $cart_id = mysqli_insert_id($database);
    }

    // Check if the product is already in the cart
    $query = "SELECT * FROM cartitems WHERE Cart_CartID = $cart_id AND Product_ProductID = $product_id";
    $result = mysqli_query($database, $query);

    if (mysqli_num_rows($result) > 0) {
        // If the product is already in the cart, update the quantity
        $query = "UPDATE cartitems SET Cart_Quantity = Cart_Quantity + $quantity WHERE Cart_CartID = $cart_id AND Product_ProductID = $product_id";
    } else {
        // If the product is not in the cart, add it as a new item with the specified quantity
        $query = "INSERT INTO cartitems (Cart_CartID, Product_ProductID, Cart_Quantity) VALUES ($cart_id, $product_id, $quantity)";
    }

    if (!mysqli_query($database, $query)) {
        die("Error: " . mysqli_error($database));
    }

    mysqli_close($database);

    echo "Product added to cart.";
    header("Location: ../Html/Cart.php");
    exit();
} else {
    echo "Invalid request.";
    header("Location: ../Index.php");
    exit();
}
?>