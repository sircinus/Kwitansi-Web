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

// Retrieve the last invoice number
$sql = "SELECT invoice_number FROM kwitansi ORDER BY invoice_number DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastInvoiceNumber = $row['invoice_number'];
    $newInvoiceNumber = str_pad(intval($lastInvoiceNumber) + 1, 5, '0', STR_PAD_LEFT);
} else {
    $newInvoiceNumber = '00001';
}

echo $newInvoiceNumber;

$conn->close();
