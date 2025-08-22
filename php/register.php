<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!($database = mysqli_connect('localhost:3307:3307', 'root', ''))) {
    throw new Exception("Failed to connect to the database");
}
if (!mysqli_select_db($database, 'build_master_pc')) {
    throw new Exception("Failed to select the database");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmpassword'];

    $passwordErrors = [];
    if (strlen($password) < 8) {
        $passwordErrors[] = 'Minimum length 8 characters';
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $passwordErrors[] = 'At least one uppercase letter';
    }
    if (!preg_match('/[a-z]/', $password)) {
        $passwordErrors[] = 'At least one lowercase letter';
    }
    if (!preg_match('/[0-9]/', $password)) {
        $passwordErrors[] = 'At least one number';
    }
    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        $passwordErrors[] = 'At least one special character';
    }
    if (!$email) {
        $passwordErrors[] = 'Invalid email format';
    }
    if ($password !== $confirmPassword) {
        $passwordErrors[] = 'Passwords do not match';
    }

    if (!empty($passwordErrors)) {
        $_SESSION['signup_errors'] = implode(', ', $passwordErrors);
        header('Location: ../index.php#sign-up-modal');
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $query = "INSERT INTO user (First_Name, Email, Password, Is_admin) VALUES (?, ?, ?, 'No')";
        $stmt = mysqli_prepare($database, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'sss', $firstName, $email, $hashedPassword);
            if (mysqli_stmt_execute($stmt)) {
                // Start session and store First_Name and UserID
                $userID = mysqli_insert_id($database);
                $_SESSION['UserID'] = $userID;
                $_SESSION['First_Name'] = $firstName;

                // Redirect to the index page as logged-in user
                header('Location: ../index.php?signup=Success');
                exit();
            } else {
                $_SESSION['signup_errors'] = "Database error: " . mysqli_error($database);
                header('Location: ../index.php#sign-up-modal');
                exit();
            }
        } else {
            $_SESSION['signup_errors'] = "Database error: " . mysqli_error($database);
            header('Location: ../index.php#sign-up-modal');
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['signup_errors'] = "Error: " . $e->getMessage();
        header('Location: ../index.php#sign-up-modal');
        exit();
    }
}
?>