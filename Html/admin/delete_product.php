<?php
session_start();
function isLoggedIn()
{
    return isset($_SESSION['First_Name']);
}

// Retrieve error parameter to display error messages
$loginError = isset($_GET['error']) ? $_GET['error'] : '';
?>
<?php if (isLoggedIn()): ?>
    <?php
    if (isset($_POST['delete_product']) && isset($_POST['product_id'])) {
        try {
            // Connect to the database
            $database = mysqli_connect('localhost:3307:3307', 'root', '', 'build_master_pc');
            if (!$database) {
                throw new Exception("Failed to connect to the database");
            }
            $product_id = mysqli_real_escape_string($database, $_POST['product_id']);
            mysqli_autocommit($database, false);

            // Delete product specifications
            $deleteSpecsQuery = "DELETE FROM specifications WHERE Product_ProductID = '$product_id'";
            $deleteSpecsResult = mysqli_query($database, $deleteSpecsQuery);
            if (!$deleteSpecsResult) {
                throw new Exception("Error deleting product specifications: " . mysqli_error($database));
            }

            // Delete the product
            $deleteProductQuery = "DELETE FROM product WHERE ProductID = '$product_id'";
            $deleteProductResult = mysqli_query($database, $deleteProductQuery);
            if (!$deleteProductResult) {
                throw new Exception("Error deleting product: " . mysqli_error($database));
            }

            // Commit the transaction
            mysqli_commit($database);

            // Check if deletion was successful
            if ($deleteProductResult) {
                // Output success message using JavaScript alert
                echo "<script>alert('Product and associated specifications deleted successfully!'); window.location.href = 'Admin_Dashboard_delete.php';</script>";
                exit; // stop further execution
            } else {
                echo "Error deleting product: " . mysqli_error($database);
            }

            // Close database connection
            mysqli_close($database);
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            echo "An error occurred.";
        }
    } else {
        echo "Invalid request.";
    }
?>
<?php else: ?>
    <?php header('Location: ../../Index.php');
    exit; ?>
<?php endif; ?>