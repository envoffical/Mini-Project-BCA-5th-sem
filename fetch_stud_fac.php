<?php
include("connection.php");

if (isset($_GET['semester'])) {
    $semester = $_GET['semester'];
    // Fetch students from the database based on the semester
    $query = "SELECT student_id, student_name FROM `student_tab` WHERE batch=(select batch from `batch_tab` where semester='$semester') and status='1'";
    $result = mysqli_query($conn, $query);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Student Details</title>
        <!-- Bootstrap CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-color: #f8f9fa;
            }
            .container {
                margin-top: 50px;
            }
            .table {
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            .table th {
                background-color: #007bff;
                color: white;
            }
            .no-data {
                text-align: center;
                padding: 20px;
                color: #6c757d;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h2 class="text-center mb-4">Student Details</h2>
            <input type="Submit" value="Back" class="btn btn-primary" onclick="back()"/><br><br>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>' . $row['student_id'] . '</td>';
                            echo '<td>' . $row['student_name'] . '</td>';
                            //echo '<td>' . $row['semester'] . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="3" class="no-data">No students found for this semester.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Bootstrap JS and dependencies -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>
    <?php
} else {
    echo "Invalid request method";
}
?>
<script>
    function back()
    {
        window.location.href="faculty_dashboard.php";
    }


</script>