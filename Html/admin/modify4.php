<?php
$database = mysqli_connect('localhost:3307:3307', 'root', '', 'build_master_pc');
if (!$database) {
    throw new Exception("Failed to connect to the database");
}

$id = $_POST['ProductID'];
if (isset($_POST['modify'])) {
    // Get the form values
    $name = isset($_POST['Pro_Name']) ? $_POST['Pro_Name'] : '';
    $stock = isset($_POST['Quantity']) ? $_POST['Quantity'] : '';
    $price = isset($_POST['Price']) ? $_POST['Price'] : '';
    $picture = isset($_FILES['picture']['name']) ? $_FILES['picture']['name'] : '';
    $category = isset($_POST['product_type']) ? $_POST['product_type'] : '';
    $specification_names = $_POST['Specification_Name'];
    $specification_values = $_POST['Specification_valuee'];

    $target_dir = 'image/';
    $temp = $_FILES['picture']['tmp_name'];
    $uniq = time() . rand(1000, 9999);
    $info = pathinfo($_FILES['picture']['name']);

    $target_file = $target_dir . basename($_FILES["picture"]["name"]);
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    //    Allow certain files formats
    if ($fileType !== "jpg" && $fileType !== "png" && $fileType !== "jpeg") {
        $info = '<div class="alert mt-4 alert-danger"  role="alert">Sorry only jpg, png and jpeg formats are allowed!</div>';
    } else {
        $file_name = "file_" . $uniq . "." . $info['extension']; //with your created name
        move_uploaded_file($temp, $target_dir . $file_name);

        // Debugging: Check if variables are correctly set
        echo "Name: $name, Stock: $stock, Price: $price, Picture: $picture, Category: $category<br>";

        // Update the values in the database
        $sql = "UPDATE product SET Pro_Name='$name', Quantity='$stock', Price='$price', picture='$file_name', product_type='$category' WHERE ProductID='$id'";
        echo "SQL Query: $sql<br>"; // Debugging: Check the SQL query

        $result = mysqli_query($database, $sql);
        $verID = "SELECT SpecificationsID  FROM specifications WHERE Product_ProductID=" . (string) $id;

        $sopcifi = mysqli_query($database, $verID); // Loop through the submitted data and update the database
        // Loop through the submitted data and update the database
// Loop through the submitted data and update the database
        for ($i = 0; $i < count($specification_names); $i++) {
            $specification_name = mysqli_real_escape_string($database, $specification_names[$i]);
            $specification_value = mysqli_real_escape_string($database, $specification_values[$i]);

            // Retrieve SpecificationsID for each Specification
            $row = mysqli_fetch_assoc($sopcifi);
            $spID = $row['SpecificationsID'];

            // Update the table with the new values
            $query = "UPDATE specifications SET Speci_Name = '$specification_name', Speci_value = '$specification_value' WHERE SpecificationsID ='$spID'";
            $result = mysqli_query($database, $query);

            if (!$result) {
                // Handle the error, for example:
                echo "Error updating record: " . mysqli_error($database);
            }
        }



        if ($result) {
            header('location:Admin_Dashboard_modify1.php');
        } else {
            echo "Failed to update product.";
        }

        // Close the connection
        mysqli_close($database);
    }
}
?>