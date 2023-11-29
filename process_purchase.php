<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

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

// Start the session
session_start();

// Modify your insertFormData function to include user_email and expiry_date
function insertFormData($conn, $user_email, $package_name, $description, $start_date, $sessions_per_week, $hours_per_day, $fitness_room_selected, $fitness_room_count, $personal_fitness_selected, $personal_fitness_hours, $total_price, $expiry_date) {
    // Your existing insert query
    $sql = "INSERT INTO package (user_email, package_name, description, start_date, sessions_per_week, hours_per_day, fitness_room_selected, fitness_room_count, personal_fitness_selected, personal_fitness_hours, total_price, expiry_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
        return;
    }

    $stmt->bind_param("sssssiidddds", $user_email, $package_name, $description, $start_date, $sessions_per_week, $hours_per_day, $fitness_room_selected, $fitness_room_count, $personal_fitness_selected, $personal_fitness_hours, $total_price, $expiry_date);

    if ($stmt->execute()) {
        echo '<p class="success-message">Package purchased successfully</p>';
        echo '<script>document.getElementById("start-date").value = "";</script>';
    } else {
        echo '<p class="error-message">Error executing statement: ' . $stmt->error . '</p>';
    }

    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $package_name = $_POST['package_name'];
    $user_email = $_SESSION['user_email'];

    // Check if user has an active package
    $activePackageQuery = "SELECT COUNT(*) AS active_packages FROM package WHERE user_email = ? AND expiry_date >= NOW()";
    $stmt = $conn->prepare($activePackageQuery);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $activePackages = $row['active_packages'];
    $stmt->close();

    if ($activePackages > 0) {
        echo '<p class="error-message">You already have an active package. Please wait until it expires before purchasing a new one.</p>';
    } else {
        $packageData = [
            'user_email' => $user_email,
            'package_name' => $package_name,
            'description' => '',
            'start_date' => '',
            'sessions_per_week' => null,
            'hours_per_day' => null,
            'fitness_room_selected' => null,
            'fitness_room_count' => null,
            'personal_fitness_selected' => null,
            'personal_fitness_hours' => null,
            'total_price' => 0.00
        ];

        switch ($package_name) {
            case "Basic":
                $packageData['description'] = "1 martial art – 2 sessions per week";
                $packageData['sessions_per_week'] = $_POST['sessions-per-week'];
                $packageData['start_date'] = $_POST['Basic-start-date'];
                $packageData['total_price'] = 25.00;
                break;

            case "Private Martial Arts Tuition":
                $packageData['description'] = "One-on-one instruction with a skilled instructor";
                $packageData['start_date'] = $_POST['private-tuition-start-date'];
                $packageData['hours_per_day'] = $_POST['hours-per-day'];
                $packageData['total_price'] = $_POST['private-tuition-total-price'];
                break;

            case "Specialist Course":
                $packageData['description'] = "Six-week beginners’ self-defence course (2 × 1-hour session per week)";
                $packageData['start_date'] = $_POST['specialist-course-start-date'];
                $packageData['fitness_room_selected'] = isset($_POST['fitness-room']) ? 1 : 0;
                $packageData['fitness_room_count'] = isset($_POST['fitness-room-count']) ? (int)$_POST['fitness-room-count'] : 0;
                $packageData['personal_fitness_selected'] = isset($_POST['personal-fitness']) ? 1 : 0;
                $packageData['personal_fitness_hours'] = isset($_POST['personal-fitness']) ? (int)$_POST['personal-fitness-hours'] : 0;
                $packageData['total_price'] = (float)$_POST['specialist-course-total-price'];
                break;

            case "Intermediate":
                $packageData['description'] = "1 martial art – 3 sessions per week";
                $packageData['sessions_per_week'] = $_POST['sessions-per-week'];
                $packageData['start_date'] = $_POST['intermediate-plan-start-date'];
                $packageData['total_price'] = 35.00;
                break;

            case "Advanced":
                $packageData['description'] = "2 martial arts – 4 sessions per week";
                $packageData['sessions_per_week'] = $_POST['sessions-per-week'];
                $packageData['start_date'] = $_POST['advanced-plan-start-date'];
                $packageData['total_price'] = 45.00;
                break;

            case "Elite":
                $packageData['description'] = "3 martial arts – 5 sessions per week";
                $packageData['sessions_per_week'] = $_POST['sessions-per-week'];
                $packageData['start_date'] = $_POST['elite-plan-start-date'];
                $packageData['total_price'] = 60.00;
                break;

            case "Junior Membership":
                $packageData['description'] = "Junior Membership – Ages 12 to 16";
                $packageData['sessions_per_week'] = $_POST['sessions-per-week'];
                $packageData['start_date'] = $_POST['junior-membership-start-date'];
                $packageData['total_price'] = 25.00;
                break;

            default:
                echo "Invalid package name";
                exit;
        }

        // Calculate expiry date (start date + 30 days)
        $expiry_date = date('Y-m-d', strtotime($packageData['start_date'] . ' +30 days'));

        // Call insertFormData function inside the conditional block
        insertFormData($conn, $user_email, $package_name, $packageData['description'], $packageData['start_date'], $packageData['sessions_per_week'], $packageData['hours_per_day'], $packageData['fitness_room_selected'], $packageData['fitness_room_count'], $packageData['personal_fitness_selected'], $packageData['personal_fitness_hours'], $packageData['total_price'], $expiry_date);
    }
}

// Close the database connection
$conn->close();
?>
