<?php
include('db_connection.php');
session_start();

// Ensure the student is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header('Location: login.php');
    exit();
}

// Get request data from the form
$student_id = $_POST['student_id'];
$new_name = $_POST['new_name'];
$new_father_name = $_POST['new_father_name'];
$new_mother_name = $_POST['new_mother_name'];
$new_contact_number = $_POST['new_contact_number'];
$new_address = $_POST['new_address'];

// Insert the request into the update_requests table
$stmt = $conn->prepare("INSERT INTO update_requests (student_id, new_name, new_father_name, new_mother_name, new_contact_number, new_address) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssss", $student_id, $new_name, $new_father_name, $new_mother_name, $new_contact_number, $new_address);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Request</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="text-center">Submit Correction Request</h3>
            </div>
            <div class="card-body">
                <?php if ($stmt->execute()): ?>
                    <div class="alert alert-success" role="alert">
                        Your update request has been submitted successfully.
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger" role="alert">
                        Error submitting request. Please try again later.
                    </div>
                <?php endif; ?>
                <a href="student_dashboard.php" class="btn btn-primary mt-3">Go Back to Dashboard</a>
            </div>
        </div>
    </div>

    <?php
    // Close the statement and connection
    $stmt->close();
    $conn->close();
    ?>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
