<?php
// Specify the file path
$file = 'C:\\wamp64\\www\\miniproject env\\sample_student.csv';

// Check if the file exists
if (file_exists($file)) {
    // Set headers to initiate download
    header('Content-Description: File Transfer');
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    
    // Read the file and send it to the output buffer
    readfile($file);
    exit;
} else {
    echo "File not found.";
}
?>
