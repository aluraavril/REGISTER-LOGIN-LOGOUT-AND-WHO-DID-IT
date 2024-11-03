<?php
// Color Functions
function insertColor($pdo, $color_name, $dealer_name, $user_id) {
    $sql = "INSERT INTO color_game (color_name, dealer_name, added_by) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$color_name, $dealer_name, $user_id]);
}

function updateColor($pdo, $color_name, $dealer_name, $color_id, $user_id) {
    $sql = "UPDATE color_game SET color_name = ?, dealer_name = ?, last_updated_by = ? WHERE color_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$color_name, $dealer_name, $user_id, $color_id]);
}

function deleteColor($pdo, $color_id, $user_id) {
    // First check if the user is the one who created this color
    $check = $pdo->prepare("SELECT added_by FROM color_game WHERE color_id = ?");
    $check->execute([$color_id]);
    $color = $check->fetch();
    
    if ($color['added_by'] != $user_id) {
        return false;
    }
    
    $sql = "DELETE FROM color_game WHERE color_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$color_id]);
}

// Bettor Functions
function insertBettor($pdo, $bettor_firstname, $betting_price, $color_id, $added_by) {
    $sql = "INSERT INTO bettors (bettor_firstname, betting_price, color_id, added_by) 
            VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$bettor_firstname, $betting_price, $color_id, $added_by]);
}

function updateBettor($pdo, $bettor_firstname, $betting_price, $bettor_id, $user_id) {
    $sql = "UPDATE bettors SET bettor_firstname = ?, betting_price = ?, last_updated_by = ? WHERE bettor_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$bettor_firstname, $betting_price, $user_id, $bettor_id]);
}

function deleteBettor($pdo, $bettor_id) {
    $sql = "DELETE FROM bettors WHERE bettor_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$bettor_id]);
}

function getAllColors($pdo) {
    $sql = "SELECT c.*, 
            u1.first_name as added_by_first_name, u1.last_name as added_by_last_name,
            u2.first_name as updated_by_first_name, u2.last_name as updated_by_last_name
            FROM color_game c 
            JOIN users u1 ON c.added_by = u1.user_id
            LEFT JOIN users u2 ON c.last_updated_by = u2.user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getAllBettersByColor($pdo, $color_id) {
    $sql = "SELECT b.*, 
            u1.first_name as added_by_first_name, u1.last_name as added_by_last_name,
            u2.first_name as updated_by_first_name, u2.last_name as updated_by_last_name
            FROM bettors b 
            LEFT JOIN users u1 ON b.added_by = u1.user_id 
            LEFT JOIN users u2 ON b.last_updated_by = u2.user_id 
            WHERE b.color_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$color_id]);
    return $stmt->fetchAll();
}

// User Functions
function createUser($pdo, $first_name, $last_name, $email, $password, $address, $age) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (first_name, last_name, email, password, address, age) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$first_name, $last_name, $email, $hashed_password, $address, $age]);
}

function getUserByEmail($pdo, $email) {
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    return $stmt->fetch();
}

function getUserById($pdo, $user_id) {
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    return $stmt->fetch();
}

function getColorByID($pdo, $color_id) {
    $sql = "SELECT c.*, u.first_name, u.last_name 
            FROM color_game c 
            JOIN users u ON c.added_by = u.user_id 
            WHERE c.color_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$color_id]);
    return $stmt->fetch();
}

function getBettorByID($pdo, $bettor_id) {
    $sql = "SELECT b.*, 
            u1.first_name as added_by_first_name, u1.last_name as added_by_last_name,
            u2.first_name as updated_by_first_name, u2.last_name as updated_by_last_name
            FROM bettors b 
            JOIN users u1 ON b.added_by = u1.user_id 
            LEFT JOIN users u2 ON b.last_updated_by = u2.user_id 
            WHERE b.bettor_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$bettor_id]);
    return $stmt->fetch();
}

?>