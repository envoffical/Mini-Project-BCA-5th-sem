<?php
session_start();
include("connection.php");
$batch = $_SESSION['batch'];
$s_id = $_SESSION['st_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Marks</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        th{
            background-color:#0d6efd;
        }
        p{
            font-size:18px;
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
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Student Exam Results</h2>

    <?php
    if (isset($_POST['submit'])) {
        $sem = $_POST['sem'];
        $exam_name = $_POST['exam'];
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
                AND e.exam_name = '$exam_name'
                AND s.semester = '$sem'
                AND e.publish = '1'
        ";
        $res = mysqli_query($conn, $query);

        if (mysqli_num_rows($res) > 0) {
            echo '<p><strong>Exam name: </strong>' . htmlspecialchars($exam_name) . '</p>';
            echo '<p><strong>Semester:</strong> ' . htmlspecialchars($sem) . '</p>';
            //echo "Semester:$sem";
            //echo "<br>Exam name:$exam_name";
            echo '<div class="table-responsive">';
            echo '<table class="table table-bordered table-striped">';
            //echo '<thead">';
            echo '<tr>';
            echo '<br>';
            echo '<th>Subject Code</th>';
            echo '<th>Subject Name</th>';
            echo '<th>Mark Obtained</th>';
            echo '<th>Total Mark</th>';
            echo '<th>Percentage</th>';
            echo '<th>Status</th>';
            echo '</tr>';
            //echo '</thead>';
            echo '<tbody>';
            
            while ($row = mysqli_fetch_array($res)) {
                echo '<tr>';
                echo '<td>' . $sub_code=$row['subject_code'] . '</td>';
                echo '<td>' . $sub_name=$row['subject_name'] . '</td>';
                echo '<td>' . $mark=$row['mark_obtained'] . '</td>';
                echo '<td>' . $total=$row['total_mark'] . '</td>';
                
                // Calculate percentage
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
                
                echo '<td>' . $percent_display . '</td>';
                if($status=='Failed')
                        {
                            echo '<td class="red" >' . htmlspecialchars($status) . '</td>';
                        }
                        else{
                            echo '<td class="green">' . htmlspecialchars($status) . '</td>';
                        }
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo '
                <form action="download_studreport.php" method="post" class="mt-3">
                    <input type="hidden" name="selected_exam" value="' . htmlspecialchars($exam_name) . '">
                    <input type="hidden" name="hidden_sem" value="' . htmlspecialchars($sem) . '">
                    <input type="hidden" name="s_id" value="' . htmlspecialchars($s_id) . '">
                    <button type="submit" class="btn btn-primary">Download as PDF</button>
                </form>';
        } else {
            echo '<div class="alert alert-warning">No results found for the selected exam and semester.</div>';
        }
    }
    //echo '<button type="button" class="btn btn-secondary" onclick="back()">Back</button>';
    ?>
    <br>
    <input type="button" value="Back" name="Back" onclick="back()" class="btn btn-secondary">
</div>
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js">
    function back()
    {
        window.location.href= "stud_perform.php" ;
    }
</script>
</body>
</html>
