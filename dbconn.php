<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = 'forexml';
$table = 'mysentiment';

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
?>
