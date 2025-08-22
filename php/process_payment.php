<?php
session_start();

if (!isset($_SESSION['UserID'])) {
    header('Location: ../php/checklogin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['UserID'];
    $payment_method = $_POST['payment_method'];
    $total_amount = $_POST['total_amount'];

    if ($payment_method === 'Credit Card') {
        $card_number = $_POST['card_number'];
        $card_name = $_POST['card_name'];
        $expiry_date = $_POST['expiry_date'];
        $cvv = $_POST['cvv'];

        // Basic validation for credit card details
        if (!preg_match('/^(\d{4}-\d{4}-\d{4}-\d{4}|\d{16})$/', $card_number)) {
            die("Invalid card number. The CC# must be 16 digits in length and can be in either form: ####-####-####-#### or ################.");
        }
        if (empty($card_name)) {
            die("Card name is required.");
        }
        if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $expiry_date)) {
            die("Invalid expiry date. The Exp must be in the form: MM/YY.");
        }
        if (!preg_match('/^\d{3}$/', $cvv)) {
            die("Invalid CVV. The CVV must be 3 digits.");
        }
    }

    try {
        // Connect to the database
        $database = mysqli_connect('localhost:3307:3307', 'root', '', 'build_master_pc');
        if (!$database) {
            throw new Exception("Failed to connect to the database");
        }

        // Start transaction
        mysqli_begin_transaction($database);

        // Insert order
        $order_query = "INSERT INTO `order` (User_UserID, Total_Price) VALUES ($user_id, $total_amount)";
        if (!mysqli_query($database, $order_query)) {
            throw new Exception("Failed to insert order");
        }

        $order_id = mysqli_insert_id($database);

        // Insert order details
        $cart_query = "SELECT cartitems.*, product.Price FROM cartitems 
                       JOIN cart ON cartitems.Cart_CartID = cart.CartID 
                       JOIN product ON cartitems.Product_ProductID = product.ProductID 
                       WHERE cart.User_UserID = $user_id";
        $cart_result = mysqli_query($database, $cart_query);

        if (!$cart_result) {
            throw new Exception("Failed to retrieve cart items");
        }

        while ($cart_item = mysqli_fetch_assoc($cart_result)) {
            $product_id = $cart_item['Product_ProductID'];
            $quantity = $cart_item['Cart_Quantity'];
            $price = $cart_item['Price'];

            $order_details_query = "INSERT INTO orderdetails (Order_OrderID, Product_ProductID, Details_Quantity, Details_Price) 
                                    VALUES ($order_id, $product_id, $quantity, $price)";
            if (!mysqli_query($database, $order_details_query)) {
                throw new Exception("Failed to insert order details");
            }
        }

        // Insert payment
        $payment_query = "INSERT INTO payments (Order_OrderID, PaymentAmount, PaymentMethod) 
                          VALUES ($order_id, $total_amount, '$payment_method')";
        if (!mysqli_query($database, $payment_query)) {
            throw new Exception("Failed to insert payment");
        }

        // Commit transaction
        mysqli_commit($database);

        // Clear cart
        $clear_cart_query = "DELETE FROM cartitems WHERE Cart_CartID IN (SELECT CartID FROM cart WHERE User_UserID = $user_id)";
        if (!mysqli_query($database, $clear_cart_query)) {
            throw new Exception("Failed to clear cart");
        }

        mysqli_close($database);
        header('Location: order_history.php');
        exit();
    } catch (Exception $e) {
        mysqli_rollback($database);
        error_log("Error: " . $e->getMessage());
        header('Location: ../index.php?problem=DBError#user-login-modal');
        exit();
    }
} else {
    header('Location: ../php/Cart.php');
    exit();
}
?>