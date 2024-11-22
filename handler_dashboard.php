<?php
include('db_connection.php');
session_start();

// Check if the user is logged in and is a handler
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'handler') {
    header('Location: login.php');
    exit();
}

// Fetch all pending update requests
$requests = $conn->query("SELECT * FROM update_requests WHERE status = 'Pending'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Handler Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="text-center">Handler Dashboard</h2>
            </div>
            <div class="card-body">
                <?php if ($requests->num_rows > 0): ?>
                    <?php while ($row = $requests->fetch_assoc()): ?>
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Request from Student ID: <?php echo htmlspecialchars($row['student_id']); ?></h5>
                                <ul class="list-group mb-3">
                                    <li class="list-group-item"><strong>New Name:</strong> <?php echo htmlspecialchars($row['new_name']); ?></li>
                                    <li class="list-group-item"><strong>New Father's Name:</strong> <?php echo htmlspecialchars($row['new_father_name']); ?></li>
                                    <li class="list-group-item"><strong>New Mother's Name:</strong> <?php echo htmlspecialchars($row['new_mother_name']); ?></li>
                                    <li class="list-group-item"><strong>New Contact Number:</strong> <?php echo htmlspecialchars($row['new_contact_number']); ?></li>
                                    <li class="list-group-item"><strong>New Address:</strong> <?php echo htmlspecialchars($row['new_address']); ?></li>
                                </ul>

                                <!-- Form to process the request -->
                                <form action="process_request.php" method="post">
                                    <input type="hidden" name="request_id" value="<?php echo $row['request_id']; ?>">
                                    <input type="hidden" name="student_id" value="<?php echo $row['student_id']; ?>">
                                    <div class="form-group">
                                        <label for="correction_notes">Correction Notes:</label>
                                        <textarea class="form-control" id="correction_notes" name="correction_notes" rows="3"></textarea>
                                    </div>
                                    <button type="submit" name="action" value="update" class="btn btn-success">Update Student Info</button>
                                </form>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="alert alert-info">No pending update requests.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
