<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            margin-left:150px;
            margin-right:150px;
            margin-top:50px;
        }
        table th, table td {
            text-align: center;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        table tbody tr:hover {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <!-- Back Button -->
        <h1 class="text-center">Students</h1>
        <button class="btn btn-primary" onclick="back()">Back</button>

        <?php
        include("connection.php");

        // Query to fetch Active Students
        $activeQuery = "SELECT * FROM `student_tab` WHERE `status` = 1";
        $activeRes = mysqli_query($conn, $activeQuery);

        // Query to fetch Old Students
        $oldQuery = "SELECT * FROM `student_tab` WHERE `status` = 0";
        $oldRes = mysqli_query($conn, $oldQuery);

        // Display Active Students
        echo "<h2 class='my-4'>Active Students</h2>";
        if (mysqli_num_rows($activeRes) > 0) {
            echo "<table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>Register Number</th>
                        <th>Student Name</th>
                        <th>Email Id</th>
                        <th>Batch</th>
                        
                    </tr>
                </thead>
                <tbody>";
            while ($row = mysqli_fetch_array($activeRes)) {
                echo "<tr>
                    <td>{$row['student_id']}</td>
                    <td>{$row['student_name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['batch']}</td>
                   
                </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p class='text-center'>No active students found.</p>";
        }

        // Display Old Students
        echo "<h2 class='my-4'>Old Students</h2>";
        if (mysqli_num_rows($oldRes) > 0) {
            echo "<table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>Register Number</th>
                        <th>Student Name</th>
                        <th>Email Id</th>
                        <th>Batch</th>
                       
                    </tr>
                </thead>
                <tbody>";
            while ($row = mysqli_fetch_array($oldRes)) {
                echo "<tr>
                    <td>{$row['student_id']}</td>
                    <td>{$row['student_name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['batch']}</td>
                   
                </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p class='text-center'>No old students found.</p>";
        }
        ?>

    <script>
        function back() {
            window.location.href = "admin_dashboard.php";
        }
    </script>
</body>
</html>
