<?php
// Include your database connection file
include_once './db_connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $ID = $_POST['product_id'];
    $rating = $_POST['rating'];
    $reviewText = $_POST['review'];
    $UserID = $_POST['user_id'];

    // Check if the database connection is valid
    if ($connection  === false) {
        die("Error: Connection failed. " . mysqli_connect_error());
    }

    // Prepare insert statement
    $insertQuery = "INSERT INTO reviews (Product_ProductID, User_UserID, Rating, Review_text) VALUES (?, ?, ?, ?)";

    // Prepare and bind parameters
    if ($stmt = $connection ->prepare($insertQuery)) {
        $stmt->bind_param("iiis", $ID, $UserID, $rating, $reviewText);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect back to product page after successful submission
            header("Location: ./product_page.php?id=$ID");
            exit();
        } else {
            // Handle database insertion error
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        // Handle database preparation error
        echo "Error: " . $connection ->error;
    }

    // Close database connection
    $database->close();
}
?>
