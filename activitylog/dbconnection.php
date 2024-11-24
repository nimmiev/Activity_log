<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "activity_log";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

?>