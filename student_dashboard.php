<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Welcome Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        body {
            background-image: url('minibg7.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .content {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            text-align: center;
            max-width: 800px;
            width: 100%;
            animation: fadeIn 1.5s ease-out;
        }

        h1 {
            font-size: 40px;
            margin-bottom: 20px;
            color: #f8f9fa;
        }

        p {
            font-size: 22px;
            color: #ffffff;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Person icon style */
        .person-icon {
            width: 50px;
            height: 50px;
            background-color: #007bff;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            cursor: pointer;
            position: absolute;
            top: 20px;
            right: 20px;
            animation: fadeIn 2s ease;
        }

        /* Styling the table for upcoming exams */
        .table {
            background-color: #343a40;
            border-radius: 10px;
            margin-top: 20px;
        }

        .table th, .table td {
            color: #f8f9fa;
        }

        .btn-back {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <button class="btn-back" onclick="logoutAndGoHome()">Home</button>

    <div class="person-icon" id="personIconContainer">
        <?php
        include("connection.php");
        $s_id = $_SESSION['st_id'];
        $query = "SELECT student_name, batch FROM `student_tab` WHERE student_id='$s_id'";
        $res = mysqli_query($conn, $query);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_array($res);
            $st_name = $row['student_name'];
            $_SESSION['batch'] = $row['batch'];
            $batch = $_SESSION['batch'];
            echo substr($st_name, 0, 1);
        }
        ?>
    </div>

    <div class="content">
        <h1>Welcome <?php echo $st_name; ?></h1>

        <?php
        $query = "SELECT semester FROM `batch_tab` WHERE batch='$batch'";
        $res = mysqli_query($conn, $query);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_array($res);
            $sem = $row['semester'];
            echo "<p>Batch:$batch</p>";
            echo "<p>Current semester: $sem</p>";
        }

        // Fetch today's date
        $today = date('Y-m-d');

        // Fetch exams for the specific batch
        $query = "SELECT * FROM `exam_tab` WHERE batch='$batch'";
        $res = mysqli_query($conn, $query);

        if (mysqli_num_rows($res) > 0) {
            $hasUpcomingExams = false;

            
            echo '<table class="table table-dark">';
            echo '<thead><tr><th>Exam Name</th><th>Exam Date</th><th>Subject</th><th>Total Mark</th></tr></thead>';
            echo '<tbody>';
            while ($row = mysqli_fetch_array($res)) {
                $ex_date = $row['exam_date'];
                $ex_name = $row['exam_name'];
                $tot_mark = $row['total_mark'];
                $sub_code = $row['subject_code'];

                // Check if the exam is upcoming
                if ($ex_date > $today) {
                    $hasUpcomingExams = true;

                    // Fetch the subject name
                    $subject_query = "SELECT subject_name FROM `subject_tab` WHERE subject_code='$sub_code'";
                    $subject_res = mysqli_query($conn, $subject_query);
                    $subject_name = mysqli_fetch_array($subject_res)['subject_name'];
                    echo "<p>Upcoming exams:</p>";
                    //echo '<table class="table table-dark">';
                    //echo '<thead><tr><th>Exam Name</th><th>Exam Date</th><th>Subject</th><th>Total Mark</th></tr></thead>';
                    //echo '<tbody>';
                    echo "<tr><td>$ex_name</td><td>$ex_date</td><td>$subject_name</td><td>$tot_mark</td></tr>";
                }
            }
            echo '</tbody></table>';

            if (!$hasUpcomingExams) {
                echo "<p>Hurray! No upcoming exams.</p>";
            }
        } else {
            echo "<p>No exams found for this batch.</p>";
        }
        ?>

        <button class="btn btn-primary" onclick="perform()">My Performance</button>
        <br>
        <button class="btn btn-primary" onclick="password()">Change Password</button>
    </div>

    <script>
        function logoutAndGoHome() {
            window.location.href = "home.php";
        }

        function perform() {
            window.location.href = "stud_perform.php";
        }

        function password() {
            window.location.href = "login_update_stud.php";
        }
    </script>
</body>

</html>
