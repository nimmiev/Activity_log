<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Log</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
<?php
include_once 'dbconnection.php';

// Fetch only players with status = 1
$query = "SELECT id, name, place, status FROM activity_log_data WHERE status = 1";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all rows
$players = $result->fetch_all(MYSQLI_ASSOC);

$c = 0;
?>
    <div class="container my-4">
        <h2 class="text-center mb-4">Data Listing</h2>
        <div class="table-responsive">
            <div class="text-end mb-3">
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Add</button>
                <button type="button" class="btn btn-sm btn-success" id="activityLogBtn">Activity-log</button>
            </div>
            <table class="table table-bordered table-striped">
                <thead class="table-primary text-center">
                    <tr>
                        <th scope="col">SI No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Place</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($players as $player): ?>
                        <tr>
                            <td class="text-center"><?= $player['id'] ?></td>
                            <td><?= $player['name'] ?></td>
                            <td><?= $player['place'] ?></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal" 
                                        data-id="<?= $player['id'] ?>" 
                                        data-name="<?= $player['name'] ?>" 
                                        data-place="<?= $player['place'] ?>">Update</button>
                                <button class="btn btn-sm btn-danger deleteBtn" data-id="<?= $player['id'] ?>">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="addModalLabel">Add Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" id="addForm">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add">
                        <input type="text" class="form-control mb-2" name="name" placeholder="Name">
                        <input type="text" class="form-control mb-2" name="place" placeholder="Place">
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="updateModalLabel">Update Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" id="updateForm">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="" id="updateId"> <!-- ID will be set dynamically -->
                        <input type="text" class="form-control mb-2" name="name" id="updateName" placeholder="Name">
                        <input type="text" class="form-control mb-2" name="place" id="updatePlace" placeholder="Place">
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal to display activity log -->
    <div class="modal" tabindex="-1" id="activityLogModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Activity Log</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Download button for activity log -->
                    <button type="button" class="btn btn-primary" id="downloadBtn">Download Log</button>
                    <br><br>
                    <!-- Table to display activity logs -->
                    <table class="table table-bordered" id="activityLogTable">
                        <thead>
                            <tr>
                                <th>SI No</th>
                                <th>Action</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Time</th>
                                <th>Device</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Activity logs will be dynamically inserted here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
