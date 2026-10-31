<?php
session_start();

// Include your existing login verification code here
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    // Lakukan penanganan logout
    session_destroy();
    header('Location: Index.php');
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
    <title>AyoTerbang</title>
</head>

<body style="background-image: url('Background.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">

    <?php include 'header.php'; ?>

    <main class="container mt-4" style="text-align: center; color: white;">

        <section class="profile-card" style="margin-top: 120px;">
            <form class="search-form" method="GET">
                <label for="keyword">Cari Jadwal</label>
                <input type="text" class="form-control" id="keyword" name="keyword" placeholder="..." required>
                <button type="submit">Search</button>
            </form>
            <form class="kelas-form" method="GET" id="kelas-form">
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

                // Check if a keyword is provided
                $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

                // Modify the SQL query to include the WHERE clause for filtering by keyword
                $sql = "SELECT jadwal.id_jadwal AS NO, 
                rute.bandara_asal AS Asal, 
                rute.bandara_tujuan AS Tujuan, 
                pesawat.nama AS 'Nama Maskapai',
                jadwal.waktu_keberangkatan AS 'Waktu Berangkat', 
                jadwal.waktu_tiba AS 'Waktu Tiba' 
                FROM jadwal 
                JOIN rute ON jadwal.id_rute = rute.id_rute 
                JOIN pesawat ON jadwal.id_maskapai = pesawat.id_maskapai
                WHERE rute.bandara_asal LIKE '%$keyword%' OR rute.bandara_tujuan LIKE '%$keyword%'";


                $result = $conn->query($sql);

                // Check if there are results and the user is logged in
                if ($result->num_rows > 0 || isset($_SESSION['status']) || $_SESSION['status'] == 'loggedin') {
                    echo " 
                        <label for='kelas'>Pilih Kelas</label>
                        <p style='color: black'>Pilih Kelas</p>
                        <select name='kelas' id='kelasDropdown' class='form-control'>
                            <option value=''>...</option>
                            <option value='1'>Ekonomi</option>
                            <option value='2'>Ekonomi Premium</option>
                            <option value='3'>Bisnis</option>
                            <option value='4'>First Class</option>
                        </select>";
                    echo "<div id='search-results' class='mt-4' style='text-align: center;'>
                    <table class='table'>
                    <thead>
                    <tr><th>No</th>
                    <th>Bandara Asal</th>
                    <th>Bandara Tujuan</th>
                    <th>Nama Maskapai</th>
                    <th>Waktu Berangkat</th>
                    <th>Waktu Tiba</th>";

                    // Hanya menambahkan kolom "Pesan" jika pengguna sudah login
                    if (isset($_SESSION['status']) && $_SESSION['status'] == 'loggedin') {
                        echo "<th>Pesan</th>";
                    }

                    echo "</tr></thead>
                    <tbody>";

                    // output data of each row
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                        <td>" . $i++ . "</td>
                        <td>" . $row["Asal"] . "</td>
                        <td>" . $row["Tujuan"] . "</td>
                        <td>" . $row["Nama Maskapai"] . "</td>
                        <td>" . $row["Waktu Berangkat"] . "</td>
                        <td>" . $row["Waktu Tiba"] . "</td>";

                        // Hanya menambahkan tombol "Pesan" jika pengguna sudah login
                        if (isset($_SESSION['status']) && $_SESSION['status'] == 'loggedin') {
                            echo "<td><a href='kursi.php?id=" . $row['NO'] . "&kelas=' class='pesan-link'>Pesan</a></td>";
                        }

                        echo "</tr>";
                    }

                    echo "</tbody></table>";
                } else {
                    echo "0 results";
                }

                $conn->close();
                ?>
            </form>
        </section>
    </main>

    <script>
        document.getElementById('kelasDropdown').addEventListener('change', function() {
            var selectedValue = this.value;
            var links = document.querySelectorAll('.pesan-link');
            links.forEach(function(link) {
                link.href = link.href.split('&kelas=')[0] + '&kelas=' + selectedValue;
            });
        });
    </script>
</body>

</html>