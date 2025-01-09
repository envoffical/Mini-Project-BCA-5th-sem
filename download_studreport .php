<?php
require_once('TCPDF-main/tcpdf.php');
include("connection.php");

// Get POST data from the form
$sem = $_POST['hidden_sem'];
$s_id = $_POST['s_id'];
$ex_name = $_POST['selected_exam'];

        $query = "
            SELECT 
                s.subject_code, 
                s.subject_name, 
                m.mark_obtained, 
                e.total_mark
            FROM 
                marks_tab m
            JOIN 
                exam_tab e ON m.exam_id = e.exam_id
            JOIN 
                subject_tab s ON e.subject_code = s.subject_code
            WHERE 
                m.student_id = '$s_id'
                AND e.exam_name = '$ex_name'
                AND s.semester = '$sem'
                AND e.publish = '1'
        ";
        $res = mysqli_query($conn, $query);
        if (mysqli_num_rows($res) > 0) {

            // Create a new PDF document
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Your Name');
            $pdf->SetTitle('Student Report');
            $pdf->SetSubject('Student Report');
            $pdf->SetKeywords('TCPDF, PDF, student, report');

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
            $pdf->Cell(0, 10, "Student Exam Report", 0, 1, 'C');
            $pdf->SetFont('times', '', 12);
            $pdf->Cell(0, 10, "Exam name: $ex_name ", 0, 1, 'B');
            $pdf->Cell(0, 10, "Semester: $sem", 0, 1, 'B');
            $pdf->Cell(0, 10, "Student ID: $s_id", 0, 1, 'B');
            $pdf->Ln(10);

            // Set font for table content
            $pdf->SetFont('times', 'B', 12);

            // Prepare table headers
            $html = '
                <table border="1" cellpadding="5">
                    <thead style="background-color: #f2f2f2;">
                        <tr>
                            <th style="text-align: center;">Subject Code</th>
                            <th style="text-align: center;">Subject name Name</th>
                            <th style="text-align: center;">Mark obtained</th>
                            <th style="text-align: center;">Total mark</th>
                            <th style="text-align: center;">Percentage</th>
                            <th style="text-align: center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
            ';

            // Loop through the result to fetch each student's data
            while ($row = mysqli_fetch_array($res)) {
                $subcode = $row['subject_code'];
                $sub_name = $row['subject_name'];
                $mark_obtained = $row['mark_obtained'];
                $total = $row['total_mark'];

                if (is_numeric($row['mark_obtained'])) {
                    $percent = ($row['mark_obtained'] / $row['total_mark']) * 100;
                    $percent_display = number_format($percent, 2) . '%';
                } else {
                    $percent_display = 'Absent';
                }
                $status = '';
                    if (is_numeric($percent) && $percent >= 50) {
                        $status = 'Passed';
                    } elseif (strtolower($percent_display) === "absent" || (is_numeric($percent) && $percent < 50)) {
                        $status = 'Failed';
                    }
                    $html .= '
                        <tr>
                            <td style="text-align: center;">' . $subcode . '</td>
                            <td>' . $sub_name . '</td>
                            <td style="text-align: center;">' . $mark_obtained . '</td>
                            <td style="text-align: center;">' . $total . '</td>
                            <td style="text-align: center;">' . $percent_display . '</td>';
                            if ($status == 'Failed') {
                                $html .= '<td style="text-align: center; color: red; font-weight: bold;">' . $status . '</td>';
                            } else {
                                $html .= '<td style="text-align: center; color: green; font-weight: bold;">' . $status . '</td>';
                            }
                            
                    $html .= '</tr>';
            }

            $html .= '</tbody></table>';

            // Output the HTML table in PDF
            $pdf->writeHTML($html, true, false, false, false, '');

            // Output the PDF as a download
            $pdf->Output('student_exam_report.pdf', 'D');
        } else {
            echo "No records found";
        }
?>
