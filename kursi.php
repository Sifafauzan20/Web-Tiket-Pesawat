<?php
session_start();

// Include your existing login verification code here
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'loggedin') {
    header('Location: index.php');
    exit();
}

// Include database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "erd";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id']) && isset($_GET['kelas'])) {
    $jadwalId = $_GET['id'];
    $kelasId = $_GET['kelas'];

    // Fetch selected jadwal details, including pesawat information
    $sql = "SELECT jadwal.id_jadwal AS NO, 
            rute.bandara_asal AS Asal, 
            rute.bandara_tujuan AS Tujuan, 
            pesawat.nama AS 'Nama Maskapai',
            jadwal.waktu_keberangkatan AS 'Waktu Berangkat', 
            jadwal.waktu_tiba AS 'Waktu Tiba',
            kelas.kelas
            FROM jadwal
            JOIN kelas ON '$kelasId' = kelas.id_kelas
            JOIN rute ON jadwal.id_rute = rute.id_rute 
            JOIN pesawat ON jadwal.id_maskapai = pesawat.id_maskapai
            LEFT JOIN kursi ON jadwal.id_jadwal = kursi.id_jadwal
            WHERE jadwal.id_jadwal = $jadwalId";

    $result = $conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $asal = $row["Asal"];
        $tujuan = $row["Tujuan"];
        $maskapai = $row["Nama Maskapai"];
        $kelas = $row["kelas"];
    } else {
        echo "No jadwal found for the selected ID.";
        exit();
    }

    // Fetch available seats for the selected jadwal, pesawat, and kelas
    $seatSql = "SELECT * FROM kursi WHERE id_jadwal = $jadwalId AND kursi.id_kelas = '$kelasId' AND status = 'belum terisi'";
    $seatResult = $conn->query($seatSql);
    $availableSeats = [];

    if ($seatResult->num_rows > 0) {
        while ($seatRow = $seatResult->fetch_assoc()) {
            $availableSeats[] = $seatRow;
            $ketersediaan[] = $seatRow['id_kursi'];
        }
    } else {
        echo "No available seats found for the selected jadwal, pesawat, and kelas.";
        exit();
    }

    if (isset($_POST['proses'])) {
        // Process form submission
        $kursiId = $_POST['id_kursi'];

        // Check if the selected seat belongs to the available seats
        if (!in_array($kursiId, $ketersediaan)) {
            echo "Invalid seat selection.";
        } else {
            // Update seat status to 'terisi' in the database for the selected class and seat
            $updateSql = "UPDATE kursi SET status = 'terisi' WHERE id_jadwal = $jadwalId AND id_kursi = $kursiId AND kursi.id_kelas = '$kelasId'";
            if ($conn->query($updateSql) === TRUE) {
                echo "Seat selection successful. Seat is now reserved.";

                // Redirect to the next page
                header("Location: Identitas.php?jadwal_id=$jadwalId&kursiId=$kursiId");
                exit();
            } else {
                echo "Error updating seat status: " . $conn->error;
            }
        }
    }
} else {
    echo "No jadwal ID provided in the URL.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="script.js"></script>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Seat Selection</title>
</head>

<body style="background-image: url('Background.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">

    <?php include 'header.php'; ?>

    <main class="container mt-4" style="text-align: left; color: white; margin-left: 20px;">
        <h2>Select Seat for Flight</h2>
        <p>Flight Details:</p>
        <p><strong>Asal:</strong> <?php echo $asal; ?></p>
        <p><strong>Tujuan:</strong> <?php echo $tujuan; ?></p>
        <p><strong>Maskapai:</strong> <?php echo $maskapai; ?></p>
        <p><strong>Kelas:</strong> <?php echo $kelas; ?></p>

        <form action="" method="POST">
            <label for="id_kursi">Select Seat Number:</label>
            <select name="id_kursi" id="id_kursi">
                <?php
                foreach ($availableSeats as $seat) {
                    echo "<option value=\"" . $seat['id_kursi'] . "\">" . $seat['no_kursi'] . "</option>";
                }
                ?>
            </select>
            <button type="submit" name="proses">Reserve Seat</button>
        </form>
    </main>
</body>

</html>