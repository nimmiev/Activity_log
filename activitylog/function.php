<?php 

include_once 'dbconnection.php';

// Get the raw POST data and decode JSON
$input = json_decode(file_get_contents("php://input"), true);

if (!$input) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON input."]);
    exit;
}

// Extract data from the input
$action = isset($input['action']) ? $input['action'] : null;
$name = isset($input['name']) ? trim($input['name']) : null;
$place = isset($input['place']) ? trim($input['place']) : null;
$id = isset($input['id']) ? intval($input['id']) : null;
$deleteId = isset($input['delete_id']) ? intval($input['delete_id']) : null; // For delete action

// Handle actions
if ($action === "add") {
    // Server-side validation for add
    if (empty($name) || empty($place)) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        exit;
    }

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO activity_log_data (name, place) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $place);

    if ($stmt->execute()) {

        // Insert into the activity log with 'success' status
        $deviceDetails = getDeviceDetails(); // Function to fetch device details
        logActivity("Add Player", "Player $name added at $place.", "success", $deviceDetails);
    
        echo json_encode(["status" => "success", "message" => "Data added successfully."]);
    } else {

        // Insert into the activity log with 'error' status
        $deviceDetails = getDeviceDetails(); // Function to fetch device details
        logActivity("Add Player", "Player $name not added at $place.", "Error", $deviceDetails);
    
        echo json_encode(["status" => "error", "message" => "Failed to add data: " . $stmt->error]);
    }
    $stmt->close();

} elseif ($action === "update" && $id) {
    // Server-side validation for update
    if (empty($name) || empty($place)) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        exit;
    }

    // Update data in the database
    $stmt = $conn->prepare("UPDATE activity_log_data SET name = ?, place = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $place, $id);

    if ($stmt->execute()) {

        // Insert into the activity log with 'success' status
        $deviceDetails = getDeviceDetails(); // Function to fetch device details
        logActivity("Update Player", "Player $name updated at $place.", "success", $deviceDetails);
    
        echo json_encode(["status" => "success", "message" => "Data updated successfully."]);
    } else {

        // Insert into the activity log with 'error' status
        $deviceDetails = getDeviceDetails(); // Function to fetch device details
        logActivity("Update Player", "Player $name not updated at $place.", "Error", $deviceDetails);
    
        echo json_encode(["status" => "error", "message" => "Failed to update data: " . $stmt->error]);
    }
    $stmt->close();

} elseif ($deleteId) {
    // Fetch the player name before deleting it
    $getNameQuery = "SELECT name, place FROM activity_log_data WHERE id = ?";
    $getStmt = $conn->prepare($getNameQuery);
    $getStmt->bind_param("i", $deleteId);
    $getStmt->execute();
    $getStmt->store_result();
    
    // Check if player exists
    if ($getStmt->num_rows > 0) {
        // Fetch the player's name and place
        $getStmt->bind_result($name, $place);
        $getStmt->fetch();

        // Handle delete (update status to 0)
        $updateQuery = "UPDATE activity_log_data SET status = 0 WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("i", $deleteId);

        if ($updateStmt->execute()) {

            // Insert into the activity log with 'success' status
            $deviceDetails = getDeviceDetails(); // Function to fetch device details
            logActivity("Delete Player", "Player $name deleted from $place.", "success", $deviceDetails);
        
            echo json_encode(["status" => "success", "message" => "Player $name status updated to inactive."]);
        } else {

            // Insert into the activity log with 'error' status
            $deviceDetails = getDeviceDetails(); // Function to fetch device details
            logActivity("Delete Player", "Failed to delete player $name from $place.", "Error", $deviceDetails);
        
            echo json_encode(["status" => "error", "message" => "Failed to update player status."]);
        }
        $updateStmt->close();
    } else {
        // Handle case when player is not found
        echo json_encode(["status" => "error", "message" => "Player not found."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid action."]);
}

// Function to log activities in the database
function logActivity($action, $description, $status, $deviceDetails) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO activity_log (action, description, status, device_details) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $action, $description, $status, $deviceDetails);
    $stmt->execute();
    $stmt->close();
}

// Function to get device details using the user agent (PHP version)
function getDeviceDetails() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $deviceDetails = "Unknown Device";

    // Check for OS and device details based on user agent
    if (strpos($userAgent, 'Windows NT') !== false) {
        $deviceDetails = "Windows PC";
    } else if (strpos($userAgent, 'Mac OS X') !== false) {
        $deviceDetails = "Mac";
    } else if (strpos($userAgent, 'Android') !== false) {
        $deviceDetails = "Android Device";
    } else if (strpos($userAgent, 'iPhone') !== false) {
        $deviceDetails = "iPhone";
    }

    return $deviceDetails;
}

$conn->close();
?>
