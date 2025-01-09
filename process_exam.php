<?php
include("connection.php"); // Include your database connection file

header('Content-Type: application/json'); // Set the content type to JSON

$response = array('success' => false, 'message' => ''); // Initialize the response array

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $examName = $_POST['exam_name'];
    $examDate = $_POST['exam_date'];
    $subject = $_POST['subject'];
    $batch = $_POST['batch'];
    $mark = $_POST['total_mark'];

    // Fetch the subject code
    $query = "SELECT subject_code FROM `subject_tab` WHERE subject_name = '$subject'";
    $res = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_array($res);
        $sub = $row['subject_code'];

        // Insert the exam data
        $query = "INSERT INTO `exam_tab` (exam_name, exam_date, batch, subject_code, total_mark) VALUES ('$examName', '$examDate', '$batch', '$sub', '$mark')";
        $res = mysqli_query($conn, $query);
        if ($res) {
                $response['success'] = true;
                $response['message'] = 'Exam created successfully';
        } else {
    $response['success'] = false;
    $response['message'] = 'Error: ' . mysqli_error($conn);
}
} else {
$response['success'] = false;
$response['message'] = 'Subject not found';
}
} else {
$response['success'] = false;
$response['message'] = 'Invalid request method';
}

json_encode($response);


?>