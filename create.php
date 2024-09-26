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

$response = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $nominal = $_POST['nominal'];
    $keterangan = $_POST['keterangan'];
    $total = $_POST['total'];

    // Insert into kwitansi table
    $sql_1 = "INSERT INTO kwitansi (nama, tanggal) VALUES ('$nama', NOW())";

    if ($conn->query($sql_1) === TRUE) {
        // Get the last inserted invoice number
        $invoice_number = $conn->insert_id;

        // Insert into kwitansi_details table
        $sql_2 = "INSERT INTO kwitansi_details (invoice_number, nominal, keterangan, total) 
                  VALUES ('$invoice_number', '$nominal', '$keterangan', '$total')";

        if ($conn->query($sql_2) === TRUE) {
            $response = 'success';
        } else {
            $response = 'error: ' . $conn->error;
        }
    } else {
        $response = 'error: ' . $conn->error;
    }

    $conn->close();
}

echo $response;
