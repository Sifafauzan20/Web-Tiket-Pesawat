<?php
session_start();

$_SESSION['status'] = 'loggedin';
$id = $_SESSION['user_id'];

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

// Check if the form is submitted
if (isset($_GET['jadwal_id']) && isset($_GET['kursiId'])) {
    $jadwalId = $_GET['jadwal_id'];
    $kursiId = $_GET['kursiId'];
    if (isset($_POST['proses'])) {
        // Get data from the form
        $nama_depan = $_POST["nama_depan"];
        $nama_belakang = $_POST["nama_belakang"];
        $no_telepon = $_POST["no_telepon"];
        $tanggal_lahir = $_POST["tanggal_lahir"];
        $kewarganegaraan = $_POST["kewarganegaraan"];
        $nik = $_POST["nik"];

        // Insert data into the "penumpang" table
        $sql = "INSERT INTO penumpang (nama_depan, nama_belakang, no_telepon, tanggal_lahir, kewarganegaraan, nik)
            VALUES ('$nama_depan', '$nama_belakang', '$no_telepon', '$tanggal_lahir', '$kewarganegaraan', '$nik')";

        if ($conn->query($sql) === TRUE) {
            $id_penumpang = mysqli_insert_id($conn);
            echo "New record created successfully";
            header("Location: transaksi.php?id_penumpang=$id_penumpang&kursi_id=$kursiId"); // Redirect to the next page
            exit(); // Make sure to stop the script execution after redirection
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
} else {
    echo "No jadwal ID provided in the URL.";
    exit();
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
    <title>Seat Selection</title>
</head>

<body>
    <div class="login-container">
        <h2 class="text-center mb-4">Input Data Penumpang</h2>
        <form action="" method="post">
            <div class="form-group">
            <label>Nama Depan</label>
            <input type="text" class="form-control" name="nama_depan" placeholder="Masukan Nama Depan"  required><br>
            </div>
            <div class="form-group">
            <label>Nama Belakang</label>
            <input type="text" class="form-control" name="nama_belakang" placeholder="Masukan Nama Belakang"  required><br>
            </div>
            <div class="form-group">
            <label>No Telepon</label>
            <input type="text" class="form-control" name="no_telepon" placeholder="Masukan Nomor Telepon"  required><br>
            </div>
            <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" class="form-control" name="tanggal_lahir" placeholder="Masukan Tanggal Lahir"  required><br>
            </div>
            <div class="form-group">
            <label>Kewarganegaraan</label>
            <input type="text" class="form-control" name="kewarganegaaraan" placeholder="Masukan Kewarganegaraan"  required><br>
            </div>
            <div class="form-group">
            <label>NIK</label>
            <input type="text" class="form-control" name="nik" placeholder="Masukan NIK"  required><br>

            <button type="submit" class ="btn btn-dark btn-block" name="proses">Submit</button>
        </form>
    </div>
</body>

</html>