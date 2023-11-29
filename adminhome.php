<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection details
$host = 'localhost:3307';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'martialarts';

// Create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link rel="stylesheet" href="style.css"> <!-- Include your CSS file for styling -->
    <style>
        /* Add CSS styles specific to the admin home page */
        body {
            font-family: Arial, sans-serif;
            background-color: #333;
            color: white;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
    margin: 100px auto;
    padding: 20px;
    text-align: center;
        }

        .summary-box {
            background-color: #444;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin: 10px;
            display: inline-block;
            width: calc(25% - 20px); /* Adjust the width as needed */
        }

        .summary-box h2 {
            font-size: 24px;
        }

        .summary-box p {
            font-size: 36px;
            margin-top: 10px;
        }

        /* Add more styles as needed */
    </style>
</head>
<body>
    <?php
    // Include your menu bar here
    include 'adminpanelmenubar.php';
    ?>

    <div class="container">
        <h1>Welcome to the Admin Home Page</h1>

        <!-- Summary boxes for total counts -->
        <div class="summary-box">
            <h2>Total Registered Users</h2>
            <?php
            // Retrieve the count of registered users from the database and display it here
            $userCountSql = "SELECT COUNT(*) as user_count FROM register";
            $userCountResult = $conn->query($userCountSql);
            $userCount = $userCountResult->fetch_assoc()['user_count'];
            echo '<p>' . $userCount . '</p>';
            ?>
        </div>

        <div class="summary-box">
            <h2>Total Contact Details</h2>
            <?php
            // Retrieve the count of contact details from the database and display it here
            $contactCountSql = "SELECT COUNT(*) as contact_count FROM contact_messages";
            $contactCountResult = $conn->query($contactCountSql);
            $contactCount = $contactCountResult->fetch_assoc()['contact_count'];
            echo '<p>' . $contactCount . '</p>';
            ?>
        </div>

        <div class="summary-box">
            <h2>Total Package Details</h2>
            <?php
            // Retrieve the count of package details from the database and display it here
            $packageCountSql = "SELECT COUNT(*) as package_count FROM package";
            $packageCountResult = $conn->query($packageCountSql);
            $packageCount = $packageCountResult->fetch_assoc()['package_count'];
            echo '<p>' . $packageCount . '</p>';
            ?>
        </div>
        
        <div class="summary-box">
            <h2>Total Package Purchase Price</h2>
            <?php
            // Calculate the total purchase price of all packages
            $totalPriceSql = "SELECT SUM(total_price) as total_purchase_price FROM package";
            $totalPriceResult = $conn->query($totalPriceSql);
            $totalPurchasePrice = $totalPriceResult->fetch_assoc()['total_purchase_price'];
            echo '<p>£' . number_format($totalPurchasePrice, 2) . '</p>'; // Display in pounds with 2 decimal places
            ?>
        </div>
        

        <div class="summary-box">
            <h2>Total Visitors</h2>
            <?php
            // Simulate the count of visitors (you can replace this with your own method)
            $visitorCount = rand(100, 1000);
            echo '<p>' . $visitorCount . '</p>';
            ?>
        </div>
        
    </div>
</body>
</html>
