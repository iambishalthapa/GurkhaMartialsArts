<?php
// Database configuration
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "martialarts";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session
session_start();

// Fetch the purchased packages for the logged-in user
if (isset($_SESSION["user_email"])) {
    $user_email = $_SESSION["user_email"];
    $query = "SELECT * FROM package WHERE user_email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are any purchased packages
    if ($result->num_rows === 0) {
        $noPackages = true; // Set a flag to indicate no packages purchased
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Plan</title>
    <link rel="stylesheet" href="style.css">
    <!-- Include any additional CSS for styling -->
    <style>
    /* Add your existing CSS styles here */
    .plan-container {
        text-align: center;
        margin: 20px auto; /* Center the container horizontally and add margin */
        max-width: 600px; /* Set a maximum width for the container */
    }

    .plan-box {
        background-color: transparent;
        border: 1px solid red;
        padding: 20px;
        margin: 60px auto; /* Center the box horizontally and add margin */
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: flex;
        color: #fff;
        width: 100%; /* Make the box expand to the container's width */
    }

    .plan-header {
        flex: 1;
    }

    /* Rest of the CSS styles */

    /* Optional: Add hover effect */
    .plan-box:hover {
        background-color: #333;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: background-color 0.3s, box-shadow 0.3s;
    }
    #nopurchase{
        color:red;
    }
    .headingplan{
        margin-top: 100px;
        color: white;

    }
    </style>
</head>
<body>
<?php include 'Menubar.php'; ?>

<div class="plan-container">
    <h1 class="headingplan">My Plan</h1>
    <?php if (isset($_SESSION["user_email"])): ?>
    <?php if (isset($noPackages) && $noPackages): ?>
        <p id="nopurchase">No Membership Purchased</p>
    <?php else: ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="plan-box">
                <div class="plan-header">
                    <h2><?php echo $row['package_name']; ?></h2>
                    <p><?php echo $row['description']; ?></p>
                </div>
                <div class="plan-details">
                    <?php if (!empty($row['sessions_per_week'])): ?>
                        <p><strong>Sessions Per Week:</strong> <?php echo $row['sessions_per_week']; ?></p>
                    <?php endif; ?>
                    <?php if (!empty($row['hours_per_day'])): ?>
                        <p><strong>Hours Per Day:</strong> <?php echo $row['hours_per_day']; ?></p>
                    <?php endif; ?>
                    <?php if ($row['fitness_room_selected'] > 0): ?>
                        <p><strong>Fitness Room:</strong> Yes</p>
                        <p><strong>No of Visit Fitness Room:</strong> <?php echo $row['fitness_room_selected']; ?></p>
                    <?php endif; ?>
                    <?php if ($row['personal_fitness_hours'] > 0): ?>
                        <p><strong>Personal Fitness:</strong> Yes</p>
                        <p><strong>Personal Fitness Hours:</strong> <?php echo $row['personal_fitness_hours']; ?></p>
                    <?php endif; ?>
                    <p class="price"><strong>Total Price:</strong> <?php echo $row['total_price']; ?></p>
                    <p class="date"><strong>Start Date:</strong> <?php echo $row['start_date']; ?></p>
                    <p class="date"><strong>Expiry Date:</strong> <?php echo $row['expiry_date']; ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
<?php else: ?>
    <p>Please log in to view your plan.</p>
<?php endif; ?>

</div>
<div class="wrapper">
        <!-- Your content goes here -->
    </div>
<footer class="site-footer">
    <div class="footer-content">
        <div class="footer-logo">
            <h1>Gurkha Martial Arts</h1>
            <p>Discover the path of strength and resilience through Gurkha Martial Arts.<br> Join us for holistic training, self-defense, and personal growth.</p>
        </div>
        <div class="social-icons">
                    <a href="https://www.facebook.com/login/"><img width="48" height="48" src="https://img.icons8.com/color/48/facebook-new.png" alt="facebook-new"/></a>
                    <a href="https://www.instagram.com/accounts/login/"><img width="48" height="48" src="https://img.icons8.com/color/48/instagram-new--v1.png" alt="instagram-new--v1"/></a>
                </div>
        <div class="footer-links">
            <a href="#">Privacy Policy</a>
        </div>
    </div>
    <div class="copyright">
        <p>&copy; 2023 Gurkha Martial Arts. All rights reserved.</p>
    </div>
</footer> 


    <!-- Include any additional JavaScript if needed -->
    <script src="script.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
