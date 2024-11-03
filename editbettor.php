<?php 
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'core/models.php';
require_once 'core/dbConfig.php';

// Retrieve bettor information based on ID
if (!isset($_GET['bettor_id']) || !isset($_GET['color_id'])) {
    header("Location: index.php");
    exit();
}

$bettor = getBettorByID($pdo, $_GET['bettor_id']);

if (!$bettor) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Bettor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Bettor</h1>
        
        <?php if(isset($_SESSION['message'])): ?>
            <div class="message <?php echo $_SESSION['message_type']; ?>">
                <?php 
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
                ?>
            </div>
        <?php endif; ?>

        <form action="core/handleForms.php" method="POST" class="edit-form">
            <input type="hidden" name="bettor_id" value="<?php echo htmlspecialchars($bettor['bettor_id']); ?>">
            <input type="hidden" name="color_id" value="<?php echo htmlspecialchars($_GET['color_id']); ?>">
            
            <p>
                <label for="bettor_firstname">Bettor First Name:</label>
                <input type="text" 
                       name="bettor_firstname" 
                       value="<?php echo htmlspecialchars($bettor['bettor_firstname']); ?>" 
                       required>
            </p>
            
            <p>
                <label for="betting_price">Betting Price:</label>
                <input type="number" 
                       name="betting_price" 
                       value="<?php echo htmlspecialchars($bettor['betting_price']); ?>" 
                       required 
                       min="1">
            </p>
            
            <div class="button-group">
                <input type="submit" name="editBettorBtn" value="Update Bettor" class="btn">
                <a href="viewbettors.php?color_id=<?php echo htmlspecialchars($_GET['color_id']); ?>" class="btn btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>