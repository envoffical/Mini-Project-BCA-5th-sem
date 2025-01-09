<?php
    session_start();
    include("connection.php");
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $ex_id = $_POST['exam_id'];
        $sub_code = $_POST['subject_code'];
    }
    $query = "SELECT student_id FROM `student_tab` WHERE batch = (select batch from `exam_tab` where exam_id='$ex_id' and subject_code='$sub_code')";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $all_published = true; // Assume all results are published until proven otherwise

    while ($row = mysqli_fetch_assoc($result)) {
        $student_id = $row['student_id'];

        // Step 2: Check if this student's marks are recorded for the given exam and subject
        $marks_query = "SELECT * FROM `marks_tab` 
                        WHERE student_id = '$student_id' 
                        AND exam_id = '$ex_id' 
                        AND subject_code = '$sub_code'";

        $marks_result = mysqli_query($conn, $marks_query);

        if (mysqli_num_rows($marks_result) == 0) {
            $all_published = false; // If any student is missing marks, we can't publish
            break;
        }
    }

    // Step 3: If all students have marks recorded, publish the result
    if ($all_published) {
        $publish_query = "UPDATE `exam_tab` 
                          SET publish = 1 
                          WHERE exam_id = '$ex_id' AND subject_code = '$sub_code'";
        
        if (mysqli_query($conn, $publish_query)) {
            echo "Result is published.";
        } else {
            echo "Failed to publish results: " . mysqli_error($conn);
        }
    } else {
        echo "Not all students have their marks recorded.";
    }
} else {
    echo "No students found for the given batch.";
}
$_SESSION['message'] = "Result is published.";
header("Location: manage_exams.php"); // Redirect back to the original page
exit();

?>