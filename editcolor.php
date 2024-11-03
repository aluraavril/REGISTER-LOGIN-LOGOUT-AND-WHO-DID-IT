<?php 
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'core/models.php';
require_once 'core/dbConfig.php';

// Retrieve color information based on ID
if (!isset($_GET['color_id'])) {
    header("Location: index.php");
    exit();
}

$color = getColorByID($pdo, $_GET['color_id']);

if (!$color) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Color</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Color</h1>
        
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
            <input type="hidden" name="color_id" value="<?php echo htmlspecialchars($color['color_id']); ?>">
            
            <p>
                <label for="colorName">Color Name:</label>
                <input type="text" 
                       name="colorName" 
                       value="<?php echo htmlspecialchars($color['color_name']); ?>" 
                       required>
            </p>
            
            <p>
                <label for="dealerName">Dealer Name:</label>
                <input type="text" 
                       name="dealerName" 
                       value="<?php echo htmlspecialchars($color['dealer_name']); ?>" 
                       required>
            </p>
            
            <div class="button-group">
                <input type="submit" name="editColorBtn" value="Update Color" class="btn">
                <a href="index.php" class="btn btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>