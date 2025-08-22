<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // Connect to the database
    if (!($database = mysqli_connect('localhost:3307:3307', 'root', ''))) {
        throw new Exception("Failed to connect to the database");
    }

    // Select the database
    if (!mysqli_select_db($database, 'build_master_pc')) {
        throw new Exception("Failed to select the database");
    }

    // Retrieve and sanitize data
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $loginType = isset($_POST['login_type']) ? $_POST['login_type'] : '';

    // Sanitize the email input
    $clean_email = mysqli_real_escape_string($database, $email);

    // Query to find the user
    $query = "SELECT UserID, First_Name, Password, Is_admin FROM user WHERE Email = '$clean_email'";

    if (!($result = mysqli_query($database, $query))) {
        throw new Exception("Query execution error: " . mysqli_error($database));
    }

    // Verify the result
    if (mysqli_num_rows($result) == 0) {
        error_log("Login error: No user found for email $clean_email");
        header('Location: ../Index.php?error=Invalid+email+or+password#' . ($loginType === 'admin' ? 'admin-login-modal' : 'user-login-modal'));
        exit;
    } else {
        // Fetch row
        $row = mysqli_fetch_assoc($result);
        $userID = $row['UserID'];
        $first_name = $row['First_Name'];
        $hashed_password = $row['Password'];
        $is_admin = $row['Is_admin'];

        // Verify the password
        if (!password_verify($password, $hashed_password)) {
            error_log("Login error: Password mismatch for email $clean_email");
            header('Location: ../Index.php?error=Invalid+email+or+password#' . ($loginType === 'admin' ? 'admin-login-modal' : 'user-login-modal'));
            exit;
        }

        // Check if login type matches user type
        if (($loginType === 'admin' && $is_admin !== 'Yes') || ($loginType === 'user' && $is_admin === 'Yes')) {
            error_log("Login error: User type mismatch for email $clean_email");
            header('Location: ../Index.php?error=Invalid+login+type#' . ($loginType === 'admin' ? 'admin-login-modal' : 'user-login-modal'));
            exit;
        }

        // Start session and store First_Name
        $_SESSION['UserID'] = $userID;
        $_SESSION['First_Name'] = $first_name;

        // Redirect to appropriate dashboard after successful login
        if ($is_admin === 'Yes') {
            header('Location: ../Html/admin/Admin_Dashboard_Add.php');
        } else {
            header('Location: ../Index.php');
        }
        exit;
    }
} catch (Exception $e) {
    error_log("Login error: " . $e->getMessage());
    header('Location: ../Index.php?error=Database+Error#' . ($loginType === 'admin' ? 'admin-login-modal' : 'user-login-modal'));
    exit;
}
?>