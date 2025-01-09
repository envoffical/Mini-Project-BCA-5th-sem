<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Marks</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            margin:40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <?php
        include("connection.php");
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_SESSION['exam_name'] = $_POST['exam_name'];
            $_SESSION['subject_code'] = $_POST['subject_code'];
            //$_SESSION['semester'] = $_POST['semester'];
        }

        $exam_name = isset($_SESSION['exam_name']) ? $_SESSION['exam_name'] : '';
        $subject_code = isset($_SESSION['subject_code']) ? $_SESSION['subject_code'] : '';
        $sem = isset($_SESSION['semester']) ? $_SESSION['semester'] : '';
        
        echo "<p>Exam Name: " . htmlspecialchars($exam_name) . "</p>";
        echo "<p>Subject Code: " . htmlspecialchars($subject_code) . "</p>";
        //echo "<p>Semester: " . htmlspecialchars($sem) . "</p>";

        $query = "SELECT exam_id,total_mark FROM `exam_tab` WHERE exam_name='$exam_name'";
        $res = mysqli_query($conn, $query);
        $query1="SELECT subject_name from `subject_tab` where subject_code='$subject_code'";
        $result=mysqli_query($conn,$query1);
        if ($res) {
            $row = mysqli_fetch_array($res);
            $ex_id = $row['exam_id'];
            $tot_mark=$row['total_mark'];
            //echo "<p>Exam ID: " . htmlspecialchars($ex_id) . "</p>";
            $_SESSION['ex_id'] = $ex_id;
            $_SESSION['tot_mark'] = $tot_mark;
        }
        if($result)
        {
            $row=mysqli_fetch_array($result);
            $sub_name=$row['subject_name'];
        }
        echo "Subject name:$sub_name";
    ?>

    <!-- Bulk Upload Button --><br><br>
    <button type="button" class="btn btn-warning" onclick="back()">
        Back
    </button>
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#bulkUploadModal">
        Bulk Upload
    </button>
    
    <!-- Modal Structure -->
     <?php
        include("mark_csv_modal.php");
     ?>

    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Mark</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php      
                $query="SELECT student_tab.student_id, student_tab.student_name, marks_tab.mark_obtained 
                FROM `student_tab` 
                LEFT JOIN `marks_tab` 
                ON student_tab.student_id = marks_tab.student_id 
                WHERE student_tab.batch = (SELECT batch FROM `exam_tab` WHERE exam_id = '$ex_id') and status='1'";
        
    $res=mysqli_query($conn,$query);
    if(mysqli_num_rows($res)>0) {
        while($row=mysqli_fetch_array($res)) {
            $mark_obtained = isset($row['mark_obtained']) ? $row['mark_obtained'] : ''; // Get existing mark if available
            echo '<tr>';
            echo '<form method="POST" action="update_mark.php" onsubmit="return validateMark(this)">'; // Validation through JS
            echo '<td>'.$row['student_id'].'</td>';
            echo '<input type="hidden" name="student_id" value="' . $row['student_id'] . '">';
            echo '<td>'.$row['student_name'].'</td>';
            echo '<td>
                    <input type="text" name="mark" value="'.$mark_obtained.'" readonly>
                  </td>';
            echo '<td>
                    <button type="button" onclick="editMark(this)">Edit</button>
                    <input type="submit" name="submit" value="Update" style="display:none;">
                  </td>';
            echo '</form>';
            echo '</tr>';
        }
    }
    echo '</tbody>';
    echo '</table>';
    if (isset($_GET['success'])) {
        $success_message = urldecode($_GET['success']);
        echo '<div class="alert alert-success">' . $success_message . '</div>';
    }
?>

<script>
// Enable editing of the mark input
function editMark(button) {
    var row = button.closest('tr');
    var input = row.querySelector('input[name="mark"]');
    var submitButton = row.querySelector('input[type="submit"]');
    
    input.removeAttribute('readonly'); // Enable input field
    submitButton.style.display = 'inline'; // Show the update button
    button.style.display = 'none'; // Hide the edit button
}

// Validate that the mark is less than or equal to total mark
function validateMark(form) {
    var mark = form.mark.value;
    var totalMark = <?php echo $tot_mark; ?>;
    if (mark === "" || isNaN(mark) || mark < 0 || mark > totalMark) {
        alert("Please enter a valid mark (0-" + totalMark + ")");
        return false;
    }
    return true; // Proceed with form submission
}
</script>

        
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function back() {
            window.location.href = "manage_exams.php";
        }
    </script>
</body>
</html>           
