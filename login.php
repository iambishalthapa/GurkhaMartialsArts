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

// Function to safely handle user input
function sanitizeInput($input) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($input));
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize user input
    $email = sanitizeInput($_POST["email"]);
    $password = sanitizeInput($_POST["password"]);

    // Retrieve user data from the database based on the provided email
    $userQuery = $conn->prepare("SELECT * FROM register WHERE email = ?");
    $userQuery->bind_param("s", $email);
    $userQuery->execute();
    $userResult = $userQuery->get_result();

    if ($userResult->num_rows > 0) {
        $userRow = $userResult->fetch_assoc();
        $hashedPassword = $userRow["password"];

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Password is correct, user is logged in
            $_SESSION['user_email'] = $email; // Set the user's email in the session
            $profilePicture = $userRow["profile_picture"];
            $_SESSION['user_profile_picture'] = $profilePicture;
             echo "Login successful. Welcome, " . $userRow["name"] . "!";
            
        } else {
            // Password is incorrect
            echo "Incorrect password. Please try again.";
        }
    } else {
        // No user found with the provided email
        echo "No user found with the email: " . $email;
    }
}
?>
