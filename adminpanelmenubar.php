<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
function isCurrentPage($pageName) {
    return basename($_SERVER["PHP_SELF"]) === $pageName;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link rel="stylesheet" href="style.css">
    <style>
         /* CSS for the profile picture */
         .profile-picture {
            width: 50px; /* Set the width to create a square */
            height: 50px; /* Set the height to create a square */
            border-radius: 50%; /* Create a circular profile picture */
            object-fit: cover;
        }
    </style>
</head>
<body>
<header>
    <div class="header">
        <div class="logo">
            <img src="photos/mylogo.png" alt="Company Logo">
            <span>GORKHA MARTIAL ARTS</span>
        </div>
        <ul class="menu">
            <?php
            // Check if the user is logged in
            if (isset($_SESSION["user_email"])) {
                // User is logged in
                if ($_SESSION["user_email"] === 'bishalthapa@gmail.com') {
                    // If the user is bishalthapa@gmail.com, show the admin-specific links
                    echo '<li class="menu-item"><a href="adminhome.php">Home</a></li>';
                    echo '<li class="menu-item"><a href="userRegister.php">User Register</a></li>';
                    echo '<li class="menu-item"><a href="contactusdetails.php">Contact Us Details</a></li>';
                    echo '<li class="menu-item"><a href="packagedetails.php">User Package</a></li>';
                    
                    echo '<li class="menu-item"><a href="accountAdmin.php">Admin Account</a></li>';
                } 
                // Get the user's profile picture from the session
                $userProfilePicture = isset($_SESSION["user_profile_picture"]) ? $_SESSION["user_profile_picture"] : 'default_profile_picture.jpg';
                
                // Display the user's profile picture
                echo '<li class="menu-item"><img src="' . $userProfilePicture . '" alt="" class="profile-picture"></li>';
                // Common menu items for all logged-in users
                echo '<li class="menu-item"><a href="logout.php">Logout</a></li>';
            }
            ?>
        </ul>
    </div>
</header>
</body>
</html>

