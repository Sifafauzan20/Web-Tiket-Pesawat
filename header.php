<?php
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

function isUserLoggedIn()
{
    return isset($_SESSION['status']) && $_SESSION['status'] === 'loggedin';
}

?>

<header class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: rgba(255, 255, 255, 0.3); backdrop-filter: blur(10px);">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <a style="font-size: 30px;" class="navbar-brand text-white"> <img src="LogoHeader.png" alt="Logo" class="logo-img"></a>
            <nav class="navbar navbar-expand-lg navbar-dark">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav" style="margin-left: 680px;">
                    <?php
                    if (isUserLoggedIn()) {
                        echo '<div class="navbar-nav ml-auto">';
                        echo '<div class="nav-item">';
                        echo '<a class="icon-link" href="Index.php" style="margin-right: 10px;">Beranda</a>';
                        echo '</div>';
                        echo '<div class="nav-item">';
                        echo '</div>';
                        echo '<div class="nav-item">';
                        echo '<span class="text-white">' . ($_SESSION['user_nama'] ?? '') . ' | <a href="Index.php?action=logout" class="icon-link">Logout</a>' . '</span>';
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo '<div class="navbar-nav ml-auto">';
                        echo '<div class="nav-item">';
                        echo '<div class="nav-link-wrapper">';
                        echo '<a class="icon-link" href="Index.php">Beranda</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="login-box btn btn-outline-light">';
                        echo '<a href="Login.php" style="margin-right: 0px; text-align: right; text-decoration: none;">Login</a>';
                        echo '<img class="user-avatar" src="Avatar.png" alt="User Avatar">';
                        echo '</div>';
                        echo '<div class="login-box btn btn-primary" style="margin-left: 5px;">';
                        echo '<a href="Register.php" style="margin-right: 0px; text-align: right; text-decoration: none; color: white;">Register</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </nav>
        </div>
    </div>
</header>
