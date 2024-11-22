<?php
include('db_connection.php');
session_start();

// Ensure handler is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'handler') {
    header('Location: login.php');
    exit();
}

$feedback = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'update') {
    $request_id = $_POST['request_id'];
    $student_id = $_POST['student_id'];
    $correction_notes = $_POST['correction_notes'];

    // Fetch the pending request data
    $request = $conn->query("SELECT * FROM update_requests WHERE request_id = $request_id")->fetch_assoc();

    // Build the update query based on the fields that have new values
    $update_fields = [];
    $params = [];
    $types = '';

    if (!empty($request['new_name'])) {
        $update_fields[] = "name = ?";
        $params[] = $request['new_name'];
        $types .= 's';
    }
    if (!empty($request['new_father_name'])) {
        $update_fields[] = "father_name = ?";
        $params[] = $request['new_father_name'];
        $types .= 's';
    }
    if (!empty($request['new_mother_name'])) {
        $update_fields[] = "mother_name = ?";
        $params[] = $request['new_mother_name'];
        $types .= 's';
    }
    if (!empty($request['new_contact_number'])) {
        $update_fields[] = "contact_number = ?";
        $params[] = $request['new_contact_number'];
        $types .= 's';
    }
    if (!empty($request['new_address'])) {
        $update_fields[] = "address = ?";
        $params[] = $request['new_address'];
        $types .= 's';
    }

    // If there are fields to update, proceed with the update query
    if (!empty($update_fields)) {
        $query = "UPDATE students SET " . implode(', ', $update_fields) . " WHERE student_id = ?";
        $stmt = $conn->prepare($query);
        $params[] = $student_id;
        $types .= 'i';

        // Use call_user_func_array to bind parameters dynamically
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            // Update the request status to processed and add correction notes
            $update_request_stmt = $conn->prepare("
                UPDATE update_requests SET
                    status = 'Processed',
                    correction_notes = ?
                WHERE request_id = ?
            ");
            $update_request_stmt->bind_param("si", $correction_notes, $request_id);
            $update_request_stmt->execute();

            $feedback = '<div class="alert alert-success" role="alert">Student information updated successfully.</div>';
        } else {
            $feedback = '<div class="alert alert-danger" role="alert">Error updating student information.</div>';
        }

        $stmt->close();
        $update_request_stmt->close();
    } else {
        $feedback = '<div class="alert alert-warning" role="alert">No updates were made as no corrections were specified.</div>';
    }

    $conn->close();
}
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
                <h3 class="text-center">Handler Dashboard</h3>
            </div>
            <div class="card-body">
                <!-- Display feedback message -->
                <?php echo $feedback; ?>
                <a href="handler_dashboard.php" class="btn btn-primary mt-3">Back to Requests</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
