<?php
include("connection.php");

if (isset($_FILES['csv_file']['name'])) {
    $filename = $_FILES['csv_file']['tmp_name'];
    if ($_FILES['csv_file']['size'] > 0) {
        $file = fopen($filename, 'r');
        $firstRow = true;

        while (($data = fgetcsv($file, 1000, ',')) !== FALSE) {
            if ($firstRow) {
                $firstRow = false;
                continue; // Skip the header row
            }

            $subject_code = mysqli_real_escape_string($conn, $data[0]);
            $subject_name = mysqli_real_escape_string($conn, $data[1]);
            $semester = mysqli_real_escape_string($conn, $data[2]);
            $staff_id = mysqli_real_escape_string($conn, $data[3]);

            // Check if the subject already exists
            $query = "SELECT * FROM subject_tab WHERE subject_code='$subject_code'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                echo "Subject code $subject_code already exists. Skipping this entry.";
                continue;
            }

            // Insert subject data into the database
            $insertQuery = "INSERT INTO subject_tab (subject_code, subject_name, semester, staff_id) VALUES ('$subject_code', '$subject_name', '$semester', '$staff_id')";
            if (!mysqli_query($conn, $insertQuery)) {
                echo "Failed to insert data for subject $subject_code.";
            }
        }
        fclose($file);
        echo "CSV uploaded successfully.";
    } else {
        echo "Empty file or invalid file size.";
    }
} else {
   // echo "No file uploaded.";
}
?>
