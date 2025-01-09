<?php
session_start();
include("connection.php");

if (isset($_POST['batch'])) {
    $batch = $_POST['batch'];
    $staff_id = $_SESSION['username'];

    $query = "SELECT subject_name FROM `subject_tab` WHERE staff_id='$staff_id' AND semester= (SELECT semester FROM `batch_tab` WHERE batch='$batch') AND status='1'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<option value="">Select a subject</option>';
        while ($row = mysqli_fetch_array($result)) {
            echo '<option value="' . $row['subject_name'] . '">' . $row['subject_name'] . '</option>';
        }
    } else {
        echo '<option value="">No subjects available</option>';
    }
}
?>
