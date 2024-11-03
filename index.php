<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'core/dbConfig.php';
require_once 'core/models.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Color Betting Game</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="user-info">
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
        <a href="core/handleAuth.php?logout=1" class="btn btn-danger">Logout</a>
    </div>

    <div class="container main-container">
        <h1>Color Betting Game Dashboard</h1>
        
        <?php if(isset($_SESSION['message'])): ?>
            <div class="message <?php echo $_SESSION['message_type']; ?>">
                <?php 
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
                ?>
            </div>
        <?php endif; ?>

        <div class="add-color-form">
            <h2>Add New Color</h2>
            <form action="core/handleForms.php" method="POST">
                <p>
                    <label for="colorName">Color Name:</label>
                    <input type="text" name="colorName" required>
                </p>
                <p>
                    <label for="dealerName">Dealer Name:</label>
                    <input type="text" name="dealerName" required>
                </p>
                <input type="submit" name="insertColorBtn" value="Add Color" class="btn">
            </form>
        </div>

        <div class="colors-list">
            <h2>Available Colors</h2>
            <?php 
            $getAllColors = getAllColors($pdo);
            if(empty($getAllColors)): 
            ?>
                <p class="no-data">No colors added yet.</p>
            <?php else: ?>
                <?php foreach ($getAllColors as $row): ?>
                    <div class="color-card">
                        <div class="color-info">
                            <h3>Color Details</h3>
                            <p><strong>Color ID:</strong> <?php echo htmlspecialchars($row['color_id']); ?></p>
                            <p><strong>Color Name:</strong> <?php echo htmlspecialchars($row['color_name']); ?></p>
                            <p><strong>Dealer Name:</strong> <?php echo htmlspecialchars($row['dealer_name']); ?></p>
                            <p><strong>Added By:</strong> <?php echo htmlspecialchars($row['added_by_first_name'] . ' ' . $row['added_by_last_name']); ?></p>
                            <p><strong>Date Added:</strong> <?php echo htmlspecialchars($row['date_added']); ?></p>
                            <p><strong>Last Updated By:</strong> <?php echo $row['last_updated_by'] ? htmlspecialchars($row['updated_by_first_name'] . ' ' . $row['updated_by_last_name']) : 'N/A'; ?></p>
                            <p><strong>Last Updated:</strong> <?php echo htmlspecialchars($row['last_updated']); ?></p>
                        </div>

                        <div class="action-buttons">
                            <a href="viewbettors.php?color_id=<?php echo $row['color_id']; ?>" class="btn">View Bettors</a>
                            <a href="editcolor.php?color_id=<?php echo $row['color_id']; ?>" class="btn">Edit</a>
                            <a href="deletecolor.php?color_id=<?php echo $row['color_id']; ?>" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>