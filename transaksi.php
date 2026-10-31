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

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$jumlah_pembayaran = '';
if (isset($_GET['id_penumpang']) && isset($_GET['kursi_id'])) {
    $penumpangId = $_GET['id_penumpang'];
    $kursiId = $_GET['kursi_id'];

    // Retrieve seat price based on the chosen seat
    $harga = "SELECT * FROM kursi WHERE id_kursi = '$kursiId'";
    $result_price = $conn->query($harga);
    $row_price = $result_price->fetch_assoc();
    $jumlah_pembayaran = $row_price["Harga"];
    // Fetch the passenger data for display
    $sql_select = "SELECT * FROM penumpang WHERE id_penumpang = '$penumpangId'";
    $result = $conn->query($sql_select);
    $row = $result->fetch_assoc();

    if (isset($_POST['proses'])) {
        // Handle form submission and update database
        $id_penumpang = $row["id_penumpang"];
        $metode_pembayaran = $_POST["metode_pembayaran"];

        $tanggal_pemesanan = date("Y-m-d");

        // Update the transaction table
        $sql = "INSERT INTO transaksi (id_penumpang, id_kursi, tanggal, metode_transaksi)
            VALUES ('$id_penumpang', '$kursiId', '$tanggal_pemesanan', '$metode_pembayaran')";

        if ($conn->query($sql) === TRUE) {
            $id_transaksi = mysqli_insert_id($conn);
            $tiket = "INSERT INTO tiket (id_transaksi, id_kursi, tanggal_pemesanan)
            VALUES ('$id_transaksi', '$kursiId', '$tanggal_pemesanan')";
            $result_tiket = $conn->query($tiket);
            // Update seat status to 'terisi'
            $updateSql = "UPDATE kursi SET status = 'terisi' WHERE id_kursi = '$id_kursi'";
            if ($conn->query($updateSql) === TRUE) {
                echo "Transaction completed successfully. Seat selection successful. Seat is now reserved.";

                // Redirect to the next page
                header("Location: Tiket.php?id_transaksi=$id_transaksi&kursiId=$kursiId");
                exit();
            } else {
                echo "Error updating seat status: " . $conn->error;
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
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
    <title>Transaction Page</title>
    <style>
        /* Add your CSS styles here */
    </style>
</head>

<body>
    <h2>Transaction Page</h2>

    <?php
    // Display passenger data
    $i = 1;
    if ($row) {
        echo "<p><strong>Passenger Data:</strong></p>";
        echo "<p>ID: " . $i++ . "</p>";
        echo "<p>Nama: " . $row["nama_depan"] . " " . $row["nama_belakang"] . "</p>";
    } else {
        echo "No passenger data available.";
    }
    ?>

    <hr>

    <h3>Transaction Details</h3>
    <form action="" method="POST">
        <label>Metode Pembayaran:</label>
        <select name="metode_pembayaran" required>
            <option value="Credit Card">Credit Card</option>
            <option value="Bank Transfer">Bank Transfer</option>
            <!-- Add other payment options as needed -->
        </select><br>

        <label>Jumlah Pembayaran:</label>
        <input type="text" name="jumlah_pembayaran" value="<?php echo $jumlah_pembayaran; ?>" readonly><br>

        <button type="submit" name="proses">Submit Transaction</button>
    </form>
</body>

</html>

<?php
// Close the database connection
$conn->close();
?>