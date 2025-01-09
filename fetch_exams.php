<?php
session_start();
include("connection.php");

if (isset($_POST['subject'])) {
    $subject = $_POST['subject'];
    $batch = $_POST['batch'];
    $staff_id = $_SESSION['username'];

    $query = "SELECT exam_name FROM `exam_tab` WHERE subject_code IN (SELECT subject_code FROM `subject_tab` WHERE subject_name='$subject' AND staff_id='$staff_id') AND batch='$batch'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<option value="">Select an exam</option>';
        while ($row = mysqli_fetch_array($result)) {
            echo '<option value="' . $row['exam_name'] . '">' . $row['exam_name'] . '</option>';
        }
    } else {
        echo '<option value="">No exams available</option>';
    }
}
?>
