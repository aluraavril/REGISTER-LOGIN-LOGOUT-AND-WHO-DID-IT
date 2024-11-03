<?php
session_start();
require_once 'dbConfig.php';
require_once 'models.php';

// Handle Login
if (isset($_POST['loginBtn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $user = getUserByEmail($pdo, $email);
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
        header("Location: ../index.php");
        exit;
    } else {
        $_SESSION['message'] = "Invalid email or password";
        $_SESSION['message_type'] = "error";
        header("Location: ../login.php");
        exit;
    }
}

// Handle Register
if (isset($_POST['registerBtn'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $age = $_POST['age'];
    
    // Check if email already exists
    if (getUserByEmail($pdo, $email)) {
        $_SESSION['message'] = "Email already exists";
        $_SESSION['message_type'] = "error";
        header("Location: ../register.php");
        exit;
    }
    
    if (createUser($pdo, $first_name, $last_name, $email, $password, $address, $age)) {
        $_SESSION['message'] = "Registration successful. Please login.";
        $_SESSION['message_type'] = "success";
        header("Location: ../login.php");
    } else {
        $_SESSION['message'] = "Registration failed";
        $_SESSION['message_type'] = "error";
        header("Location: ../register.php");
    }
    exit;
}

// Handle Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../login.php");
    exit;
}
?>