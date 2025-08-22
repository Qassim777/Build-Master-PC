<?php
session_start();

function isLoggedIn()
{
    return isset($_SESSION['First_Name']) && isset($_SESSION['UserID']);
}

if (!isLoggedIn()) {
    header('Location: ../php/checklogin.php');
    exit();
}

try {
    $database = mysqli_connect('localhost:3307:3307', 'root', '', 'build_master_pc');
    if (!$database) {
        throw new Exception("Failed to connect to the database");
    }

    $user_id = $_SESSION['UserID'];
    $order_query = "SELECT * FROM `order` WHERE User_UserID = $user_id";
    $order_result = mysqli_query($database, $order_query);

    if (!$order_result) {
        throw new Exception("Failed to retrieve orders");
    }

    $orders = [];
    while ($order = mysqli_fetch_assoc($order_result)) {
        $order_id = $order['OrderID'];
        $order_details_query = "SELECT orderdetails.*, product.Pro_Name FROM orderdetails 
                                JOIN product ON orderdetails.Product_ProductID = product.ProductID 
                                WHERE orderdetails.Order_OrderID = $order_id";
        $order_details_result = mysqli_query($database, $order_details_query);

        if (!$order_details_result) {
            throw new Exception("Failed to retrieve order details");
        }

        $order['details'] = [];
        while ($details = mysqli_fetch_assoc($order_details_result)) {
            $order['details'][] = $details;
        }

        $orders[] = $order;
    }

    mysqli_close($database);
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    header('Location: ../index.php?problem=DBError#user-login-modal');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="../css/Design.css">
    <link rel="stylesheet" href="../css/order_history.css">

</head>

<body>
    <header>
        <a href="../Index.php">
            <img class="logo" src="../Image/LOGO.png" alt="BUILDMASTERPC logo" width="20%" height="20%">
        </a>
        <nav>
            <ul class="nav_links">
                <li><a href="./PCs.php">PC's</a></li>
                <li><a href="./PC's_Part_Filter.php">Pc Parts</a></li>
                <li><a href="./Accessories.php">Accessories</a></li>
            </ul>
        </nav>
        <nav>
            <ul class="nav_links">
                <li><a href="../Html/Contact_Us.php"><img src="../Image/icons8-support-64.png" alt="Support icon"
                            height="30" width="30px"></a></li>
                <li><a href="./Search.php"><img src="../Image/icons8-search-50.png" alt="Search icon" height="30px"
                            width="30px"></a></li>
                <li><a href="../Html/Cart.php"><img src="../Image/icons8-cart-64.png" alt="Cart icon" height="30px"
                            width="30px"></a></li>
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
        <br>
        <div class="order-history-container">
            <h1>Order History</h1>
            <?php if (empty($orders)): ?>
                <p>You have no past orders.</p>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                    <div class="order">
                        <h2>Order ID: <?php echo $order['OrderID']; ?></h2>
                        <p>Date: <?php echo $order['Date']; ?></p>
                        <p>Total: <?php echo $order['Total_Price']; ?> SAR</p>
                        <h3>Details:</h3>
                        <ul>
                            <?php foreach ($order['details'] as $details): ?>
                                <li>
                                    <?php echo $details['Pro_Name']; ?> - Quantity: <?php echo $details['Details_Quantity']; ?> -
                                    Price: <?php echo $details['Details_Price']; ?> SAR
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <br>
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
</body>

</html>