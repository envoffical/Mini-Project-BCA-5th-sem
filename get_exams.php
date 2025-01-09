<?php
session_start();
include("connection.php");

// Ensure that semester and batch are set
if (isset($_POST['semester']) && isset($_SESSION['batch'])) {
    $semester = $_POST['semester'];
    echo $semester;
    $batch = $_SESSION['batch'];

    // Prepare the SQL query to fetch exam names
    $sql = "SELECT distinct e.exam_name 
            FROM subject_tab s 
            JOIN exam_tab e ON s.subject_code = e.subject_code 
            WHERE s.semester = ? AND e.batch = ? AND e.publish='1'";

    // Use prepared statements for security
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $semester, $batch);  // Bind parameters: integer semester and string batch
    $stmt->execute();

    $result = $stmt->get_result();

    // Check if exams are found
    if ($result->num_rows > 0) {
        echo '<option value="">...</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . htmlspecialchars($row['exam_name']) . '">' . htmlspecialchars($row['exam_name']) . '</option>';
        }
    } else {
        echo '<option value="">No Exams Available</option>';
    }

    $stmt->close();
} else {
    echo '<option value="">Invalid Request</option>';
}
?>
