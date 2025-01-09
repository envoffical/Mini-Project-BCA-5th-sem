<?php
    
session_start();
include("connection.php");
$ex_id = $_SESSION['ex_id'];
$sub_code = $_SESSION['subject_code'];
$tot_mark = $_SESSION['tot_mark'];

if (isset($_POST['submit'])) {
    $stud_id = $_POST['student_id'];
    $mark = $_POST['mark'];
    
    if ($tot_mark >= $mark) {
        // Check if the mark for the student is already entered
        $check_query = "SELECT * FROM `marks_tab` WHERE student_id='$stud_id' AND exam_id='$ex_id' AND subject_code='$sub_code'";
        $check_result = mysqli_query($conn, $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
            // Update existing mark
            $query = "UPDATE `marks_tab` SET mark_obtained='$mark' WHERE student_id='$stud_id' AND exam_id='$ex_id' AND subject_code='$sub_code'";
            $message = "Marks updated successfully for student ID: $stud_id";
        } else {
            // Insert new mark
            $query = "INSERT INTO `marks_tab` (subject_code, exam_id, student_id, mark_obtained) 
                      VALUES ('$sub_code', '$ex_id', '$stud_id','$mark')";
            $message = "Marks entered successfully for student ID: $stud_id";
        }

        if (mysqli_query($conn, $query)) {
            // Redirect to the original page with a success message
            header("Location: marks_upload.php?success=" . urlencode($message));
            exit();
        } else {
            // Display error message if something goes wrong
            echo "Error updating marks: " . mysqli_error($conn);
        }
    } else {
        // Error when entered mark exceeds total mark
        echo "Mark obtained is greater than the total mark.";
    }
}
?>

?>
