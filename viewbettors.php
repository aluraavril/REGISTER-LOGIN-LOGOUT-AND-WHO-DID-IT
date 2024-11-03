<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Get color information
if (!isset($_GET['color_id'])) {
    header("Location: index.php");
    exit();
}

$color_id = $_GET['color_id'];
$colorInfo = getColorByID($pdo, $color_id);

if (!$colorInfo) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bettors</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="user-info">
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
        <a href="core/handleAuth.php?logout=1" class="btn btn-danger">Logout</a>
    </div>

    <div class="container">
        <h1>Bettors for Color: <?php echo htmlspecialchars($colorInfo['color_name']); ?></h1>
        <p>Dealer: <?php echo htmlspecialchars($colorInfo['dealer_name']); ?></p>
        <p>Added by: <?php echo htmlspecialchars($colorInfo['first_name'] . ' ' . $colorInfo['last_name']); ?></p>
        
        <?php if(isset($_SESSION['message'])): ?>
            <div class="message <?php echo $_SESSION['message_type']; ?>">
                <?php 
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
                ?>
            </div>
        <?php endif; ?>

        <a href="index.php" class="btn">Return to Main Page</a>

        <div class="add-bettor-form">
            <h2>Add New Bettor</h2>
            <form action="core/handleForms.php" method="POST">
                <input type="hidden" name="color_id" value="<?php echo htmlspecialchars($color_id); ?>">
                <input type="hidden" name="added_by" value="<?php echo $_SESSION['user_id']; ?>">
                <p>
                    <label for="bettor_firstname">Bettor First Name:</label>
                    <input type="text" name="bettor_firstname" required>
                </p>
                <p>
                    <label for="betting_price">Betting Price:</label>
                    <input type="number" name="betting_price" required min="1">
                </p>
                <input type="submit" name="insertBettorBtn" value="Add Bettor" class="btn">
            </form>
        </div>


        <div class="bettors-list">
            <h2>Registered Bettors:</h2>
            <?php 
            $getAllBetters = getAllBettersByColor($pdo, $color_id); 
            if (empty($getAllBetters)): 
            ?>
                <p class="no-data">No bettors registered yet.</p>
            <?php else: ?>
                <?php foreach ($getAllBetters as $row): ?>
                    <div class="bettor-card">
                        <div class="bettor-info">
                            <p><strong>Bettor ID:</strong> <?php echo htmlspecialchars($row['bettor_id']); ?></p>
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($row['bettor_firstname']); ?></p>
                            <p><strong>Betting Price:</strong> <?php echo htmlspecialchars($row['betting_price']); ?></p>
                            <p><strong>Added By:</strong> <?php echo htmlspecialchars($row['added_by_first_name'] . ' ' . $row['added_by_last_name']); ?></p>
                            <p><strong>Date Added:</strong> <?php echo htmlspecialchars($row['date_added']); ?></p>
                            <p><strong>Last Updated By:</strong> <?php echo $row['last_updated_by'] ? htmlspecialchars($row['updated_by_first_name'] . ' ' . $row['updated_by_last_name']) : 'N/A'; ?></p>
                            <p><strong>Last Updated:</strong> <?php echo htmlspecialchars($row['last_updated']); ?></p>
                        </div>

                        <div class="action-buttons">
                            <a href="editbettor.php?bettor_id=<?php echo $row['bettor_id']; ?>&color_id=<?php echo $color_id; ?>" class="btn">Edit</a>
                            <form action="core/handleForms.php" method="POST" style="display:inline;">
                                <input type="hidden" name="bettor_id" value="<?php echo $row['bettor_id']; ?>">
                                <input type="hidden" name="color_id" value="<?php echo $color_id; ?>">
                                <button type="submit" name="deleteBettorBtn" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this bettor?');">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>