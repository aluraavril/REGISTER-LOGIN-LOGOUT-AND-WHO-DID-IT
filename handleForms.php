<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
require_once 'dbConfig.php';
require_once 'models.php';

// Insert Color
if (isset($_POST['insertColorBtn'])) {
    $query = insertColor($pdo, $_POST['colorName'], $_POST['dealerName'], $_SESSION['user_id']);
    if ($query) {
        $_SESSION['message'] = "Color added successfully";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Failed to add color";
        $_SESSION['message_type'] = "error";
    }
    header("Location: ../index.php");
    exit;
}

// Delete Color
if (isset($_POST['deleteColorBtn'])) {
    $query = deleteColor($pdo, $_GET['color_id'], $_SESSION['user_id']);
    if ($query) {
        $_SESSION['message'] = "Color deleted successfully";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "You don't have permission to delete this color";
        $_SESSION['message_type'] = "error";
    }
    header("Location: ../index.php");
    exit;
}

// Insert Bettor
if (isset($_POST['insertBettorBtn'])) {
    $query = insertBettor(
        $pdo, 
        $_POST['bettor_firstname'], 
        $_POST['betting_price'], 
        $_POST['color_id'],
        $_SESSION['user_id']  // Add the user_id here
    );
    if ($query) {
        header("Location: ../viewbettors.php?color_id=" . $_POST['color_id']);
        exit;
    } else {
        echo "Insertion failed";
    }
}

// Edit Color
if (isset($_POST['editColorBtn'])) {
    $color_id = $_POST['color_id']; // Get the color ID from POST
    $query = updateColor($pdo, $_POST['colorName'], $_POST['dealerName'], $color_id, $_SESSION['user_id']);
    if ($query) {
        $_SESSION['message'] = "Color updated successfully";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Failed to update color";
        $_SESSION['message_type'] = "error";
    }
    header("Location: ../index.php");
    exit;
}

// Delete Bettor
if (isset($_POST['deleteBettorBtn'])) {
    $bettor_id = $_POST['bettor_id'];
    $color_id = $_POST['color_id'];
    
    if (deleteBettor($pdo, $bettor_id)) {
        $_SESSION['message'] = "Bettor deleted successfully";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Failed to delete bettor";
        $_SESSION['message_type'] = "error";
    }
    header("Location: ../viewbettors.php?color_id=" . $color_id);
    exit;
}

// Edit Bettor
if (isset($_POST['editBettorBtn'])) {
    $bettor_id = $_POST['bettor_id'];
    $bettor_firstname = $_POST['bettor_firstname'];
    $betting_price = $_POST['betting_price'];
    $color_id = $_POST['color_id'];
    
    if (updateBettor($pdo, $bettor_firstname, $betting_price, $bettor_id, $_SESSION['user_id'])) {
        $_SESSION['message'] = "Bettor updated successfully";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Failed to update bettor";
        $_SESSION['message_type'] = "error";
    }
    header("Location: ../viewbettors.php?color_id=" . $color_id);
    exit;
}
?>