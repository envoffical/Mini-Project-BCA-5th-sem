<?php
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csvFile'])) {
    $fileName = $_FILES['csvFile']['tmp_name'];

    if ($_FILES['csvFile']['size'] > 0) {
        $file = fopen($fileName, 'r');

        // Skip the header row if present
        fgetcsv($file);

        while (($row = fgetcsv($file, 10000, ",")) !== FALSE) {
            $subject_code = $row[0];
            $subject_name = $row[1];
            $semester = $row[2];
            $staff_id = !empty($row[3]) ? $row[3] : NULL; // Allow staff_id to be null

            // Check for existing subjects
            $query = "SELECT * FROM subject_tab WHERE subject_code='$subject_code' OR subject_name='$subject_name'";
            $res = mysqli_query($conn, $query);

            if (mysqli_num_rows($res) == 0) {
                // Prepare query for safe data insertion, handling null staff_id
                $query1 = "INSERT INTO subject_tab (subject_code, subject_name, semester, staff_id, status) 
                           VALUES ('$subject_code', '$subject_name', '$semester', " . ($staff_id ? "'$staff_id'" : "NULL") . ", '1')";
                mysqli_query($conn, $query1);
            } else {
                // Handle tracking of existing subjects
                echo "<script>alert('Subject with code $subject_code or name $subject_name already exists');</script>";
            }
        }
        fclose($file);

        echo "<script>alert('Bulk upload successful'); window.location.href='add_subject.php';</script>";
    } else {
        echo "<script>alert('Please upload a valid CSV file'); window.location.href='add_subject.php';</script>";
    }
}
?>

