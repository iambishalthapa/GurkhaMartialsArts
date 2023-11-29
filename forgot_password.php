<?php
// Establish a database connection if not already done
$host = 'localhost:3307';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'martialarts';
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $forgotEmail = $_POST["forgot-email"];
    $newPassword = $_POST["new-password"];
    $confirmNewPassword = $_POST["confirm-new-password"];

    // Check if the email exists in the database
    $emailCheckStmt = $conn->prepare("SELECT id FROM register WHERE email = ?");
    $emailCheckStmt->bind_param("s", $forgotEmail);
    $emailCheckStmt->execute();
    $emailCheckResult = $emailCheckStmt->get_result();

    if ($emailCheckResult->num_rows > 0 && $newPassword === $confirmNewPassword) {
        // Hash the new password before updating
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the hashed password for the user
        $updatePasswordStmt = $conn->prepare("UPDATE register SET password = ? WHERE email = ?");
        $updatePasswordStmt->bind_param("ss", $hashedPassword, $forgotEmail);
        if ($updatePasswordStmt->execute()) {
            $response["success"] = true;
            $response["message"] = "Password updated successfully.";
        } else {
            $response["message"] = "Error updating password.";
        }
    } else {
        $response["message"] = "Incorrect Email or Passwords don't match.";
    }
}

// Return JSON-encoded response
echo json_encode($response);
?>
