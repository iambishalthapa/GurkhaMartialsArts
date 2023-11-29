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
    <title>Document</title>
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
            // Check if the user is logged in based on the session variable
            if (isset($_SESSION["user_email"])) {
                // User is logged in, display the menu items for a logged-in user
                echo '<li class="menu-item"><a href="index.php">Home</a></li>';
                if ($_SESSION["user_email"] === 'bishalthapa@gmail.com') {
                    // User is 'bishalthapa@gmail.com', redirect to a different homepage
                    header("Location: adminhome.php");
                    exit();
                }
                
                // Check if the current page is myplan.php or account.php, and if so, hide these menu items
                if (!isCurrentPage("myplan.php") && !isCurrentPage("account.php")) {
                    echo '<li class="menu-item"><a href="#" onclick="scrollToProgram(); return false;">Program</a></li>';
                    echo '<li class="menu-item"><a href="#" onclick="scrollToTimetable(); return false;">Timetable</a></li>';
                    echo '<li class="menu-item"><a href="#" onclick="scrollToContact(); return false;">Contact</a></li>';
                    echo '<li class="menu-item"><a href="#" onclick="scrollToMembership(); return false;">Membership</a></li>';
                }

                echo '<li class="menu-item"><a href="myplan.php">My Plan</a></li>';
                echo '<li class="menu-item"><a href="account.php">Account</a></li>';
                
                // Get the user's profile picture from the session
                $userProfilePicture = isset($_SESSION["user_profile_picture"]) ? $_SESSION["user_profile_picture"] : 'default_profile_picture.jpg';
                
                // Display the user's profile picture
                echo '<li class="menu-item"><img src="' . $userProfilePicture . '" alt="Profile Picture" class="profile-picture"></li>';
                
                echo '<li class="menu-item"><a href="logout.php">Logout</a></li>';
            } else {
                // User is not logged in, display the menu items for a non-logged-in user
                echo '<li class="menu-item"><a href="index.php">Home</a></li>';
                
                // Check if the current page is myplan.php or account.php, and if so, hide these menu items
                if (!isCurrentPage("myplan.php") && !isCurrentPage("account.php")) {
                    echo '<li class="menu-item"><a href="#" onclick="scrollToProgram(); return false;">Program</a></li>';
                    echo '<li class="menu-item"><a href="#" onclick="scrollToTimetable(); return false;">Timetable</a></li>';
                    echo '<li class="menu-item"><a href="#" onclick="scrollToMembership(); return false;">Subscription</a></li>';
                    echo '<li class="menu-item"><a href="#" onclick="scrollToContact(); return false;">Contact</a></li>';
                }

                echo '<li class="menu-item"><a href="#" onclick="openLoginModal()">Login</a></li>';
                echo '<li class="menu-item"><a href="#" onclick="showRegistrationModal()">Register</a></li>';
               

            }
            ?>
        </ul>
    </div>
    <script>
      function scrollToProgram() {
    const programHeading = document.querySelector('.program-heading'); // Get the heading element
    const headingHeight = programHeading.offsetHeight; // Get the height of the heading

    // Scroll to the adjusted position with smooth behavior
    window.scrollTo({
        top: programHeading.offsetTop - headingHeight,
        behavior: 'smooth'
    });
}
function scrollToTimetable() {
    const timetableSection = document.getElementById('timetable-section');
    timetableSection.scrollIntoView({ behavior: 'smooth' });
}
function scrollToContact() {
    const contactSection = document.getElementById('contact-section');
    contactSection.scrollIntoView({ behavior: 'smooth' });
}
function scrollToMembership() {
    const membershipSection = document.getElementById('membership-section');
    membershipSection.scrollIntoView({ behavior: 'smooth' });
}


</script>

    <script src="script.js"></script>
</header>
</body>
</html>
