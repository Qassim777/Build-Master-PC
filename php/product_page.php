<?php
session_start();
// Function to check if a user is logged in
function isLoggedIn()
{
    return isset($_SESSION['First_Name']);
}

// Retrieve error parameter to display error messages
$loginError = isset($_GET['error']) ? $_GET['error'] : '';
?>
<?php
try {
    // Connect to the database
    if (!($database = mysqli_connect('localhost:3307:3307', 'root', ''))) {
        throw new Exception("Failed to connect to the database");
    }
    if (isset($_COOKIE['pro'])) {
        $ID = $_COOKIE['pro'];
    } else {
        echo 'Error';
    }
    // Select the database
    if (!mysqli_select_db($database, 'build_master_pc')) {
        throw new Exception("Failed to select the database");
    }

    $query = "SELECT * FROM product WHERE ProductID=" . (string) $ID;
    if (!$result = mysqli_query($database, $query)) {
        throw new Exception("Failed to retrieve the data");
    }
    $row = mysqli_fetch_row($result);
    // setcookie('pro', '', time() - 3600, '/', '', 0, 0);

} catch (Exception $e) {
    error_log("Login error: " . $e->getMessage());
    header('Location: ../Index.php?problem=DBError#user-login-modal');
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>BuildMasterPC</title>
    <link rel="stylesheet" href="../css/Design.css">
    <link rel="icon" type="image/x-icon" href="../Image/LOGO.png">
    <link rel="stylesheet" href="../css/PC_details.css">
    <link rel="stylesheet" href="../css/popupModal.css">
</head>

<header>
    <a href="../Index.php"> <img class="logo" src="../Image/LOGO.png" alt="BUILDMASTERPC logo" width="20%" height="20%">
    </a>
    <nav>
        <ul class="nav_links">
            <li>
                <a href="./PCs.php">PC's</a>
            </li>
            <li>
                <a href="./PC's_Part_Filter.php">Pc Parts</a>
            </li>
            <li>
                <a href="./Accessories.php">Accessories</a>
            </li>
        </ul>
    </nav>

    <nav>
        <ul class="nav_links">
            <li>
                <a href="../Html/Contact_Us.php"> <img src="../Image/icons8-support-64.png" alt="Support icon"
                        height="30" width="30px"> </a>
            </li>
            <li>
                <a href="./Search.php"> <img src="../Image/icons8-search-50.png" alt="Search icon" height="30px"
                        width="30px"> </a>
            </li>
            <li>
                <?php if (isLoggedIn()): ?>
                    <a href="../Html/Cart.php">
                        <img src="../Image/icons8-cart-64.png" alt="Cart icon" height="30px" width="30px">
                    </a>
                <?php else: ?>
                    <a href="#" data-modal-target="#user-login-modal">
                        <img src="../Image/icons8-cart-64.png " alt="Cart icon" height="30px" width="30px">
                    </a>
                <?php endif; ?>
            </li>
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
    <div id="overlay"></div>
    <!-- Modal: Login Choices -->
    <div class="modal" id="login-choices-modal">
        <div class="modal-header">
            <div class="title">Log in</div>
            <button data-close-button class="close-button">&times;</button>
        </div>
        <div class="modal-body login-choices">
            <div class="pictures" data-modal-target="#admin-login-modal">
                <a href="#">
                    <img src="../Image/icon-admin.png" alt="admin login" width="150">
                </a>
                <div class="description">Admin Login</div>
            </div>
            <div class="pictures" data-modal-target="#user-login-modal">
                <a href="#">
                    <img src="../Image/user-128.png" alt="user login" width="150">
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
                    <form action="./checklogin.php" method="post">
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
                    <form action="./checklogin.php" method="post">
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
                    <form action="./register.php" method="post">
                        <input type="text" placeholder="Enter your first name" name="firstName">
                        <input type="email" placeholder="Enter your email" name="email">
                        <input type="password" placeholder="Create a password" name="password">
                        <input type="password" placeholder="Confirm your password" name="confirmpassword">
                        <input type="submit" class="button" value="Sign up">
                    </form>
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
            <div class="">
                <div class="login form">
                    <form action="#">
                        <input type="text" placeholder="Enter your email">
                        <a href="/index.php">
                            <input type="button" class="button" value="Submit">
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<body>

    <div class="pc-info">
        <?php
        echo '<img src="../Html/admin/image/' . $row[5] . '" class="pc-img">';
        ?>
        <div class="buy-pc">
            <?php
            print ("<h1>" . $row[1] . "</h1>");
            ?>
            <div>
                <h3 class="pc-payment">Price</h3>
                <?php
                print ('<h2 class="pc-payment">' . $row[2] . 'SR</h2> ');
                ?>
            </div>
            <div class="VAT">VAT not included
            </div>
            <div class="cart">
                <button class="pc-number-button" onclick="quantity_decrement()">-</button>
                <input type="text" id="quantity" class="pc-number" value=1 onchange="inputQuantity()">
                <button class="pc-number-button" onclick="quantity_increment()">+</button>
                <?php if (isLoggedIn()): ?>
                    <form action="./addToCart.php" method="post">
                        <input type="hidden" name="ProductID" value="<?php echo $row[0]; ?>">
                        <input type="hidden" name="Pro_Name" value="<?php echo $row[1]; ?>">
                        <input type="hidden" name="Price" value="<?php echo $row[2]; ?>">
                        <input type="hidden" name="picture" value="<?php echo $row[5]; ?>">
                        <input type="hidden" name="Quantity" id="Quantity" value="1">
                        <button class="cart-button" type="submit" onclick="setQuantityValue()"><img
                                class="shopping-cart-img" src='../Image/cart.svg'></button>
                    </form>
                <?php else: ?>
                    <a href="#" data-modal-target="#user-login-modal">
                        <img src="../Image/icons8-cart-64.png" alt="Cart icon" height="30px" width="30px">
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="components-spec">

        <h1 class="component-spec-header">component-spec</h1>
        <?php
        $query = "SELECT * FROM specifications WHERE Product_ProductID =" . (string) $ID;
        $result = mysqli_query($database, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="component">';
            echo ' <h3 class="type-of-component">' . $row['Speci_Name'] . '</h3>';
            echo '  <p class="name-of-component">' . $row['Speci_value'] . '</p>';
            echo '</div>';
        }
        ?>

    </div>

    <table>

        <div class="reviews-section">
            <tr>
                <th>
                    <h2 class="customer-reviews-header">Submit a Review</h2>

                </th>
                <th>
                    <div class="customer-reviews-header" style="text-align: left;">Customer Reviews</div>
                </th>
            </tr>
            <tr>

                <td>
                    <div class="submit-review" style="text-align: center; margin-right: 50px; margin-left: 50px;">
                        <form action="./submit_review.php" method="post">
                            <div class="rating">
                                <label for="rating">Rating:</label>
                                <div class="stars">
                                    <button class="star-btn" type="button" data-value="1"><img
                                            src="../Image/star_empty.png" alt="1 star"></button>
                                    <button class="star-btn" type="button" data-value="2"><img
                                            src="../Image/star_empty.png" alt="2 stars"></button>
                                    <button class="star-btn" type="button" data-value="3"><img
                                            src="../Image/star_empty.png" alt="3 stars"></button>
                                    <button class="star-btn" type="button" data-value="4"><img
                                            src="../Image/star_empty.png" alt="4 stars"></button>
                                    <button class="star-btn" type="button" data-value="5"><img
                                            src="../Image/star_empty.png" alt="5 stars"></button>
                                </div>
                            </div>
                            <input type="hidden" name="rating" id="rating" value="">
                            <!-- Add a hidden input field to capture the rating -->
                            <div class="review-text">
                                <label for="review">Your Review:</label><br>
                                <textarea name="review" id="review" cols="30" rows="5" required></textarea>
                            </div>
                            <input type="hidden" name="product_id" value="<?php echo $ID ?>">
                            <?php if (isLoggedIn()): ?>
                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['UserID'] ?>">
                                <input type="submit" value="Submit Review">
                            <?php else: ?>
                                <input type="submit" value="You Need to Login first!" disabled>
                            <?php endif; ?>
                        </form>
                    </div>
                </td>
                <td>

                    <div class="customer-reviews" style="text-align: left;">
                        <?php
                        $query = "SELECT r.*, u.First_Name FROM reviews r INNER JOIN user u ON r.User_UserID = u.UserID WHERE r.Product_ProductID = $ID ORDER BY r.Review_Date DESC LIMIT 8";
                        $result = mysqli_query($database, $query);

                        if (mysqli_num_rows($result) > 0) {
                            mysqli_close($database);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<div class='review-container'>";
                                echo "<div class='review' style='margin-bottom: 50px;'>";
                                echo "<p><strong> <img src='../Image/login.png' alt='User Avatar' alt='user' width='25px'>" . $row['First_Name'] . "</strong></p>";
                                echo "<p><strong>Rating: </strong>";
                                // Convert Rating to stars
                                $rating = intval($row['Rating']);
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $rating) {
                                        echo "<img src='../Image/star_filled.png' alt='Star Filled' width='10px'>";
                                    } else {
                                        echo "<img src='../Image/star_empty.png' alt='Star Empty' width='10px'>";
                                    }
                                }
                                echo "</p>";
                                echo "<p style='margin-down: 50px;'><strong>Review Date: </strong>" . $row['Review_Date'] . "</p>";
                                echo "<p style='padding-left: 25px; margin-top: 30px;'>" . $row['Review_text'] . "</p>";
                                echo "</div>";
                                echo "</div>";
                            }
                        } else {
                            // No reviews available
                            echo "<p><strong>Be the first one to review this product!</strong></p>";
                        }
                        ?>
                    </div>




                </td>
            </tr>
        </div>

    </table>




    <script src="../JavaScript/Add_the_cart.js" async defer></script>
    <script src="../JavaScript/get_product.js" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
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

        document.querySelectorAll('.star-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var rating = this.getAttribute('data-value');
                document.getElementById('rating').value = rating;
                // Change star images
                var starImages = document.querySelectorAll('.stars button img');
                starImages.forEach(function (img, index) {
                    if (index < rating) {
                        img.src = '../Image/star_filled.png'; // Change to star_filled.png or your filled star image path
                    } else {
                        img.src = '../Image/star_empty.png'; // Change to star_empty.png or your empty star image path
                    }
                });
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
                width="200" height="100" style="border: 0" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
            <a class="footer__btn" href="#">Customer Service</a>
            <a class="footer__btn" href="../Html/Contact_Us.php">Contact Us</a>
        </address>
    </div>

    <ul class="footer__nav">
        <li class="nav__item">
            <h2 class="nav__title">COMPANY</h2>
            <ul class="nav__ul">
                <li>
                    <a href="#">About Us</a>
                </li>

                <li>
                    <a href="#">Terms & Conditions</a>
                </li>

                <li>
                    <a href="#">Warranty Policy</a>
                </li>
                <li>
                    <a href="#">Return Policy</a>
                </li>

                <li>
                    <a href="#">Shipping Policy</a>
                </li>

                <li>
                    <a href="#">VAT Registration Number</a>
                </li>
            </ul>
        </li>

        <li class="nav__item">
            <h2 class="nav__title">PRODUCT</h2>

            <ul class="nav__ul">
                <li>
                    <a href="./PCs.php">PC's</a>
                </li>

                <li>
                    <a href="./PC's_Part_Filter.php">Pc Parts</a>
                </li>

                <li>
                    <a href="./Accessories.php">Accessories</a>
                </li>
            </ul>
        </li>

        <li class="nav__item">
            <h2 class="nav__title">We Accept Payment Via</h2>

            <ul class="nav__ul">
                <li>
                    <img src="../Image/mada.png" alt="mada" width="25%">
                </li>

                <li>
                    <img src="../Image/visa.png" alt="visa" width="25%">
                </li>

                <li>
                    <img src="../Image/master.png" alt="master" width="25%">
                </li>
            </ul>
        </li>
    </ul>

    <div class="legal">
        <p>&copy; 2024 BUILDMASTERPC. All rights reserved.</p>

        <div class="legal__links">
            <a href="">
                <img src="../Image/whatsapp.png" alt="Whatsapp" width="40%">
            </a>
            <a href="">
                <img src="../Image/linkedin.png" alt="linkedin" width="40%">
            </a>
            <a href="">
                <img src="../Image/x.png" alt="X" width="40%">
            </a>
        </div>
    </div>
</footer>

</html>