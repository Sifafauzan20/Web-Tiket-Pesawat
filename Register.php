<?php
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ERD";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to safely escape input values
function sanitize_input($data) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($data));
}

// Function to hash the password using bcrypt
function hash_password($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

// Process registration when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $nama = sanitize_input($_POST["fullName"]);
    $email = sanitize_input($_POST["email"]);
    $password = sanitize_input($_POST["password"]);
    $confirmPassword = sanitize_input($_POST["confirmPassword"]);

    // Validate password strength (you can add more checks)
    if (strlen($password) < 8) {
        echo "Error: Password should be at least 8 characters.";
    } elseif ($password !== $confirmPassword) {
        echo "Error: Passwords do not match.";
    } else {
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO user (nama, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama, $email, $hashed_password);

        $hashed_password = hash_password($password);

        if ($stmt->execute()) {
            echo "Registration successful. You can now login.";
            // Redirect to login page after successful registration
            header("Location: Login.php");
            exit();
        } else {
            if ($conn->errno === 1062) { // 1062 is the MySQL error code for duplicate entry
                echo "Error: Email or Nama already exists. Please choose a different one.";
            } else {
                echo "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Halaman Register</title>
</head>

<body>
    <div class="login-container">
        <h2 class="text-center mb-4">Register</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="fullName">Nama</label>
                <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group position-relative">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="form-group position-relative">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
            </div>
            <button type="submit" class="btn btn-dark btn-block">register</button>
        </form>
    </div>

</body>

</html>
