<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Staff CSV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            position: relative;
        }
        h2 {
            margin-bottom: 20px;
        }
        .btn-close {
            position: absolute;
            right: 15px;
            top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Upload Staff CSV File</h2>
        <form method="POST" enctype="multipart/form-data">
            <p>Please select a CSV file only</p>
            <input type="file" class="form-control" name="staff_file" required><br>
            <button type="submit" class="btn btn-success" name="upload">Upload</button>
        </form>
        <?php if (isset($msg)) { echo "<div class='mt-3 alert alert-info'>$msg</div>"; } ?>
        <button type="button" class="btn-close" onclick="window.location.href='staff_add.php';"></button>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload'])) {
        if (isset($_FILES['staff_file']) && $_FILES['staff_file']['error'] == UPLOAD_ERR_OK) {
            $file_name = $_FILES['staff_file']['tmp_name'];
            $file = fopen($file_name, "r");

            try {
                $conn = new PDO('mysql:host=localhost;dbname=miniproject_db', 'env', '');
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                while (($data = fgetcsv($file)) !== FALSE) {
                    $staff_code = $data[0];
                    $staff_name = $data[1];

                    if (empty($staff_code) || empty($staff_name)) {
                        continue; // Skip invalid rows
                    }

                    // Check if the staff already exists
                    $checkStmt = $conn->prepare("SELECT * FROM staff_tab WHERE staff_code = :staff_code");
                    $checkStmt->bindParam(':staff_code', $staff_code);
                    $checkStmt->execute();
                    $existingStaff = $checkStmt->fetch(PDO::FETCH_ASSOC);

                    if ($existingStaff) {
                        // Update existing staff
                        $updateStmt = $conn->prepare("UPDATE staff_tab SET staff_name = :staff_name WHERE staff_code = :staff_code");
                        $updateStmt->bindParam(':staff_name', $staff_name);
                        $updateStmt->bindParam(':staff_code', $staff_code);
                        $updateStmt->execute();
                    } else {
                        // Insert new staff into staff_tab
                        $insertStaffStmt = $conn->prepare("INSERT INTO staff_tab (staff_code, staff_name, status) VALUES (:staff_code, :staff_name, 1)");
                        $insertStaffStmt->bindParam(':staff_code', $staff_code);
                        $insertStaffStmt->bindParam(':staff_name', $staff_name);
                        $insertStaffStmt->execute();

                        // Insert new staff into login_tab
                        $insertLoginStmt = $conn->prepare("INSERT INTO login_tab (staff_id, password, role, status) VALUES (:staff_code, :password, 'Faculty', 1)");
                        $insertLoginStmt->bindParam(':staff_code', $staff_code);
                        $insertLoginStmt->bindParam(':password', $staff_code); // Assuming the password is the same as the staff code
                        $insertLoginStmt->execute();
                    }
                }
                $msg = "CSV file successfully imported!";
            } catch(PDOException $e) {
                $msg = "Error: " . $e->getMessage();
            } catch(Exception $e) {
                $msg = "Error: " . $e->getMessage();
            }

            fclose($file);
        } else {
            $msg = "Please upload a valid CSV file.";
        }

        $conn = null;
    }
    ?>
</body>
</html>
