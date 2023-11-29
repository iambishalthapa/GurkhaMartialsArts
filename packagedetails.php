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

// Check if the user is logged in as admin (you need to implement this check based on your session management)
if (isset($_SESSION["user_email"]) && $_SESSION["user_email"] === 'bishalthapa@gmail.com') {
    // Fetch user packages data for admin users
    $sql = "SELECT id, user_email, package_name, description, start_date, sessions_per_week, hours_per_day, fitness_room_selected, personal_fitness_hours, total_price, expiry_date, fitness_room_count, personal_fitness_selected FROM package WHERE total_price != 0 AND expiry_date != 0";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - User Packages</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            color: white;
            text-align: center; /* Center-align the body content */
        }

        /* Add CSS styles for the table */
        table {
            border-collapse: collapse;
            width: 80%; /* Adjust the width as needed */
            margin: 20px auto; /* Center the table horizontally */
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd; /* Add a bottom border to cells */
        }

        th {
            background-color: black;
            color: white;
        }

        /* Add CSS styles for the search bar */
        .search-bar-container {
            text-align: center;
            margin-bottom: 20px; /* Add margin at the bottom for spacing */
        }

        .search-label {
            display: inline; /* Make the label inline with the input */
            margin-right: 10px; /* Add some spacing between the label and input */
            color: white; /* Set label color */
        }

        .search-input {
            display: inline;
            padding: 5px;
            width: 60%; /* Reduce the width of the search input */
            max-width: 300px; /* Limit the maximum width */
            margin: 0 auto; /* Center the search input horizontally within the search bar */
        }

        .admin-panel {
            margin-top: 100px;
        }
    </style>
</head>
<body>
<?php
include 'adminpanelmenubar.php';
?>

<div class="admin-panel">
    <h1>User Packages</h1>
    <!-- Search bar -->
    <div class="search-bar">
        <label class="search-label" for="searchEmail">Search:</label>
        <input type="text" class="search-input" id="searchEmail" placeholder="Enter Email to Filter">
    </div>
    <div id="noEmailFound" style="display: none;">No email found</div>

    <?php
    if (isset($result) && $result->num_rows > 0) {
        // Display the user packages data in a table
        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>S.N.</th>'; // Add S.N. column
        echo '<th>User Email</th>';
        echo '<th>Package Name</th>';
        echo '<th>Description</th>';
        echo '<th>Start Date</th>';
        echo '<th>Sessions per Week</th>';
        echo '<th>Hours per Day</th>';
        echo '<th>Fitness Room Selected</th>';
        echo '<th>Fitness Room Count</th>';
        echo '<th>Personal Fitness Selected</th>';
        echo '<th>Personal Fitness Hours</th>';
        echo '<th>Total Price</th>';
        echo '<th>Expiry Date</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        $serialNumber = 1; // Initialize the serial number

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $serialNumber . '</td>';
            echo '<td>' . $row['user_email'] . '</td>';
            echo '<td>' . $row['package_name'] . '</td>';
            echo '<td>' . $row['description'] . '</td>';
            echo '<td>' . $row['start_date'] . '</td>';
            echo '<td>' . ($row['sessions_per_week'] ? $row['sessions_per_week'] : '-') . '</td>';
            echo '<td>' . ($row['hours_per_day'] ? $row['hours_per_day'] : '-') . '</td>';
            echo '<td>' . ($row['fitness_room_selected'] == 1 ? 'Yes' : 'No') . '</td>';
            echo '<td>' . $row['fitness_room_count'] . '</td>';
            echo '<td>' . ($row['personal_fitness_selected'] == 1 ? 'Yes' : 'No') . '</td>';
            echo '<td>' . $row['personal_fitness_hours'] . '</td>';
            echo '<td>£' . $row['total_price'] . '</td>';
            echo '<td>' . $row['expiry_date'] . '</td>';
            echo '</tr>';
            $serialNumber++;
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo 'No user packages found.';
    }
    ?>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get the input element and register an input event listener
        const searchInput = document.getElementById("searchEmail");
        searchInput.addEventListener("input", filterTable);

        // Get the table rows
        const tableRows = document.querySelectorAll("table tbody tr");

        // Get the "No email found" message element
        const noEmailFoundMessage = document.getElementById("noEmailFound");

        function filterTable() {
            const searchText = searchInput.value.toLowerCase();
            let emailFound = false; // Flag to track if any matching email is found
            tableRows.forEach((row) => {
                const emailCell = row.querySelector("td:nth-child(2)");
                const email = emailCell.textContent.toLowerCase();
                if (email.includes(searchText) || searchText === "") {
                    row.style.display = "table-row";
                    emailFound = true; // Set the flag to true if a matching email is found
                } else {
                    row.style.display = "none";
                }
            });

            // Show/hide the "No email found" message based on the flag
            if (emailFound) {
                noEmailFoundMessage.style.display = "none";
            } else {
                noEmailFoundMessage.style.display = "block";
            }
        }
    });

</script>
</body>
</html>
