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

session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_email"])) {
    // If the user is not logged in, redirect to index.php or login page
    header("Location: index.php"); // Update this URL as needed
    exit;
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
    $minAge = 16; // Minimum age required to update profile
    $dobDate = new DateTime($dob);
    $now = new DateTime();
    $age = $now->diff($dobDate)->y;
    return $age >= $minAge;
}

// Initialize variables for displaying messages
$updateMessage = '';
$deleteMessage = '';

// Check if the form is submitted for updating user profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["update_profile"])) {
        // Validate and sanitize user input
        $name = sanitizeInput($_POST["name"]);
        $email = sanitizeInput($_POST["email"]);
        $dob = sanitizeInput($_POST["dob"]);
        $gender = sanitizeInput($_POST["gender"]);

        // Additional validation
        $profilePictureValid = validateProfilePictureSize($_FILES["profile_picture"]);
        $ageValid = validateAge($dob);

        if (!$profilePictureValid) {
            $updateMessage = "Profile picture size must be less than 2 MB.";
        } elseif (!$ageValid) {
            $updateMessage = "You must be at least 16 years old to update your profile.";
        } else {
            // Handle the uploaded profile picture
            if ($_FILES["profile_picture"]["error"] === UPLOAD_ERR_OK) {
                $profilePicture = "profilepictures/" . generateRandomNumber() . ".jpg";
                $profilePicturePath = __DIR__ . "/" . $profilePicture;
                move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $profilePicturePath);
            } else {
                // No new profile picture uploaded, keep the existing one
                $profilePicture = $_SESSION["user_profile_picture"];
            }

            // Update user data in the database
            $updateStmt = $conn->prepare("UPDATE register SET profile_picture = ?, name = ?, dob = ?, gender = ? WHERE email = ?");
            $updateStmt->bind_param("sssss", $profilePicture, $name, $dob, $gender, $email);

            if ($updateStmt->execute()) {
                // Update the session variable with the new profile picture
                $_SESSION["user_profile_picture"] = $profilePicture;
                $updateMessage = "Profile updated successfully.";
            } else {
                $updateMessage = "Error updating profile: " . $updateStmt->error;
            }
        }
    } elseif (isset($_POST["delete_account"])) {
        // Delete user data from the database
        $deleteStmt = $conn->prepare("DELETE FROM register WHERE email = ?");
        $deleteStmt->bind_param("s", $_SESSION["user_email"]);

        if ($deleteStmt->execute()) {
            // User data deleted, destroy the session and redirect to index.php
            session_destroy();
            header("Location: index.php"); // Update this URL as needed
            exit;
        } else {
            $deleteMessage = "Error deleting user account.";
        }
    }
}

// Retrieve the user's current profile data from the database
$userQuery = $conn->prepare("SELECT * FROM register WHERE email = ?");
$userQuery->bind_param("s", $_SESSION["user_email"]);
$userQuery->execute();
$userResult = $userQuery->get_result();

if ($userResult->num_rows > 0) {
    $userRow = $userResult->fetch_assoc();
} else {
    echo "Error retrieving user data.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="style.css">
    <style> /* Style for the overall page */
   body{
        color: white;
        background-color: transparent;
    }
  .account-container {
    max-width: 400px;
    margin: 100px auto; /* Center the container */
    background-color: transparent;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    font-family: Arial, sans-serif;
    border: 1px solid red;
}

.profile-picture-container {
    margin-bottom: 20px;
}

.profile-picture {
    max-width: 100px;
    max-height: 100px;
    border: 1px solid #ccc;
    border-radius: 50%;
}

.form-container {
    text-align: left;
}

.form-container label {
    display: block;
    margin-bottom: 6px;
    font-weight: bold;
}

.form-container input[type="file"],
.form-container input[type="text"],
.form-container input[type="email"],
.form-container input[type="date"],
.form-container select {
    width: 100%;
    padding: 6px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.form-container select {
    height: 30px;
}

.form-container button[type="submit"] {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

/* Style for the message container */
.message-container {
    text-align: center;
    margin-top: 20px;
}

.message {
    padding: 10px;
    border-radius: 4px;
}

.success-message {
    color: white !important;
}

.error-message {
    
    color: white;
}
button{
    background-color: red;
    color: white;
    padding: 10px 20px;
    border: 1px solid;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

/* Responsive styles */
@media (max-width: 480px) {
    .account-container {
        max-width: 90%;
    }
}
</style>
</head>
<body>
<?php
include 'adminpanelmenubar.php';
?>
<div class="account-container">
    <h1>Your Account</h1>
    <!-- <div class="profile-section">
        <div class="profile-picture-container">
            <img src="php echo $_SESSION['user_profile_picture']; " alt="Profile Picture" class="profile-picture">
        </div> -->
        <form id="update-profile-form" method="post" enctype="multipart/form-data">
        <label for="profile_picture">Update Profile Picture:</label>
            <input type="file" name="profile_picture" id="profile_picture">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo $userRow['name']; ?>" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo $userRow['email']; ?>" required readonly>
            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" id="dob" value="<?php echo $userRow['dob']; ?>" required>
            <label for="gender">Gender:</label>
            <select name="gender" id="gender" required>
                <option value="male" <?php if ($userRow['gender'] === 'male') echo 'selected'; ?>>Male</option>
                <option value="female" <?php if ($userRow['gender'] === 'female') echo 'selected'; ?>>Female</option>
                <option value="other" <?php if ($userRow['gender'] === 'other') echo 'selected'; ?>>Other</option>
            </select>
           

            <button type="submit" name="update_profile">Update</button>
            <form id="delete-account-form" method="post" onsubmit="return confirm('Are you sure you want to delete your account?');">
    <button type="submit" name="delete_account">Delete Account</button>
    <div style="display: inline-block;">
        <?php if (!empty($updateMessage)): ?>
        <p class="message success-message" id="form-update-message"><?php echo $updateMessage; ?></p>
        <?php endif; ?>
        <?php if (!empty($deleteMessage)): ?>
        <p class="message error-message" id="form-delete-message"><?php echo $deleteMessage; ?></p>
        <?php endif; ?>
    </div>
</form>
        </form> 
        <a href="index.php">Go to Home</a>
    </div>
</div>
<script>
// JavaScript to hide messages after 5 seconds
window.addEventListener('DOMContentLoaded', (event) => {
    setTimeout(function () {
        var updateMessage = document.getElementById("update-message");
        var deleteMessage = document.getElementById("delete-message");
        
        if (updateMessage) {
            updateMessage.style.display = "none";
        }

        if (deleteMessage) {
            deleteMessage.style.display = "none";
        }

        // Additionally, hide messages within the form
        var formUpdateMessage = document.getElementById("form-update-message");
        var formDeleteMessage = document.getElementById("form-delete-message");

        if (formUpdateMessage) {
            formUpdateMessage.style.display = "none";
        }

        if (formDeleteMessage) {
            formDeleteMessage.style.display = "none";
        }
    }, 5000);
});

</script>

</body>
</html>
