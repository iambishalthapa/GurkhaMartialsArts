<?php
// Database connection parameters
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "martialarts";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user inputs
    $name = $_POST["yourname"];
    $email = $_POST["youremail"];
    $subject = $_POST["yoursubject"];
    $message = $_POST["yourmessage"];

    $validationErrors = array();

    // Validate inputs
    if (empty($name)) {
        $validationErrors[] = "Name is required.";
    }

    if (empty($email)) {
        $validationErrors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validationErrors[] = "Please provide a valid email address.";
    }

    if (empty($subject)) {
        $validationErrors[] = "Subject is required.";
    }

    if (strlen($message) < 100) {
        $validationErrors[] = "Message must be at least 100 characters.";
    }

    if (!empty($validationErrors)) {
        // Display validation errors one by one
        foreach ($validationErrors as $error) {
            echo " $error";
        }
    } else {
        // SQL query to insert data into the contact_messages table
        $sql = "INSERT INTO contact_messages (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, NOW())";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        // Execute the statement
        if ($stmt->execute()) {
            // Insertion successful
            echo "Message saved successfully!";
        } else {
            // Insertion failed
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>
