<?php
    include("connection.php"); // Ensure this file contains the database connection code

    if (isset($_POST['student_id'])) {
        $student_id = $_POST['student_id'];

        // SQL query to update the status to 0
        $query = "UPDATE student_tab SET status = 0 WHERE student_id = '$student_id'";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            echo "Student status updated successfully.";
        } else {
            echo "Error updating status: " . mysqli_error($conn);
        }
    } else {
        echo "No student ID received.";
    }

    // Close the connection
    mysqli_close($conn);
?>
