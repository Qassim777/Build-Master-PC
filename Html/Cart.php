<?php
session_start();

// Function to check if a user is logged in
function isLoggedIn()
{
    return isset($_SESSION['First_Name']) && isset($_SESSION['UserID']);
}

if (!isset($_SESSION['UserID'])) {
    header('Location: ../php/checklogin.php');
    exit();
}

function calculateTotal($cartItems)
{
    $subtotal = 0;
    if ($cartItems) {
        foreach ($cartItems as $item) {
            $subtotal += $item['Price'] * $item['Cart_Quantity']; // Ensure correct keys
        }
        $vatRate = 0.15;
        $vat = $subtotal * $vatRate;
        $total = $subtotal + $vat;
        return ['subtotal' => $subtotal, 'vat' => $vat, 'total' => $total];
    } else {
        return ['subtotal' => 0, 'vat' => 0, 'total' => 0];
    }
}

$total_items = 0;
$total_price = 0;

try {
    // Connect to the database
    $database = mysqli_connect('localhost:3307:3307', 'root', '', 'build_master_pc');
    if (!$database) {
        throw new Exception("Failed to connect to the database");
    }

    // Retrieve the cart items for the logged-in user
    $user_id = $_SESSION['UserID'];
    $query = "SELECT cartitems.*, product.Pro_Name, product.Price, product.picture FROM cartitems 
              JOIN cart ON cartitems.Cart_CartID = cart.CartID 
              JOIN product ON cartitems.Product_ProductID = product.ProductID 
              WHERE cart.User_UserID = $user_id";
    $result = mysqli_query($database, $query);

    if (!$result) {
        throw new Exception("Failed to retrieve the cart items");
    }

    $cart_items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $cart_items[] = $row;
    }

    mysqli_close($database);
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    header('Location: ../index.php?problem=DBError#user-login-modal');
    exit;
}

$totals = calculateTotal($cart_items);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="icon" type="image/x-icon" href="../Image/LOGO.png">
    <link rel="stylesheet" href="../css/Cart.css">
    <link rel="stylesheet" href="../css/Design.css">

    <style>
        /* Style for the cart items */
        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .cart-item img {
            max-width: 100px;
            margin-right: 10px;
        }

        .cart-details {
            flex-grow: 1;
        }

        .cart-details p {
            font-weight: bold;
            margin: 0;
        }

        .cart-details small {
            color: #888;
        }

        /* Style for the quantity input */
        .quantity-input {
            width: 40px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        /* Style for the remove button */
        .remove-button {
            background-color: #ff3333;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }

        .remove-button:hover {
            background-color: #cc0000;
        }

        /* Style for the total price section */
        .total-price {
            margin-top: 20px;
            font-weight: bold;
        }

        .total-price table {
            width: 100%;
        }

        .total-price td {
            padding: 5px 0;
        }

        /* Style for the Proceed to Payment button */
        .button-76 {
            background-color: #ff9900;
            color: #ffffff;
            border: 2px solid #ff9900;
            padding: 10px 20px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }

        .button-76:hover {
            background-color: #ffcc00;
            border-color: #ffcc00;
        }
    </style>
</head>

<header>
    <a href="../Index.php">
        <img class="logo" src="../Image/LOGO.png" alt="BUILDMASTERPC logo" width="20%" height="20%">
    </a>
    <nav>
        <ul class="nav_links">
            <li><a href="../php/PCs.php">PC's</a></li>
            <li><a href="../php/PC's_Part_Filter.php">Pc Parts</a></li>
            <li><a href="../php/Accessories.php">Accessories</a></li>
            <li><a href="../php/order_history.php">Order History</a></li>
        </ul>
    </nav>
    <nav>
        <ul class="nav_links">
            <li><a href="../Html/Contact_Us.php"><img src="../Image/icons8-support-64.png" alt="Support icon"
                        height="30" width="30px"></a></li>
            <li><a href="../php/Search.php"><img src="../Image/icons8-search-50.png" alt="Search icon" height="30px"
                        width="30px"></a></li>
            <li><a href="#"><img src="../Image/icons8-cart-64.png" alt="Cart icon" height="30px" width="30px"></a></li>
            <li>
                <?php if (isLoggedIn()): ?>
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['First_Name']); ?></span> <br>
                    <a href="../php/logout.php" class="button" style="color: red;">Logout</a>
                <?php else: ?>
                    <a href="#" data-modal-target="#login-choices-modal">
                        <img src="../Image/login.png" alt="Login icon" height="30px" width="30px">
                    </a>
                <?php endif; ?>
            </li>
        </ul>
    </nav>
</header>

<body>
    <?php if (empty($cart_items)): ?>
        <h1 class="heading">Your cart is empty.</h1>
    <?php else: ?>
        <table>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Remove</th>
                <th>Total Price</th>
            </tr>
            <?php foreach ($cart_items as $item): ?>
                <tr>
                    <td>

                        <div class="cart-item">
                            <img src="<?php echo './admin/image/' . $item['picture']; ?>" alt="<?php echo $item['Pro_Name']; ?>"
                                style="max-width: 100px;">
                            <div class="cart-details">
                                <p><?php echo $item['Pro_Name']; ?></p>
                                <small>Price: <?php echo $item['Price']; ?> SAR</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <form action="../php/Cart_Handlers/update_cart.php" method="post" class="quantity-form">
                            <input type="hidden" name="ProductID" value="<?php echo $item['Product_ProductID']; ?>">
                            <input type="text" name="quantity" class="quantity-input"
                                value="<?php echo $item['Cart_Quantity']; ?>" onchange="this.form.submit()">
                        </form>
                    </td>
                    <td>
                        <form action="../php/Cart_Handlers/remove_from_cart.php" method="post">
                            <input type="hidden" name="ProductID" value="<?php echo $item['Product_ProductID']; ?>">
                            <button type="submit" class="remove-button">Remove</button>
                        </form>
                    </td>
                    <td><?php echo $item['Price'] * $item['Cart_Quantity']; ?> SAR</td>
                </tr>
                <?php $total_items += $item['Cart_Quantity'];
                $total_price += $item['Price'] * $item['Cart_Quantity']; ?>
            <?php endforeach; ?>
        </table>
        <div class="total-price">
            <table>
                <tr>
                    <td>Subtotal</td>
                    <td><?php echo $totals['subtotal']; ?> SAR</td>
                </tr>
                <tr>
                    <td>VAT (15%)</td>
                    <td><?php echo $totals['vat']; ?> SAR</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td><?php echo $totals['total']; ?> SAR</td>
                </tr>
            </table>
        </div>
        <a href="../php/payment.php" class="button-76">Proceed to Payment</a>
    <?php endif; ?>
    <script>
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function () {
                this.closest('form').submit();
            });
        });
    </script>
