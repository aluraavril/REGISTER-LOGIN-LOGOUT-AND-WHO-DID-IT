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
    <title>Delete Color</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php $getColorByID = getColorByID($pdo, $_GET['color_id']); ?>
        <h1>Delete Color Confirmation</h1>
        <div class="confirmation-box">
            <h3>Color Name: <?php echo $getColorByID['color_name']; ?></h3>
            <h3>Dealer Name: <?php echo $getColorByID['dealer_name']; ?></h3>
        </div>
        <form action="core/handleForms.php?color_id=<?php echo $_GET['color_id']; ?>" method="POST">
            <input type="hidden" name="added_by" value="<?php echo $_SESSION['user_id']; ?>">
            <input type="submit" name="deleteColorBtn" value="Delete Color" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this color?');">
        </form>
        <a href="index.php" class="btn">Cancel</a>
    </div>
</body>
</html>