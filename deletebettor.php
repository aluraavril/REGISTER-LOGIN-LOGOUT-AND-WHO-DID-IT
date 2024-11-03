<?php 
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'core/models.php';
require_once 'core/dbConfig.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Bettor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php $getBettorByID = getBettorByID($pdo, $_GET['bettor_id']); ?>
        <h1>Delete Bettor Confirmation</h1>
        <div class="confirmation-box">
            <h3>Bettor Name: <?php echo htmlspecialchars($getBettorByID['bettor_firstname']); ?></h3>
            <h3>Betting Price: <?php echo htmlspecialchars($getBettorByID['betting_price']); ?></h3>
        </div>
        <form action="core/handleForms.php" method="POST">
            <input type="hidden" name="bettor_id" value="<?php echo htmlspecialchars($_GET['bettor_id']); ?>">
            <input type="hidden" name="color_id" value="<?php echo htmlspecialchars($_GET['color_id']); ?>">
            <input type="submit" name="deleteBettorBtn" value="Delete Bettor" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this bettor?');">
        </form>
        <a href="viewbettors.php?color_id=<?php echo htmlspecialchars($_GET['color_id']); ?>" class="btn">Cancel</a>
    </div>
</body>
</html>