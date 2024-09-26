<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kwitansi_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Array of month names in Indonesian
$months = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
];

$sql = "SELECT k.invoice_number, k.nama, kd.nominal, kd.keterangan, kd.total, k.tanggal 
        FROM kwitansi k 
        JOIN kwitansi_details kd ON k.invoice_number = kd.invoice_number 
        ORDER BY k.invoice_number DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='kwitansi-list-container'>";
    while ($row = $result->fetch_assoc()) {
        $formattedInvoiceNumber = str_pad($row["invoice_number"], 5, '0', STR_PAD_LEFT);

        // Extract the date components
        $date = DateTime::createFromFormat('Y-m-d', $row["tanggal"]);
        $day = $date->format('j');
        $month = $months[(int) $date->format('n')]; // Get the month name in Indonesian
        $year = $date->format('Y');
        $formattedDate = "$day $month $year";

        echo "<div class='kwitansi-item-container' data-invoice-number='" . $row["invoice_number"] . "'>
                <p class='kwitansi-item'>Invoice No: " . $formattedInvoiceNumber . "</p>
                <p class='kwitansi-item'>Nama: " . $row["nama"] . "</p>
                <p class='kwitansi-item'>Nominal: " . $row["nominal"] . "</p>
                <p class='kwitansi-item'>Keterangan: " . $row["keterangan"] . "</p>
                <p class='kwitansi-item'>Total: Rp " . $row["total"] . "</p>
                <p class='kwitansi-item'>Tanggal: " . $formattedDate . "</p>
              </div>";
    }
    echo "</div>";
} else {
    echo "<p>Tidak ada kwitansi.</p>";
}

$conn->close();
