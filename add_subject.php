<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="add_subject.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Your existing CSS styling */
        body {
            background: linear-gradient(to right, #e2e2e2, #ffffff);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        h2 {
            margin-bottom: 20px;
            color: #343a40;
            font-size: 1.8rem;
        }
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        .btn-primary, .btn-info, .btn-secondary {
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            transform: scale(1.02);
        }
        .btn-info {
            background-color: #17a2b8;
            border: none;
        }
        .btn-info:hover {
            background-color: #117a8b;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
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
        .back-button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
     
    </style>
</head>
<body>
    <?php
        include("connection.php");
        include("add_sub_csv.php");
    ?>
    <div class="container">
        <h2 class="text-center">Adding Subject</h2>
        <div class="form-container">
            <!-- Manual Data Insertion -->
            <form name="Add Subject" action="" method="POST" onsubmit="return validate();">
                <div class="mb-3">
                    <label for="subject_code" class="form-label">Subject Code:</label>
                    <input type="text" class="form-control" name="subject_code" required>
                </div>
                <div class="mb-3">
                    <label for="subject_name" class="form-label">Subject Name:</label>
                    <input type="text" class="form-control" name="subject_name" required>
                </div>
                <div class="mb-3">
                    <label for="semester" class="form-label">Semester:</label>
                    <select name="semester" class="form-select" required>
                        <option value="" disabled selected>Select Semester</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="staff_id" class="form-label">Staff ID:</label>
                    <select name="staff_id" class="form-select">
                        <option value="">Select Staff ID</option>
                        <option value="NULL">Not defined</option>
                        <?php
                        $sql = "SELECT staff_code FROM staff_tab WHERE status = 1";
                        $res=mysqli_query($conn,$sql);
                        if(mysqli_num_rows($res)>0) {
                            while ($row = mysqli_fetch_array($res)) {
                                echo '<option value="' . htmlspecialchars($row['staff_code']) . '">' . htmlspecialchars($row['staff_code']) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary" name="submit">Add Subject</button>
                </div>
                <!-- Bulk Upload Button -->
                <div class="text-center mt-3">
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#bulkUploadModal">
                        Bulk Upload
                    </button>
                </div>
            </form>
        </div>

        <!-- Back Button at the Bottom Center -->
        <div class="back-button-container">
            <button type="button" class="btn btn-secondary" onclick="back()">Back</button>
        </div>
    </div>

    <!-- Bulk Upload Modal -->
    <div class="modal fade" id="bulkUploadModal" tabindex="-1" aria-labelledby="bulkUploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkUploadModalLabel">Upload CSV File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="bulkUploadForm" action="add_sub_csv.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="csvFile" class="form-label">Choose CSV File</label>
                            <input type="file" class="form-control" id="csvFile" name="csvFile" accept=".csv" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validate() {
            var s_code = document.forms["Add Subject"]["subject_code"];
            var s_name = document.forms["Add Subject"]["subject_name"];
            var sem = document.forms["Add Subject"]["semester"];
            var letters = /^[A-Za-z ]+$/;
            
            if ((s_code.value == "") || (s_name.value == "") || (sem.value == "")) {
                alert("Fill all required fields");
                return false;
            }
            if (!s_name.value.match(letters)) {
                alert("Subject name must consist of letters only");
                return false;
            }
            return true;
        }

        function back() {
            window.location.href = "admin_dashboard.php";
        }
    </script>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $subject_code = $_POST['subject_code'];
        $subject_name = $_POST['subject_name'];
        $semester = $_POST['semester'];
        $staff_id = $_POST['staff_id'];

        $query = "SELECT * FROM `subject_tab` WHERE subject_code='$subject_code' OR subject_name='$subject_name'";
        $res = mysqli_query($conn, $query);

        if (mysqli_num_rows($res) > 0) {
            echo "<script>alert('Subject already exists');</script>";
        } else {
            if ($staff_id == "NULL") {
                $query1 = "INSERT INTO subject_tab (subject_code, subject_name, semester, status) VALUES ('$subject_code', '$subject_name', '$semester', '1')";
            } else {
                $query1 = "INSERT INTO subject_tab (subject_code, subject_name, semester, staff_id, status) VALUES ('$subject_code', '$subject_name', '$semester', '$staff_id', '1')";
            }
            $res1 = mysqli_query($conn, $query1);
            if ($res1) {
                echo "<script>alert('Subject added successfully!');</script>";
            }
        }
    }
    ?>
</body>
</html>
