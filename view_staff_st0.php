<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staffs Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
        }
        h1, h2 {
            color: #007bff;
        }
        .table {
            background-color: #fff;
            border-radius: 0.25rem;
            box-shadow: 0 0 0.5rem rgba(0, 0, 0, 0.1);
        }
        .table thead th {
            background-color: #007bff;
            color: #fff;
        }
        .table tbody tr:hover {
            background-color: #e9ecef;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .no-records {
            font-style: italic;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
    <div>
            <button class="btn btn-primary" onclick="back()">Back</button>
        </div>
        <h1 class="text-center my-4">Staffs Management</h1>
        <?php
        include("connection.php");
        
        // Query to fetch Active Staffs
        $activeQuery = "SELECT * FROM `staff_tab` WHERE `status` = 1";
        $activeRes = mysqli_query($conn, $activeQuery);

        // Query to fetch Old Staffs
        $oldQuery = "SELECT * FROM `staff_tab` WHERE `status` = 0 AND `staff_code` != 'Admin'";
        $oldRes = mysqli_query($conn, $oldQuery);

        // Display Active Staffs
        echo "<h2 class='text-center my-4'>Active Staffs</h2>";
        if (mysqli_num_rows($activeRes) > 0) {
            echo "<div class='table-responsive'>
                <table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th>Staff ID</th>
                            <th>Staff Name</th>
                            <th>Email Id</th>
                        </tr>
                    </thead>
                    <tbody>";
            while ($row = mysqli_fetch_array($activeRes)) {
                echo "<tr>
                    <td>{$row['staff_code']}</td>
                    <td>{$row['staff_name']}</td>
                     <td>{$row['email']}</td>
                </tr>";
            }
            echo "</tbody></table></div>";
        } else {
            echo "<p class='text-center no-records'>No active staff found.</p>";
        }

        // Display Old Staffs
        echo "<h2 class='text-center my-4'>Old Staffs</h2>";
        if (mysqli_num_rows($oldRes) > 0) {
            echo "<div class='table-responsive'>
                <table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th>Staff ID</th>
                            <th>Staff Name</th>
                            <th>Email Id</th>
                        </tr>
                    </thead>
                    <tbody>";
            while ($row = mysqli_fetch_array($oldRes)) {
                echo "<tr>
                    <td>{$row['staff_code']}</td>
                    <td>{$row['staff_name']}</td>
                     <td>{$row['email']}</td>
                </tr>";
            }
            echo "</tbody></table></div>";
        } else {
            echo "<p class='text-center no-records'>No old staff found.</p>";
        }
        ?>

    </div>

    <script>
        function back() {
            window.location.href = "admin_dashboard.php";
        }
    </script>
</body>
</html>
