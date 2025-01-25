<?php
// Include the database connection file
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate the password match
    if ($password !== $confirm_password) {
        header("Location: signup.html?error=Passwords do not match");
        exit();
    }

    // Check if the email already exists
    $checkEmailStmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $checkEmailStmt->bind_param("s", $email);
    $checkEmailStmt->execute();
    $checkEmailStmt->store_result();

    if ($checkEmailStmt->num_rows > 0) {
        // Redirect to the signup page with an error
        header("Location: signup.html?error=Email already exists");
        exit();
    }

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $full_name, $email, $hashed_password);

    if ($stmt->execute()) {
        // Redirect to a success page
        header("Location: login.html");
        exit();
    } else {
        header("Location: signup.html?error=Something went wrong");
        exit();
    }

    // Close statements and connection
    $checkEmailStmt->close();
    $stmt->close();
    $conn->close();
}
?>
