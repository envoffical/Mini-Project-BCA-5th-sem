<?php
include("connection.php");

if (isset($_POST['subject_code'])) {
    $subject_code = $_POST['subject_code'];

    // Debugging: Log the subject_code to check if it's correctly passed
    // file_put_contents('debug.log', "Subject Code: $subject_code\n", FILE_APPEND);

    $query = "UPDATE `subject_tab` SET `status` = 0 WHERE `subject_code` = '$subject_code'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "success";
    } else {
        echo "error: " . mysqli_error($conn); // Return the error message
    }
} else {
    echo "error: Subject code not provided.";
}
?>
