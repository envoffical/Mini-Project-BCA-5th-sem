<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Manage Exams</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
        .person-icon {
            width: 40px;
            height: 40px;
            background-color: #007bff;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            position: absolute;
            top: 20px;
            right: 30px;
        }
        h3 {
            margin-top: 20px;
        }
        table {
            width: 100%;
            margin-top: 20px;
        }
        th {
            background-color: #343a40;
            color: #fff;
        }
        td {
            text-align: center;
        }
        .btn {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <input type="button" class="btn btn-warning mb-3" value="Back" onclick="back()" />
        
        <?php
            include("connection.php");
            $s_id = $_SESSION['username'];
            $query="SELECT staff_name FROM `staff_tab` WHERE staff_code='$s_id'";
            $res=mysqli_query($conn,$query);
            if(mysqli_num_rows($res) > 0) {
                $row = mysqli_fetch_array($res);
                $st_name = $row['staff_name'];
            }
            echo "<h3>Welcome, $st_name</h3>";
            echo '<div class="person-icon" id="personIconContainer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $firstLetter = substr(trim($st_name), 0, 1);
            echo $firstLetter;
            echo '</div>';
            
            include("exams.php");
            $query="SELECT * FROM `exam_tab` WHERE subject_code IN (SELECT subject_code from subject_tab WHERE staff_id='$s_id')";
            $res=mysqli_query($conn,$query);
            if(mysqli_num_rows($res) > 0) {
                echo '<table class="table table-bordered table-hover">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Exam Name</th>';
                echo '<th>Exam Date</th>';
                echo '<th>Subject</th>';
                echo '<th>Batch</th>';
                echo '<th>Total Mark</th>';
                echo '<th>Upload and View Marks</th>';
                echo '<th>Action</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while($row = mysqli_fetch_array($res)) {
                    echo '<tr>';
                    $ex_id=$row['exam_id'];
                    echo '<td>' . $row['exam_name'] . '</td>';
                    echo '<td>' . $row['exam_date'] . '</td>';
                    $subject_code = $row['subject_code']; // Assuming subject_code is already fetched
                    $query = "SELECT subject_name FROM subject_tab WHERE subject_code = '$subject_code'";
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                        $subject_row = mysqli_fetch_array($result);
                        $subject_name = $subject_row['subject_name'];
                         echo '<td>' . $subject_name . '</td>';
                    }
                    echo '<td>' . $row['batch'] . '</td>';
                    echo '<td>' . $row['total_mark'] . '</td>';
                    echo "<td>
                <form method='post' action='marks_upload.php'>
                    <input type='hidden' name='exam_name' value='" . $row['exam_name'] . "'>
                    <input type='hidden' name='subject_code' value='" . $row['subject_code'] . "'>
                    <button type='submit' class='btn btn-secondary btn-sm' name='upload'>Upload</button>
                </form>
              </td>";
              $publish_query = "SELECT publish FROM `exam_tab` WHERE exam_id = '$ex_id' AND subject_code = '$subject_code'";
              $publish_result = mysqli_query($conn, $publish_query);
              if(mysqli_num_rows($publish_result)>0)
              {
                  $publish_status = mysqli_fetch_assoc($publish_result);
                  if($publish_status['publish'] == 1) {
                    echo '<td><a class="btn btn-secondary disabled" href="#">Published</a></td>';
                }
                
                  else{
                        echo "<td>
                        <form method='post' action='publish_marks.php'>
                        <input type='hidden' name='exam_id' value='" . $row['exam_id'] . "'>
                        <input type='hidden' name='subject_code' value='" . $row['subject_code'] . "'>
                        <button type='submit' class='btn btn-secondary btn-sm' name='publish' id='publish'>Publish Marks
                        </button></form></td>";
                        }
              }
                
            }
        }
            if (isset($_SESSION['message'])) {
                echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
                unset($_SESSION['message']);
            }
            echo '</tbody>';
                echo '</table>';
        ?>
    </div>
    <script>
        function back() {
            window.location.href = "faculty_dashboard.php";
        }
        function marks() {
            window.location.href = "marks_upload.php";
        }
    </script>
</body>
</html>
