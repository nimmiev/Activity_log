<?php

include_once 'dbconnection.php';

// Fetch the activity logs from the database
$query = "SELECT * FROM activity_log ORDER BY timestamp DESC";  // Adjust the query as needed
$result = $conn->query($query);

$activities = [];
while ($row = $result->fetch_assoc()) {
    $activities[] = [
        'action' => $row['action'],
        'description' => $row['description'],
        'status' => $row['status'],
        'time' => $row['timestamp'], // Assuming the timestamp field contains the time
        'device' => $row['device_details'] // Assuming device details are stored in this column
    ];
}

echo json_encode([
    'status' => 'success',
    'activities' => $activities
]);

$conn->close();
?>
