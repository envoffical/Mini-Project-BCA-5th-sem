<?php
session_start();
include("connection.php");

$exam_id = isset($_SESSION['ex_id']) ? $_SESSION['ex_id'] : null;
$subject_code = isset($_SESSION['subject_code']) ? $_SESSION['subject_code'] : null;
$sem = isset($_SESSION['semester']) ? $_SESSION['semester'] : null;

if (!$exam_id || !$subject_code) {
    die("Exam ID or Subject Code is missing. Please go back and select the exam and subject again.");
}

$msg = ''; // Initialize $msg for displaying error/success messages

if (isset($_POST['upload'])) {
    if (!empty($_FILES['fileToUpload']['name'])) {
        $fileTempName = $_FILES['fileToUpload']['tmp_name'];
        $fileName = $_FILES['fileToUpload']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if ($fileExtension === "csv") {
            if (($handle = fopen($fileTempName, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if (isset($data[0]) && isset($data[1])) {
                        // Clean and validate student_id and mark_obtained
                        $st_id = mysqli_real_escape_string($conn, trim($data[0]));
                        $mark = intval(trim($data[1]));

                        if ($mark <= 10) { // Check if mark is valid
                            // Check if student_id exists in student_tab
                            $check_student_query = "SELECT COUNT(*) as count FROM `student_tab` WHERE student_id = '$st_id'";
                            $check_student_result = mysqli_query($conn, $check_student_query);
                            if ($check_student_result) {
                                $student_exists = mysqli_fetch_assoc($check_student_result)['count'] > 0;

                                if ($student_exists) {
                                    $query = "SELECT semester FROM `student_tab` WHERE student_id = '$st_id'";
                                    $res = mysqli_query($conn, $query);
                                    if ($res) {
                                        $row = mysqli_fetch_assoc($res);
                                        $semester = $row['semester'];

                                        if ($semester == $sem) {
                                            $query = "INSERT INTO `marks_tab` (exam_id, student_id, mark_obtained) VALUES ('$exam_id', '$st_id', '$mark')";
                                            $res = mysqli_query($conn, $query);

                                            if (!$res) {
                                                $msg .= "Failed to insert marks for Student ID $st_id. Error: " . mysqli_error($conn) . "<br>";
                                            }
                                        } else {
                                            $msg .= "Student ID $st_id does not match the semester. Skipping this entry.<br>";
                                        }
                                    } else {
                                        $msg .= "Failed to retrieve semester for Student ID $st_id. Error: " . mysqli_error($conn) . "<br>";
                                    }
                                } else {
                                    $msg .= "Student ID $st_id does not exist in the student_tab. Skipping this entry.<br>";
                                }
                            } else {
                                $msg .= "Failed to check if Student ID $st_id exists. Error: " . mysqli_error($conn) . "<br>";
                            }
                        } else {
                            $msg .= "Invalid mark value $mark for Student ID $st_id. Skipping this entry.<br>";
                        }
                    } else {
                        $msg .= "Error: Missing data in CSV row.<br>";
                    }
                }
                fclose($handle);

                if (empty($msg)) {
                    header("Location: upload_markfile.php?insertion=1");
                    exit();
                }
            } else {
                $msg = 'Failed to open the CSV file.';
            }
        } else {
            $msg = 'Please select a valid CSV file.';
        }
    } else {
        $msg = 'Please select a file to upload.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Marks</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <?php
        if (!empty($msg)) {
            echo '<div class="alert alert-danger">' . $msg . '</div>';
        }

        if (isset($_GET['insertion']) && $_GET['insertion'] == 1) {
            echo '<div class="alert alert-success">Marks uploaded successfully!</div>';
        }
        ?>
        <a href="manage_exams.php" class="btn btn-primary">Back to Manage Exams</a>
    </div>
</body>
</html>
