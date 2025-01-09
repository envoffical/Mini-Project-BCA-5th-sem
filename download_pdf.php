<?php
require_once('TCPDF-main/tcpdf.php');
include("connection.php");

// Get POST data from the form
$batch = $_POST['hidden_batch'];
$sub = $_POST['hidden_subject'];
$ex_name = $_POST['selected_exam'];
$criteria = $_POST['criteria'];
$threshold = isset($_POST['threshold']) ? $_POST['threshold'] : null;

$query1="SELECT semester from `subject_tab` where subject_name='$sub'";
    $res1=mysqli_query($conn,$query1);
    if($res1)
    {
        $row=mysqli_fetch_array($res1);
        if($row)
        {
            $sem=$row['semester'];
        }
    }
$query = "SELECT exam_id, total_mark FROM `exam_tab` WHERE exam_name = '$ex_name'";
$res = mysqli_query($conn, $query);

if ($res) {
    $row = mysqli_fetch_assoc($res);
    if ($row) {
        $exam_id = $row['exam_id'];
        $tot_mark = $row['total_mark'];

        // Fetch student marks details
        $query = "
            SELECT 
                m.student_id, 
                m.mark_obtained, 
                s.student_name 
            FROM 
                `marks_tab` m
            JOIN 
                `student_tab` s ON m.student_id = s.student_id 
            WHERE 
                m.exam_id = '$exam_id'
        ";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {

            // Create a new PDF document
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Your Name');
            $pdf->SetTitle('Exam Report');
            $pdf->SetSubject('Exam Report');
            $pdf->SetKeywords('TCPDF, PDF, exam, report');

            // Add a page
            $pdf->AddPage();
            $pdf->SetMargins(15, 20, 15);

            // Add a header (optional)
            $imageFile = 'clg.png'; // Path to your image (if needed)
            if (file_exists($imageFile)) {
                $pdf->Image($imageFile, 10, 10, 180, 30, 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
            }

            // Set header style
            $pdf->SetFont('times', 'B', 16);
            $pdf->Ln(40);
            $pdf->Cell(0, 10, "Exam Report of $ex_name", 0, 1, 'C');
            $pdf->SetFont('times', '', 12);
            $pdf->Cell(0, 10, "Subject: $sub", 0, 1, 'B');
            $pdf->Cell(0, 10, "Semester: $sem", 0, 1, 'B');
            $pdf->Cell(0, 10, "Batch: $batch", 0, 1, 'B');
            $pdf->Cell(0, 10, "Criterion: $criteria", 0, 1, 'B');
            $pdf->Cell(0, 10, "Cut off: $threshold", 0, 1, 'B');
            $pdf->Ln(10);

            // Set font for table content
            $pdf->SetFont('times', 'B', 12);

            // Prepare table headers
            $html = '
                <table border="1" cellpadding="5">
                    <thead style="background-color: #f2f2f2;">
                        <tr>
                            <th style="text-align: center;">Student ID</th>
                            <th style="text-align: center;">Student Name</th>
                            <th style="text-align: center;">Marks</th>
                            <th style="text-align: center;">Percentage</th>
                            <th style="text-align: center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
            ';

            // Loop through the result to fetch each student's data
            while ($row = mysqli_fetch_array($result)) {
                $student_id = $row['student_id'];
                $student_name = $row['student_name'];
                $mark_obtained = $row['mark_obtained'];

                // Calculate percentage and status
                if (strtolower($mark_obtained) == "absent") {
                    $percent = "Absent";
                    $status = "Failed";
                } else {
                    $percent = ($mark_obtained / $tot_mark) * 100.0;
                    $status = ($percent >= 50) ? 'Passed' : 'Failed';
                }

                // Apply criteria filtering
                $display_row = false;
                if ($criteria === "All") {
                    $display_row = true; // Display all students
                } elseif ($criteria === "Pass" && $status === "Pass") {
                    $display_row = true; // Display only passed students
                } elseif ($criteria === "Failed" && $status === "Failed") {
                    $display_row = true; // Display only failed students
                } elseif ($criteria === "above threshold percentage" && is_numeric($percent) && $percent > $threshold) {
                    $display_row = true; // Display students above the threshold
                } elseif ($criteria === "below threshold percentage" && is_numeric($percent) && $percent < $threshold) {
                    $display_row = true; // Display students below the threshold
                }

                // Add the row to the table if criteria match
                if ($display_row) {
                    $html .= '
                        <tr>
                            <td style="text-align: center;">' . $student_id . '</td>
                            <td>' . $student_name . '</td>
                            <td style="text-align: center;">' . $mark_obtained . '</td>
                            <td style="text-align: center;">' . (is_numeric($percent) ? number_format($percent, 2) . '%' : $percent) . '</td>';
                            if ($status == 'Failed') {
                                $html .= '<td style="text-align: center; color: red; font-weight: bold;">' . $status . '</td>';
                            } else {
                                $html .= '<td style="text-align: center; color: green; font-weight: bold;">' . $status . '</td>';
                            }
                            
                    $html .= '</tr>';
                }
            }

            $html .= '</tbody></table>';

            // Output the HTML table in PDF
            $pdf->writeHTML($html, true, false, false, false, '');

            // Output the PDF as a download
            $pdf->Output('exam_report.pdf', 'D');
        } else {
            echo "No records found";
        }
    }
}
?>
