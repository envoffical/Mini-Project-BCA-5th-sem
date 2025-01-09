<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Upload Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fc;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-container {
            width: 100%;
            max-width: 600px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 20px;
        }
        .form-container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .form-container .mb-3 {
            margin-bottom: 15px;
        }
        .form-container .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
        }
        .form-container .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
        }
        .popup-content {
            background: white;
            padding: 30px;
            border-radius: 12px;
            max-width: 600px;
            width: 100%;
            position: relative;
        }
        .popup-close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.5em;
            cursor: pointer;
            color: #333;
        }
        .popup-close:hover {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center">Bulk Upload Students</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <input type="file" class="form-control" name="student_file" required/>
                </div>
                <button type="submit" class="btn btn-success" name="upload">Upload</button>
            </form>
            <?php
            include("connection.php");
            
            if (isset($_POST['upload'])) {
                if ($_FILES['student_file']['name']) {
                    $filename = explode(".", $_FILES['student_file']['name']);
                    if ($filename[1] == 'csv') {
                        $handle = fopen($_FILES['student_file']['tmp_name'], "r");
                        $header = fgetcsv($handle); // Skip header row
                        mysqli_begin_transaction($conn);
                        try {
                            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                $student_id = $data[0];
                                $student_name = $data[1];
                                $batch = $data[2];
                                $semester = $data[3];
                                $status = 1;

                                // Check if student already exists
                                $query = "SELECT COUNT(*) as count FROM `student_tab` WHERE student_id ='$student_id'";
                                $res1 = mysqli_query($conn, $query);
                                $row1 = mysqli_fetch_assoc($res1);
                                $student_count = $row1['count'];

                                if ($student_count == 0) {
                                    // Insert student into student_tab
                                    $stmt = $conn->prepare("INSERT INTO `student_tab` (student_id, student_name, batch, semester, status) VALUES (?, ?, ?, ?, ?)");
                                    $stmt->bind_param("ssssi", $student_id, $student_name, $batch, $semester, $status);
                                    if (!$stmt->execute()) {
                                        throw new Exception('Error inserting into student_tab: ' . $stmt->error);
                                    }
                                    $stmt->close();

                                    // Insert into login_tab
                                    $default_password = $student_id; // Use student_id as default password
                                    $role = 'Student';
                                    $login_stmt = $conn->prepare("INSERT INTO login_tab (student_id, password, role, status) VALUES (?, ?, ?, ?)");
                                    $login_stmt->bind_param("sssi", $student_id, $default_password, $role, $status);
                                    if (!$login_stmt->execute()) {
                                        throw new Exception('Error inserting into login_tab: ' . $login_stmt->error);
                                    }
                                    $login_stmt->close();
                                }
                            }
                            fclose($handle);
                            mysqli_commit($conn);
                            echo '<div class="alert alert-success">CSV file successfully uploaded and data inserted.</div>';
                        } catch (Exception $e) {
                            mysqli_rollback($conn);
                            echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger">Invalid file type. Please upload a CSV file.</div>';
                    }
                }
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
