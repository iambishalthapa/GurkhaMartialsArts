<?php

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

// Function to generate a random number
function generateRandomNumber() {
    return uniqid();
}

// Function to validate profile picture size (less than 2 MB)
function validateProfilePictureSize($file) {
    $maxSize = 2 * 1024 * 1024; // 2 MB in bytes
    return $file["size"] <= $maxSize;
}

// Function to validate age (minimum age requirement)
function validateAge($dob) {
    $minAge = 16; // Minimum age required to register
    $dobDate = new DateTime($dob);
    $now = new DateTime();
    $age = $now->diff($dobDate)->y;
    return $age >= $minAge;
}

// Function to validate the password format
function validatePassword($password) {
    // Password must be at least 8 characters, contain at least one special character, one number, and one letter
    return preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/", $password);
}

$responseMessage = ''; // Initialize the response message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize user input
    $name = sanitizeInput($_POST["name"]);
    $email = sanitizeInput($_POST["email"]);
    $dob = sanitizeInput($_POST["dob"]);
    $password = sanitizeInput($_POST["password"]);
    $confirmPassword = sanitizeInput($_POST["confirm_password"]);
    $gender = sanitizeInput($_POST["gender"]);

    // Additional validation
    $profilePictureValid = validateProfilePictureSize($_FILES["profile_picture"]);
    $ageValid = validateAge($dob);
    $passwordValid = validatePassword($password);

    // Check if email already exists
    $emailCheckStmt = $conn->prepare("SELECT email FROM register WHERE email = ?");
    $emailCheckStmt->bind_param("s", $email);
    $emailCheckStmt->execute();
    $emailCheckResult = $emailCheckStmt->get_result();

    if ($emailCheckResult->num_rows > 0) {
        $responseMessage = "Email already exists: " . $email;
    } elseif (!$profilePictureValid) {
        $responseMessage = "Profile picture size must be less than 2 MB.";
    } elseif (!$ageValid) {
        $responseMessage = "You must be at least 16 years old to register.";
    } elseif (!$passwordValid) {
        $responseMessage = "Password must be at least 8 characters, contain at least one special character, one number, and one letter.";
    } elseif ($password !== $confirmPassword) {
        $responseMessage = "Password and Confirm Password do not match.";
    } else {
        // Generate a random number for the profile picture filename
        $profilePicture = "profilepictures/" . generateRandomNumber() . ".jpg";
        $profilePicturePath = __DIR__ . "/" . $profilePicture;

        // Move the uploaded profile picture to the profilepictures folder
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $profilePicturePath)) {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the user data into the database
            $insertStmt = $conn->prepare("INSERT INTO register (profile_picture, name, email, dob, password, gender) VALUES (?, ?, ?, ?, ?, ?)");
            $insertStmt->bind_param("ssssss", $profilePicture, $name, $email, $dob, $hashedPassword, $gender);

            if ($insertStmt->execute()) {
                $responseMessage = "Registration successful. You can now login.";
            } else {
                $responseMessage = "Error: " . $insertStmt->error;
            }

            // Close the insert prepared statement
            $insertStmt->close();
        } else {
            $responseMessage = "Error uploading profile picture.";
        }
    }

    // Close the email check prepared statement
    $emailCheckStmt->close();
}

// Close the database connection
$conn->close();

// Return the response message
echo $responseMessage;

?>