</body>


<footer class="footer">
    <div class="footer__addr">
        <h1 class="footer__logo" style="padding-bottom: 0px;">
            <img class="logo" src="../Image/LOGO.png" alt="BUILDMASTERPC logo" width="10%" height="10%">
        </h1>
        <h2>Support</h2>
        <address>
            IAU - Al Khobar - Saudi Arabia<br>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d228791.7317672436!2d49.992540180581884!3d26.36304025059799!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e49ef85c961edaf%3A0x7b2db98f2941c78c!2sImam%20Abdulrahman%20Bin%20Faisal%20University!5e0!3m2!1sen!2ssa!4v1672229820933!5m2!1sen!2ssa"
                width="200" height="100" style="border:0" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
            <a class="footer__btn" href="#">Customer Service</a>
            <a class="footer__btn" href="../Html/Contact_Us.php">Contact Us</a>
        </address>
    </div>
    <ul class="footer__nav">
        <li class="nav__item">
            <h2 class="nav__title">COMPANY</h2>
            <ul class="nav__ul">
                <li><a href="#">About Us</a></li>
                <li><a href="#">Terms & Conditions</a></li>
                <li><a href="#">Warranty Policy</a></li>
                <li><a href="#">Return Policy</a></li>
                <li><a href="#">Shipping Policy</a></li>
                <li><a href="#">VAT Registration Number</a></li>
            </ul>
        </li>
        <li class="nav__item">
            <h2 class="nav__title">PRODUCT</h2>
            <ul class="nav__ul">
                <li><a href="../php/PCs.php">PC's</a></li>
                <li><a href="./PC's_Part_Filter.php">Pc Parts</a></li>
                <li><a href="./Accessories.php">Accessories</a></li>
            </ul>
        </li>
        <li class="nav__item">
            <h2 class="nav__title">We Accept Payment Via</h2>
            <ul class="nav__ul">
                <li><img src="../Image/mada.png" alt="mada" width="25%"></li>
                <li><img src="../Image/visa.png" alt="visa" width="25%"></li>
                <li><img src="../Image/master.png" alt="master" width="25%"></li>
            </ul>
        </li>
    </ul>
    <div class="legal">
        <p>&copy; 2024 BUILDMASTERPC. All rights reserved.</p>
        <div class="legal__links">
            <a href=""><img src="../Image/whatsapp.png" alt="Whatsapp" width="40%"></a>
            <a href=""><img src="../Image/linkedin.png" alt="linkedin" width="40%"></a>
            <a href=""><img src="../Image/x.png" alt="X" width="40%"></a>
        </div>
    </div>
</footer>

</html>