<?php
$servername = "localhost";
$username = "root"; // default username for XAMPP
$password = ""; // default password for XAMPP
$dbname = "kwitansi_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['invoice_number'])) {
    $invoice_number = $_GET['invoice_number'];

    // Fetch data from kwitansi and kwitansi_details tables
    $sql = "SELECT k.invoice_number, k.nama, k.tanggal, kd.nominal, kd.keterangan, kd.total 
            FROM kwitansi k 
            JOIN kwitansi_details kd ON k.invoice_number = kd.invoice_number 
            WHERE k.invoice_number = '$invoice_number'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode([]);
    }
}

$conn->close();
