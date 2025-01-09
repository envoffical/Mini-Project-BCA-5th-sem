<?php
include("connection.php");

if (isset($_POST['subject_code']) && isset($_POST['subject_name']) && isset($_POST['semester']) && isset($_POST['staff_id'])) {
    $subject_code = $_POST['subject_code'];
    $subject_name = $_POST['subject_name'];
    $semester = $_POST['semester'];
    $staff_id = $_POST['staff_id'];

    // Update the subject details in the database
    $query = "UPDATE `subject_tab` SET `subject_name` = ?, `semester` = ?, `staff_id` = ? WHERE `subject_code` = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $subject_name, $semester, $staff_id, $subject_code);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
} else {
    echo "error";
}

$conn->close();
?>
