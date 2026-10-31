<?php
session_start();

// Include your existing login verification code here
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Sanitize and validate input data
    $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    // Check if the user exists
    $check_user_query = "SELECT id_user, nama, email, password FROM user WHERE nama = '$nama'";

    $result = $conn->query($check_user_query);

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        $hashed_password = $user_data["password"];

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Set session variables
            $_SESSION['status'] = 'loggedin';
            $_SESSION['user_id'] = $user_data["id_user"];
            $_SESSION['user_nama'] = $user_data["nama"];

            // Redirect to the home page or any other page after successful login
            header("Location: Index.php");
            exit();
        } else {
            echo "Incorrect password. Please try again.";
        }
    } else {
        echo "User not found. Please check your name.";
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Halaman Login</title>
</head>

<body>
    <div class="login-container">
        <h2 class="text-center mb-4">Login</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" required>
            </div>
            <div class="form-group position-relative">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Kata Sandi" required>
            </div>
            <button type="submit" class="btn btn-dark btn-block">Login</button>
        </form>
    </div>
</body>

</html>
