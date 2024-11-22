<?php
include('db_connection.php');
session_start();

// Check if the user is logged in and is a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header('Location: login.php');
    exit();
}

// Fetch student details
$student_id = $_SESSION['user_id'];
$student = $conn->query("SELECT * FROM students WHERE student_id = $student_id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h2 class="text-center">Student Dashboard</h2>
            </div>
            <div class="card-body">
                <!-- Display student details -->
                <ul class="list-group mb-4">
                    <li class="list-group-item"><strong>Name:</strong> <?php echo htmlspecialchars($student['name']); ?></li>
                    <li class="list-group-item"><strong>Father's Name:</strong> <?php echo htmlspecialchars($student['father_name']); ?></li>
                    <li class="list-group-item"><strong>Mother's Name:</strong> <?php echo htmlspecialchars($student['mother_name']); ?></li>
                    <li class="list-group-item"><strong>Contact Number:</strong> <?php echo htmlspecialchars($student['contact_number']); ?></li>
                    <li class="list-group-item"><strong>Address:</strong> <?php echo htmlspecialchars($student['address']); ?></li>
                </ul>

                <!-- Form to request an update -->
                <form action="submit_request.php" method="post">
                    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                    <div class="form-group">
                        <label for="new_name">New Name:</label>
                        <input type="text" class="form-control" id="new_name" name="new_name" value="<?php echo htmlspecialchars($student['name']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="new_father_name">New Father's Name:</label>
                        <input type="text" class="form-control" id="new_father_name" name="new_father_name" value="<?php echo htmlspecialchars($student['father_name']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="new_mother_name">New Mother's Name:</label>
                        <input type="text" class="form-control" id="new_mother_name" name="new_mother_name" value="<?php echo htmlspecialchars($student['mother_name']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="new_contact_number">New Contact Number:</label>
                        <input type="text" class="form-control" id="new_contact_number" name="new_contact_number" value="<?php echo htmlspecialchars($student['contact_number']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="new_address">New Address:</label>
                        <textarea class="form-control" id="new_address" name="new_address" rows="3"><?php echo htmlspecialchars($student['address']); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-info btn-block">Send Correction Request</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
