<?php
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data from the request
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $batch = $_POST['batch'];
    $email = $_POST['email'];

    // Prepare the SQL query to update the student information
    $query = "UPDATE student_tab 
              SET student_name = ?, batch = ?, email = ? 
              WHERE student_id = ?";

    // Prepare and bind the statement
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('sssi', $student_name, $batch, $email, $student_id); // 'sssi' refers to 3 strings and 1 integer

        // Execute the query
        if ($stmt->execute()) {
            // If update is successful
            echo "Student updated successfully.";
        } else {
            // If an error occurs
            echo "Error: Could not update student.";
        }

        // Close the statement
        $stmt->close();
    } else {
        // If there is an issue preparing the statement
        echo "Error: Could not prepare the update query.";
    }

    // Close the connection
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
