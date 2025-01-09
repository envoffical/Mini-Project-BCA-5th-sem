<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View table</title>
</head>
<body>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{
            margin:100px;
        }
        .red{
            color:red;
            font-weight:bold;
        }
        .green{
            color:green;
            font-weight:bold;
        }
    </style>
</body>
</html>

<?php
    session_start();
    include("connection.php");
    
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
    
            // Fetch marks and student details
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
                    m.exam_id = '$exam_id' and s.status='1'
            ";
    
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                // Display Batch, Subject, and Exam details once at the top
                echo '
                <div class="container mt-4">
                    <h3 class="text-center">Report for ' . htmlspecialchars($ex_name) . '</h3>
                    <p><strong>Subject:</strong> ' . htmlspecialchars($sub) . '</p>
                    <p><strong>Semester:</strong> ' . htmlspecialchars($sem) . '</p>
                    <p><strong>Batch:</strong> ' . htmlspecialchars($batch) . '</p>
                    <br>';
    
                // Display the student marks in a table
                echo '
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Marks</th>
                            <th>Percentage</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>';
    
                while ($row = mysqli_fetch_array($result)) {
                    $student_id = $row['student_id'];
                    $student_name = $row['student_name'];
                    $mark_obtained = $row['mark_obtained'];
    
                    // Calculate percentage or display 'Absent'
                    if (strtolower($mark_obtained) == "absent") {
                        $percent = "Absent";
                    } else {
                        $percent = ($mark_obtained / $tot_mark) * 100.0;
                    }
    
                    // Determine pass/fail status
                    $status = '';
                    if (is_numeric($percent) && $percent >= 50) {
                        $status = 'Passed';
                    } elseif (strtolower($percent) === "absent" || (is_numeric($percent) && $percent < 50)) {
                        $status = 'Failed';
                    }
    
                    // Logic for filtering based on criteria
                    $display_row = false;
                    if ($criteria === "All") {
                        $display_row = true;
                    } elseif ($criteria === "Pass" && $status === "Pass") {
                        $display_row = true;
                    } elseif ($criteria === "Failed" && $status === "Failed") {
                        $display_row = true;
                    } elseif ($criteria === "above threshold percentage" && is_numeric($percent) && $percent > $threshold) {
                        $display_row = true;
                    } elseif ($criteria === "below threshold percentage" && is_numeric($percent) && $percent < $threshold) {
                        $display_row = true;
                    }
    
                    // Display rows based on criteria
                    if ($display_row) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($student_id) . '</td>';
                        echo '<td>' . htmlspecialchars($student_name) . '</td>';
                        echo '<td>' . htmlspecialchars($mark_obtained) . '</td>';
                        if (is_numeric($percent)) {
                            echo '<td>' . number_format($percent, 2) . '%</td>';
                        } else {
                            echo '<td>' . htmlspecialchars($percent) . '</td>';
                        }
                        if($status=='Failed')
                        {
                            echo '<td class="red" >' . htmlspecialchars($status) . '</td>';
                        }
                        else{
                            echo '<td class="green">' . htmlspecialchars($status) . '</td>';
                        }
                        echo '</tr>';
                    }
                }
    
                echo '
                    </tbody>
                </table>';
    
                // Download PDF button
                echo '
                <form action="download_pdf.php" method="post" class="mt-3">
                    <input type="hidden" name="hidden_batch" value="' . htmlspecialchars($batch) . '">
                    <input type="hidden" name="hidden_subject" value="' . htmlspecialchars($sub) . '">
                    <input type="hidden" name="selected_exam" value="' . htmlspecialchars($ex_name) . '">
                    <input type="hidden" name="criteria" value="' . htmlspecialchars($criteria) . '">
                    <input type="hidden" name="threshold" value="' . htmlspecialchars($threshold) . '"><br>
                    <button type="submit" class="btn btn-success">Download as PDF</button>
                </form>
                </div>';
            } else {
                echo '<p class="text-danger text-center">No records found</p>';
            }
        }
        echo '<button type="button" class="btn btn-secondary" onclick="back()">Back</button>';
    }
    ?>
    
    <script>
    function back() {
        window.location.href = "faculty_dashboard.php";
    }
    </script>
    
    <!-- Bootstrap CSS -->
    