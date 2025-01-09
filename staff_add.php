<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #f8f9fa, #e2e2e2);
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
            position: relative;
        }
        h2 {
            margin-bottom: 20px;
            color: #343a40;
        }
        .btn-close {
            position: absolute;
            right: 15px;
            top: 15px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-info {
            background-color: #17a2b8;
            border: none;
        }
        .btn-info:hover {
            background-color: #117a8b;
        }
        .btn-success {
            background-color: #28a745;
            border: none;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
        }
        .modal-content {
            border-radius: 12px;
        }
        .modal-header {
            border-bottom: none;
        }
        .modal-body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Staff Management</h2>
        <form name="Add Staff" method="POST" onsubmit="return validate()">
            <div class="mb-3">
                <?php
                include("connection.php");
                $sql = "SELECT staff_code FROM `staff_tab` ORDER BY staff_code DESC LIMIT 1";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);

                if ($row) {
                    $last = $row['staff_code'];
                    $last = trim($last);
                    $numStr = substr($last, 3, 3);
                    $num = (int)$numStr;
                    $num++;
                    $newNumStr = sprintf('%03d', $num);
                    $newStaffID = 'SGC' . $newNumStr;
                    echo "Staff ID: " . $newStaffID;
                } else {
                    $newStaffID = 'SGC101';
                }
                ?>
            </div>
            <div class="mb-3">
                <label for="staff_name" class="form-label">Staff Name:</label>
                <input type="text" class="form-control" name="staff_name" id="staff_name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary" name="submit">Add Staff</button>
            </div>
        </form>

        <!-- Bulk Upload Button -->
        <div class="mt-4 text-center">
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#bulkUploadModal">Bulk Upload</button>
        </div>

        <!-- Modal for CSV Bulk Upload -->
        <div class="modal fade" id="bulkUploadModal" tabindex="-1" aria-labelledby="bulkUploadModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bulkUploadModalLabel">Upload CSV File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data">
                            <p>Please select a CSV file only</p>
                            <input type="file" class="form-control" name="staff_file" required><br>
                            <button type="submit" class="btn btn-success" name="upload">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button at the Top Right -->
        <button type="button" class="btn-close" onclick="window.location.href='admin_dashboard.php';"></button>
    </div>

    <!-- Handle Form Submissions -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['submit'])) {
            // Handle manual data insertion
            $staff_name = $_POST['staff_name'];
            $email = $_POST['email'];

            if (!empty($staff_name) && !empty($email)) {
                // Validate email format
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo '<script>alert("Invalid email format");</script>';
                } else {
                    // Check if the staff already exists
                    $query = "SELECT * FROM staff_tab WHERE email = '$email'";
                    $res = mysqli_query($conn, $query);
                    if (mysqli_num_rows($res) > 0) {
                        echo '<script>alert("Staff with this email already exists");</script>';
                    } else {
                        $query = "INSERT INTO `staff_tab` (staff_code, staff_name, email, status) VALUES ('$newStaffID','$staff_name','$email',1)";
                        $result = mysqli_query($conn, $query);
                        if ($result) {
                            $query = "INSERT INTO `login_tab` (staff_id, password, role, status) VALUES ('$newStaffID','$newStaffID','Faculty',1)";
                            $res = mysqli_query($conn, $query);
                            if ($res) {
                                echo '<script>alert("Staff inserted successfully");</script>';
                            }
                        }
                    }
                }
            } else {
                echo '<script>alert("Please fill all the fields");</script>';
            }
        } elseif (isset($_POST['upload'])) {
            // Handle bulk upload
            if ($_FILES['staff_file']['error'] == 0) {
                $file = $_FILES['staff_file']['tmp_name'];
                $handle = fopen($file, "r");
                $header = true;

                while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if ($header) {
                        $header = false;
                        continue;
                    }

                    $staff_name = $row[0];
                    $email = $row[1];

                    // Check if staff already exists
                    $query = "SELECT * FROM staff_tab WHERE email = '$email'";
                    $res = mysqli_query($conn, $query);
                    if (mysqli_num_rows($res) == 0) {
                        // Generate new staff code (use the previous logic to generate)
                        $sql = "SELECT staff_code FROM `staff_tab` ORDER BY staff_code DESC LIMIT 1";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);

                        if ($row) {
                            $last = $row['staff_code'];
                            $last = trim($last);
                            $numStr = substr($last, 3, 3);
                            $num = (int)$numStr;
                            $num++;
                            $newNumStr = sprintf('%03d', $num);
                            $newStaffID = 'SGC' . $newNumStr;
                        } else {
                            $newStaffID = 'SGC101';
                        }

                        // Insert new staff
                        $query = "INSERT INTO `staff_tab` (staff_code, staff_name, email, status) VALUES ('$newStaffID','$staff_name','$email',1)";
                        $result = mysqli_query($conn, $query);

                        if ($result) {
                            $query = "INSERT INTO `login_tab` (staff_id, password, role, status) VALUES ('$newStaffID','$newStaffID','Faculty',1)";
                            mysqli_query($conn, $query);
                        }
                    }
                }

                fclose($handle);
                echo '<script>alert("Bulk upload completed successfully");</script>';
            }
        }
    }
    ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    function validate() {
        var staff_name = document.getElementById("staff_name").value;
        var email = document.getElementById("email").value;

        // Regular expression for alphabetic characters and spaces
        var letters = /^[A-Za-z ]+$/;

        // Check if staff name contains only alphabets and spaces
        if (!staff_name.match(letters)) {
            alert("Staff name should contain only letters and spaces.");
            return false; // Prevent form submission if validation fails
        }

        // Basic email validation
        if (!email) {
            alert("Email is required.");
            return false; // Prevent form submission if email is empty
        }

        return true; // Allow form submission if validation passes
    }
    </script>
</body>
</html>
