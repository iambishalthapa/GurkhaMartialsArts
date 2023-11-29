<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve form data
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm_password'];
  $gender = $_POST['gender'];

  // Validate form data (you can add your own validation logic here)

  // Connect to the database
  $host = 'localhost'; // Replace with your database host
  $dbUsername = 'your_username'; // Replace with your database username
  $dbPassword = 'your_password'; // Replace with your database password
  $dbName = 'your_database'; // Replace with your database name

  $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Insert form data into the database
  $sql = "INSERT INTO users (name, email, password, gender) VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssss", $name, $email, $password, $gender);

  if ($stmt->execute()) {
    echo "Registration successful!";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $stmt->close();
  $conn->close();
}
?>

