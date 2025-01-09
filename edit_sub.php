<?php
if (isset($_POST['update'])) {
    include("connection.php");

    $subject_code = mysqli_real_escape_string($conn, $_POST['subject_code']);
    $s_name = mysqli_real_escape_string($conn, $_POST['s_name']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);
    $staff_id = mysqli_real_escape_string($conn, $_POST['staff_id']);

    $query = "UPDATE `subject_tab` SET s_name = ?, semester = ?, staff_id = ? WHERE subject_code = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $s_name, $semester, $staff_id, $subject_code);

    if ($stmt->execute()) {
        echo '<script type="text/JavaScript">  
        alert("Subject updated successfully");
        window.location.href = "main_page.php"; 
        </script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
