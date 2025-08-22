<?php
session_start();

// Function to check if a user is logged in
function isLoggedIn()
{
    return isset($_SESSION['First_Name']) && isset($_SESSION['UserID']);
}

if (!isLoggedIn()) {
    header('Location: ../php/checklogin.php');
    exit();
}

try {
    // Connect to the database
    $database = mysqli_connect('localhost:3307:3307', 'root', '', 'build_master_pc');
    if (!$database) {
        throw new Exception("Failed to connect to the database");
    }

    $user_id = $_SESSION['UserID'];
    $query = "SELECT cartitems.*, product.Pro_Name, product.Price FROM cartitems 
              JOIN cart ON cartitems.Cart_CartID = cart.CartID 
              JOIN product ON cartitems.Product_ProductID = product.ProductID 
              WHERE cart.User_UserID = $user_id";
    $result = mysqli_query($database, $query);

    if (!$result) {
        throw new Exception("Failed to retrieve the cart items");
    }

    $cart_items = [];
    $total_amount = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $cart_items[] = $row;
        $total_amount += $row['Price'] * $row['Cart_Quantity'];
    }

    mysqli_close($database);
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    header('Location: ../index.php?problem=DBError#user-login-modal');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="../css/Design.css">
    <link rel="stylesheet" href="../css/payment.css">
</head>

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
            <li><a href=""><img src="../Image/icons8-search-50.png" alt="Search icon" height="30px" width="30px"></a>
            </li>
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
    <div class="payment-container">
        <h1>Payment</h1>
        <form id="payment-form" action="process_payment.php" method="post">
            <div class="payment-option">
                <input type="radio" id="cash" name="payment_method" value="Cash" checked>
                <label for="cash">Cash</label>
            </div>
            <div class="payment-option">
                <input type="radio" id="credit_card" name="payment_method" value="Credit Card">
                <label for="credit_card">Credit Card</label>
                <div id="credit_card_details" style="display: none;">
                    <input type="text" id="card_number" name="card_number" placeholder="Card Number"
                        pattern="^(\d{4}-\d{4}-\d{4}-\d{4}|\d{16})$" required>
                    <input type="text" id="card_name" name="card_name" placeholder="Name on Card" required>
                    <input type="text" id="expiry_date" name="expiry_date" placeholder="Expiry Date (MM/YY)"
                        pattern="(0[1-9]|1[0-2])\/\d{2}" required>
                    <input type="text" id="cvv" name="cvv" placeholder="CVV" pattern="\d{3}" required>
                    <div id="cc_error" style="color: red; display: none;">Please enter a valid credit card number and
                        expiry date.</div>
                </div>
            </div>
            <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>">
            <button type="submit">Proceed to Payment</button>
        </form>
    </div>

    <script>
        document.getElementById('credit_card').addEventListener('change', function () {
            document.getElementById('credit_card_details').style.display = 'block';
        });
        document.getElementById('cash').addEventListener('change', function () {
            document.getElementById('credit_card_details').style.display = 'none';
        });

        document.getElementById('payment-form').addEventListener('submit', function (event) {
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            if (paymentMethod === 'Credit Card') {
                const cardNumber = document.getElementById('card_number').value;
                const expiryDate = document.getElementById('expiry_date').value;
                const cardNumberPattern = /^(\d{4}-\d{4}-\d{4}-\d{4}|\d{16})$/;
                const expiryDatePattern = /^(0[1-9]|1[0-2])\/\d{2}$/;

                if (!cardNumberPattern.test(cardNumber) || !expiryDatePattern.test(expiryDate)) {
                    event.preventDefault();
                    document.getElementById('cc_error').style.display = 'block';
                }
            }
        });
    </script>

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