<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        .main-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 20px;
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
        .btn-center {
            display: block;
            margin: 20px auto;
        }
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: none;
            justify-content: center;
            align-items: center;
        }
        .popup-content {
            background: white;
            padding: 30px;
            border-radius: 12px;
            max-width: 600px;
            width: 100%;
            position: relative;
            text-align: center;
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
        .back-button {
            text-align: center;
            margin-top: 20px;
        }
        .alert {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <br><br><br>
    <div class="container">
        <div class="main-container">

            <!-- Left Side (Manual Insertion Form) -->
            <div class="form-container">
                <h2 class="text-center">Add Student</h2>
                <form name="Add Student" action="" method="POST" onsubmit="return validate();">
                    <?php
                        include("connection.php");
                        $sql = "SELECT student_id FROM `student_tab` ORDER BY student_id DESC LIMIT 1";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);

                        if ($row) {
                            $last = $row['student_id']; 
                            $last = trim($last);
                            $num = (int)$last;
                            $num++;              
                            $newStudID = sprintf('%04d', $num);
                            echo "Student ID: " . $newStudID;
                        } else {
                            $newStudID='1001';
                            echo "Student ID: " . $newStudID;
                        }
                    ?>
                    <div class="mb-3">
                        <label for="student_name">Student Name:</label>
                        <input type="text" class="form-control" id="student_name" name="student_name"/>
                    </div>
                    <div class="mb-3">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email"/>
                    </div>
                    <div class="mb-3">
                        <label for="batch">Batch:</label>
                        <?php
                            $query="SELECT batch from `batch_tab`";
                            $res=mysqli_query($conn,$query);
                            echo '<select name="batch" class="form-select"><option value=""> </option>';
                            while($row = mysqli_fetch_array($res)) {
                                echo '<option value="' . $row['batch'] . '">' . $row['batch'] . '</option>';
                            }
                            echo "</select>";
                        ?>
                    </div>
                    <button type="submit" class="btn btn-primary btn-center" name="submit" onclick="validate()">Add Student</button>
                    <button type="button" class="btn btn-success btn-center" onclick="openPopup()">Bulk Upload</button>
                    <center>
                    <button type="button" class="btn btn-secondary" onclick="back()">Back</button>
                    </center>
                </form>

                <!-- Success Popup -->
                <div id="successPopup" class="popup-overlay" style="display: none;">
                    <div class="popup-content">
                        <span class="popup-close" onclick="closePopup()">✖</span>
                        <h2>Success</h2>
                        <p>Data entered successfully!</p>
                        <button class="btn btn-primary" onclick="closePopup()">OK</button>
                    </div>
                </div>

                <script>
                    function validate() {
                        var student_name = document.forms["Add Student"]["student_name"].value;
                        var email = document.forms["Add Student"]["email"].value;
                        var batch = document.forms["Add Student"]["batch"].value;

                        if (student_name == "" || email == "" || batch == "") {
                            alert("Please fill all required fields.");
                            return false;
                        }
                        return true;
                    }

                    function openSuccessPopup() {
                        document.getElementById("successPopup").style.display = "flex";
                    }

                    function closePopup() {
                        document.getElementById("successPopup").style.display = "none";
                    }

                    function back() {
                        window.location.href = "admin_dashboard.php";
                    }

                    function openBulkUploadPopup() {
                        document.getElementById("bulkUploadPopup").style.display = "flex";
                    }

                    function closeBulkUploadPopup() {
                        document.getElementById("bulkUploadPopup").style.display = "none";
                    }
                </script>

                <?php
                // Manual insertion logic
                if (isset($_POST["submit"])) {
                    $student_name = $_POST['student_name'];
                    $batch = $_POST['batch'];
                    $email = $_POST['email'];  
                    $status = 1;

                    // Check if student or email already exists
                    $query = "SELECT COUNT(*) as count FROM `student_tab` WHERE student_name = '$student_name' OR email = '$email'";
                    $res1 = mysqli_query($conn, $query);
                    $row1 = mysqli_fetch_assoc($res1);
                    $student_count = $row1['count'];

                    if ($student_count > 0) {
                        echo '<div class="alert alert-warning">Student or email already added</div>';
                    } else {
                        try {
                            // Insert student into student_tab
                            $stmt = $conn->prepare("INSERT INTO `student_tab` (student_id, student_name, batch, email, status) VALUES (?, ?, ?, ?, ?)");
                            $stmt->bind_param("ssssi", $newStudID, $student_name, $batch, $email, $status);

                            if (!$stmt->execute()) {
                                echo "Error in inserting to student_tab";
                            } else {
                                // Insert data into login_tab with student ID as both ID and password
                                $default_password = $newStudID; // Use student ID as plain password
                                $hashed_password = password_hash($default_password, PASSWORD_DEFAULT); 
                                $role = 'Student'; 

                                $login_stmt = $conn->prepare("INSERT INTO login_tab (student_id, password, role, status) VALUES (?, ?, ?, ?)");
                                $login_stmt->bind_param("sssi", $newStudID, $default_password, $role, $status);

                                if (!$login_stmt->execute()) {
                                    throw new Exception('Error inserting into login_tab: ' . $login_stmt->error);
                                } else {
                                    echo '<script>openSuccessPopup();</script>'; 
                                }

                                $login_stmt->close();
                            }
                            $stmt->close();
                        } catch (Exception $e) {
                            echo '<div class="alert alert-danger">' . $e->getMessage() . '</div>';
                        }
                    }
                }

                // Bulk upload logic
                if (isset($_POST["upload"])) {
                    $fileName = $_FILES["file"]["tmp_name"];

                    if ($_FILES["file"]["size"] > 0) {
                        $file = fopen($fileName, "r");

                        // Fetch the last inserted student_id from the database to start generating new IDs
                        $sql = "SELECT student_id FROM `student_tab` ORDER BY student_id DESC LIMIT 1";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        if ($row) {
                            $last = $row['student_id']; 
                            $last = trim($last);
                            $num = (int)$last;
                        } else {
                            $num = 1000; // Starting point if no students exist in the database
                        }

                        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                            $student_name = mysqli_real_escape_string($conn, $column[0]);
                            $email = mysqli_real_escape_string($conn, $column[1]);
                            $batch = mysqli_real_escape_string($conn, $column[2]);
                            $status = 1;

                            // Check for duplicate email and batch
                            $dup_check_query = "SELECT COUNT(*) as count FROM student_tab WHERE email = '$email' AND batch = '$batch'";
                            $dup_check_result = mysqli_query($conn, $dup_check_query);
                            $dup_check_row = mysqli_fetch_assoc($dup_check_result);

                            if ($dup_check_row['count'] == 0) {
                                // Generate a new student_id
                                $num++; // Incrementing the student ID
                                $newStudentID = sprintf('%04d', $num); // Generating a 4-digit student ID
                                
                                // Insert into student_tab
                                $insert_query = "INSERT INTO student_tab (student_id, student_name, email, batch, status) 
                                                 VALUES ('$newStudentID', '$student_name', '$email', '$batch', $status)";
                                
                                if (mysqli_query($conn, $insert_query)) {
                                    // Insert into login_tab with student_id as the password
                                    $insert_login = "INSERT INTO login_tab (student_id, password, role, status) 
                                                     VALUES ('$newStudentID', '$newStudentID', 'Student', $status)";
                                    if (!mysqli_query($conn, $insert_login)) {
                                        echo "Error inserting into login_tab for student ID: $newStudentID";
                                    }
                                } else {
                                    echo "Error inserting student record for $student_name";
                                }
                            }
                        }
                        fclose($file);
                        echo '<script>openSuccessPopup();</script>';
                    }
                }
                ?>
            </div>

            <!-- Right Side (Bulk Upload Popup) -->
            <div id="bulkUploadPopup" class="popup-overlay" style="display: none;">
                <div class="popup-content">
                    <span class="popup-close" onclick="closeBulkUploadPopup()">✖</span>
                    <h2>Bulk Upload Students</h2>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="file">Select CSV file:</label>
                            <input type="file" class="form-control" id="file" name="file" required>
                        </div>
                        <button type="submit" name="upload" class="btn btn-primary">Upload</button>
                        <button type="button" class="btn btn-secondary" onclick="closeBulkUploadPopup()">Cancel</button>
                    </form>
                </div>
            </div>

            <script>
                function openPopup() {
                    document.getElementById("bulkUploadPopup").style.display = "flex";
                }
            </script>
        </div>
    </div>
</body>
</html>
