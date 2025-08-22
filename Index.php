<?php
session_start();
// Function to check if a user is logged in
function isLoggedIn()
{
    return isset($_SESSION['First_Name']);
}

// Retrieve error parameter to display error messages
$loginError = isset($_GET['error']) ? $_GET['error'] : '';
$signupErrors = isset($_SESSION['signup_errors']) ? $_SESSION['signup_errors'] : '';
unset($_SESSION['signup_errors']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuildMasterPC | Home Page</title>
    <link rel="icon" type="image/x-icon" href="./Image/LOGO.png">
    <link rel="stylesheet" href="./css/Design.css">
    <link rel="stylesheet" href="./css/swiper-bundle.min.css">
    <link rel="stylesheet" href="./css/popupModal.css">
</head>

<body>

    <header>
        <a href="index.php">
            <img class="logo" src="./Image/LOGO.png" alt="BUILDMASTERPC logo" width="20%" height="20%">
        </a>
        <nav>
            <ul class="nav_links">
                <li>
                    <a href="./php/PCs.php">PC's</a>
                </li>
                <li>
                    <a href="./php/PC's_Part_Filter.php">Pc Parts</a>
                </li>
                <li>
                    <a href="./php/Accessories.php">Accessories</a>
                </li>
            </ul>
        </nav>

        <nav>
            <ul class="nav_links">
                <li>
                    <a href="./Html/Contact_Us.php">
                        <img src="./Image/icons8-support-64.png" alt="Support icon" height="30" width="30px">
                    </a>
                </li>
                <li>
                    <a href="./php/Search.php">
                        <img src="./Image/icons8-search-50.png" alt="Search icon" height="30px" width="30px">
                    </a>
                </li>
                <li>
                    <?php if (isLoggedIn()): ?>
                        <a href="./Html/Cart.php">
                            <img src="./Image/icons8-cart-64.png" alt="Cart icon" height="30px" width="30px">
                        </a>
                    <?php else: ?>
                        <a href="#" data-modal-target="#user-login-modal">
                            <img src="./Image/icons8-cart-64.png " alt="Cart icon" height="30px" width="30px">
                        </a>
                    <?php endif; ?>
                </li>
                <li>
                    <?php if (isLoggedIn()): ?>
                        <span>Welcome, <?php echo htmlspecialchars($_SESSION['First_Name']); ?></span> <br>
                        <a href="./php/logout.php" class="button" style="color: red;">Logout</a>
                    <?php else: ?>
                        <a href="#" data-modal-target="#login-choices-modal">
                            <img src="./Image/login.png" alt="Login icon" height="30px" width="30px">
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>

        <div id="overlay"></div>
    </header>

    <!-- Modal: Login Choices -->
    <div class="modal" id="login-choices-modal">
        <div class="modal-header">
            <div class="title">Log in</div>
            <button data-close-button class="close-button">&times;</button>
        </div>
        <div class="modal-body login-choices">
            <div class="pictures" data-modal-target="#admin-login-modal">
                <a href="#">
                    <img src="./Image/icon-admin.png" alt="admin login" width="150">
                </a>
                <div class="description">Admin Login</div>
            </div>
            <div class="pictures" data-modal-target="#user-login-modal">
                <a href="#">
                    <img src="./Image/user-128.png" alt="user login" width="150">
                </a>
                <div class="description">User Login</div>
            </div>
        </div>
    </div>

    <!-- Modal: Admin Login -->
    <div class="modal" id="admin-login-modal">
        <div class="modal-header">
            <div class="title">Admin Log in</div>
            <button data-close-button class="close-button">&times;</button>
        </div>
        <div class="modal-body">
            <button data-back-button class="back-button">&larr; Back</button>
            <div class="">
                <div class="login form">
                    <form action="./php/checklogin.php" method="post">
                        <input type="hidden" name="login_type" value="admin">
                        <input type="text" placeholder="Enter your email" name="email">
                        <input type="password" placeholder="Enter your password" name="password">
                        <input type="submit" class="button" value="Login">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: User Login -->
    <div class="modal" id="user-login-modal">
        <div class="modal-header">
            <div class="title">User Log in</div>
            <button data-close-button class="close-button">&times;</button>
        </div>
        <div class="modal-body">
            <button data-back-button class="back-button">&larr; Back</button>
            <div class="">
                <div class="login form">
                    <form action="./php/checklogin.php" method="post">
                        <input type="hidden" name="login_type" value="user">
                        <input type="text" placeholder="Enter your email" name="email">
                        <input type="password" placeholder="Enter your password" name="password">
                        <input type="submit" class="button" value="Login">
                    </form>
                    <?php if ($loginError): ?>
                        <div class="error-message"><?php echo htmlspecialchars($loginError); ?></div>
                    <?php endif; ?>
                    <div class="signup">
                        <label class="white">You don't have an account?</label>
                        <a href="#" data-modal-target="#sign-up-modal" class="red">Sign up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Sign Up -->
    <div class="modal" id="sign-up-modal">
        <div class="modal-header">
            <div class="title">Sign Up</div>
            <button data-close-button class="close-button">&times;</button>
        </div>
        <div class="modal-body">
            <button data-back-button class="back-button">&larr; Back</button>
            <div class="">
                <div class="registration form">
                    <form action="./php/register.php" method="post">
                        <input type="text" placeholder="Enter your first name" name="firstName">
                        <input type="email" placeholder="Enter your email" name="email">
                        <input type="password" placeholder="Create a password" name="password">
                        <input type="password" placeholder="Confirm your password" name="confirmpassword">
                        <input type="submit" class="button" value="Sign up">
                    </form>
                    <?php if (!empty($signupErrors)): ?>
                        <div class="error-message"><?php echo htmlspecialchars($signupErrors); ?></div>
                    <?php endif; ?>
                    <div class="signup">
                        <label class="white">Already have an account?</label>
                        <a href="#" data-modal-target="#user-login-modal" class="red">Log in</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Reset Password -->
    <div class="modal" id="reset-pass-modal">
        <div class="modal-header">
            <div class="title">Reset Password</div>
            <button data-close-button class="close-button">&times;</button>
        </div>
        <div class="modal-body">
            <button data-back-button class="back-button">&larr; Back</button>
            <div class="login form">
                <form action="#">
                    <input type="text" placeholder="Enter your email">
                    <a href="/index.php"><input type="button" class="button" value="Submit"></a>
                </form>
            </div>
        </div>
    </div>

    <!-- Rest of your page content -->
    <div class="slider-container swiper">
        <div class="slide-content">
            <div class="card-wrapper swiper-wrapper">
                <div class="card swiper-slide">
                    <div class="card-image">
                        <a href="">
                            <img src="./Image/imagePcCombo1.jpeg" alt="Image Pc RGB 6 FANS" class="card-img">
                        </a>
                    </div>
                </div>
                <div class="card swiper-slide">
                    <div class="card-image">
                        <a href="">
                            <img src="./Image/imagePcCombo2.jpeg" alt="Image Pc RGB 6 FANS" class="card-img">
                        </a>
                    </div>
                </div>
                <div class="card swiper-slide">
                    <div class="card-image">
                        <a href="">
                            <img src="./Image/imagePcCoombo3.jpeg" alt="Image Pc RGB 6 FANS" class="card-img">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>

    <div class="BestSellerBox">
        <h2>Best Seller</h2>
    </div>

    <?php
    try {
        // Connect to the database
        if (!($database = mysqli_connect('localhost:3307:3307', 'root', ''))) {
            throw new Exception("Failed to connect to the database");
        }

        // Select the database
        if (!mysqli_select_db($database, 'build_master_pc')) {
            throw new Exception("Failed to select the database");
        }
        $query = "SELECT * FROM product WHERE product_type='PC'";
        if (!$result = mysqli_query($database, $query)) {
            throw new Exception("Failed to retrieve the data");
        }
        mysqli_close($database);
        print ("<div class='container'>");
        $counter = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            if ($counter > 2) {
                break;
            }

            $counter++;
            ?>
            <div class="pc-container">
                <?php
                if (isset($row['picture'])) {
                    echo '<a href="./php/product_page.php" name="dataInput" onclick="setProdcutNum(' . $row['ProductID'] . ')">';
                    echo '<div class="img-continer">';
                    echo '<img src="./Html/admin/image/' . $row['picture'] . '" class="pc-img">';
                    echo '</div>';
                } else {
                    echo '<a href="./php/product_page.php" name="dataInput" onclick="setProdcutNum(' . $row['ProductID'] . ')">';
                    echo '<div class="img-continer">';
                    echo '<img src="./Html/admin/image/default.jpg" class="pc-img">'; // Default image if 'picture' is not set
                    echo '</div>';
                }
                ?>

                <?php
                print ("<h3 class='pc-info'>" . $row['Pro_Name'] . "</h3>");
                if ($row['Quantity'] > 0)
                    print ("<div class='pc-status-in'>In stock</div>");
                else
                    print ("<div class='pc-status-out'>Out of stock</div>");
                ?>
                </a>
                <hr>
                <div>
                    <h5 class="pc-payment">Price</h5>
                    <?php
                    print ("<h4 class='pc-payment'>" . $row['Price'] . "SR</h4>");
                    ?>
                </div>
                <div class="VAT">VAT not included</div>
                <div class="cart">
                    <?php if (isLoggedIn()): ?>
                        <form action="./php/addToCart.php" method="post">
                            <input type="hidden" name="ProductID" value="<?php echo $row['ProductID']; ?>">
                            <input type="hidden" name="Pro_Name" value="<?php echo $row['Pro_Name']; ?>">
                            <input type="hidden" name="Price" value="<?php echo $row['Price']; ?>">
                            <input type="hidden" name="picture" value="<?php echo $row['picture']; ?>">
                            <input type="hidden" name="Quantity" value="1">
                            <button class="cart-button" type="submit"><img class="shopping-cart-img"
                                    src='./Image/cart.svg'></button>
                        </form>
                    <?php else: ?>
                        <a href="#" data-modal-target="#user-login-modal">
                            <img src="./Image/icons8-cart-64.png" alt="Cart icon" height="30px" width="30px">
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php
        }
        print ("</div> ");
    } catch (Exception $e) {
        error_log("Login error: " . $e->getMessage());
        header('Location: ../index.php?problem=DBError#user-login-modal');
        exit;
    }
    ?>
    <footer class="footer">
        <div class="footer__addr">
            <h1 class="footer__logo" style="padding-bottom: 0px;">
                <img class="logo" src="./Image/LOGO.png" alt="BUILDMASTERPC logo" width="10%" height="10%">
            </h1>
            <h2>Support</h2>
            <address>
                IAU - Al Khobar - Saudi Arabia<br>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d228791.7317672436!2d49.992540180581884!3d26.36304025059799!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e49ef85c961edaf%3A0x7b2db98f2941c78c!2sImam%20Abdulrahman%20Bin%20Faisal%20University!5e0!3m2!1sen!2ssa!4v1672229820933!5m2!1sen!2ssa"
                    width="200" height="100" style="border:0" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                <a class="footer__btn" href="#">Customer Service</a>
                <a class="footer__btn" href="./Html/Contact_Us.html">Contact Us</a>
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
                    <li><a href="./php/PCs.php">PC's</a></li>
                    <li><a href="./php/PC's_Part_Filter.php">Pc Parts</a></li>
                    <li><a href="./php/Accessories.php">Accessories</a></li>
                </ul>
            </li>
            <li class="nav__item">
                <h2 class="nav__title">We Accept Payment Via</h2>
                <ul class="nav__ul">
                    <li><img src="./Image/mada.png" alt="mada" width="25%"></li>
                    <li><img src="./Image/visa.png" alt="visa" width="25%"></li>
                    <li><img src="./Image/master.png" alt="master" width="25%"></li>
                </ul>
            </li>
        </ul>
        <div class="legal">
            <p>&copy; 2024 BUILDMASTERPC. All rights reserved.</p>
            <div class="legal__links">
                <a href=""><img src="./Image/whatsapp.png" alt="Whatsapp" width="40%"></a>
                <a href=""><img src="./Image/linkedin.png" alt="linkedin" width="40%"></a>
                <a href=""><img src="./Image/x.png" alt="X" width="40%"></a>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="./JavaScript/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".slide-content", {
            pagination: {
                el: ".swiper-pagination",
                type: "progressbar",
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });

        // Modal handling
        const openModalButtons = document.querySelectorAll('[data-modal-target]');
        const closeModalButtons = document.querySelectorAll('[data-close-button]');
        const backButtons = document.querySelectorAll('[data-back-button]');
        const overlay = document.getElementById('overlay');

        openModalButtons.forEach(button => {
            const modal = document.querySelector(button.dataset.modalTarget);
            button.addEventListener('click', (event) => {
                event.preventDefault();
                closeAllModals();
                openModal(modal);
            });
        });

        overlay.addEventListener('click', () => {
            const modals = document.querySelectorAll('.modal.active');
            modals.forEach(modal => closeModal(modal));
        });

        closeModalButtons.forEach(button => {
            const modal = button.closest('.modal');
            button.addEventListener('click', () => closeModal(modal));
        });

        backButtons.forEach(button => {
            button.addEventListener('click', () => {
                const modal = button.closest('.modal');
                closeModal(modal);
                openModal(document.querySelector('#login-choices-modal'));
            });
        });

        function openModal(modal) {
            if (modal == null) return;
            modal.classList.add('active');
            overlay.classList.add('active');
        }

        function closeModal(modal) {
            if (modal == null) return;
            modal.classList.remove('active');
            overlay.classList.remove('active');
        }

        function closeAllModals() {
            const modals = document.querySelectorAll('.modal.active');
            modals.forEach(modal => closeModal(modal));
        }

        document.addEventListener("DOMContentLoaded", () => {
            // Function to open a specific modal based on the hash in the URL
            const openModalFromHash = (hash) => {
                const modal = document.querySelector(hash);
                if (modal) {
                    closeAllModals();
                    openModal(modal);
                }
            };

            // Open modal if a hash exists in the URL
            if (window.location.hash) {
                openModalFromHash(window.location.hash);
            }

            // Listen for hash changes
            window.addEventListener("hashchange", () => {
                openModalFromHash(window.location.hash);
            });
        });
    </script>
    <script src="./JavaScript/Add_the_cart.js"></script>
    <script src="./JavaScript/get_product.js"></script>
</body>

</html>