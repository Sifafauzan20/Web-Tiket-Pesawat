<?php
session_start();
// Assume that user authentication is already done and user_id is set
$_SESSION['status'] = 'loggedin';
$id = $_SESSION['user_id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ERD";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$ticketInfo = null;

if (isset($_GET['id_transaksi']) && isset($_GET['kursiId'])) {
    $id_transaksi = $_GET['id_transaksi'];
    $kursiId = $_GET['kursiId'];
    $query = "SELECT
        CONCAT(penumpang.nama_depan, ' ', penumpang.nama_belakang) AS 'Nama Penumpang',
        rute.bandara_asal AS Asal,
        rute.bandara_tujuan AS Tujuan,
        pesawat.nama AS Maskapai,
        kelas.kelas AS Kelas,
        tiket.tanggal_pemesanan AS 'Tanggal Pemesanan'
    FROM
        tiket
        JOIN transaksi ON tiket.id_transaksi = transaksi.id_transaksi
        JOIN kursi ON tiket.id_kursi = kursi.id_kursi
        JOIN jadwal ON kursi.id_jadwal = jadwal.id_jadwal
        JOIN pesawat ON jadwal.id_maskapai = pesawat.id_maskapai
        JOIN rute ON jadwal.id_rute = rute.id_rute
        JOIN penumpang ON transaksi.id_penumpang = penumpang.id_penumpang
        JOIN kelas ON kursi.id_kelas = kelas.id_kelas
    WHERE
        tiket.id_transaksi = '$id_transaksi' AND kursi.id_kursi = '$kursiId'";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Fetch data and store in $row array
        $ticketInfo = $result->fetch_assoc();
    } else {
        // Handle no results found
        echo "No results found.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Information</title>
    <script>
        function printTicket() {
            window.print();
        }
    </script>
</head>
<body>

<h2>Tiket Information</h2>

<?php
// Check if there is data to display
if (!empty($ticketInfo)) {
    echo "<div class='ticket-info'>
            <div><strong>Nama Penumpang:</strong> {$ticketInfo['Nama Penumpang']}</div>
            <div><strong>Asal:</strong> {$ticketInfo['Asal']}</div>
            <div><strong>Tujuan:</strong> {$ticketInfo['Tujuan']}</div>
            <div><strong>Maskapai:</strong> {$ticketInfo['Maskapai']}</div>
            <div><strong>Kelas:</strong> {$ticketInfo['Kelas']}</div>
            <div><strong>Tanggal Pemesanan:</strong> {$ticketInfo['Tanggal Pemesanan']}</div>
          </div>";
} else {
    echo "No results found.";
}
?>

<button onclick="printTicket()">Print Ticket</button>

</body>
</html>
