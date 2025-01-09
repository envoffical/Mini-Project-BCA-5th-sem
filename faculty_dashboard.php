<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            animation: fadeIn 1.5s ease-in-out forwards;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        /* Sidebar styling */
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
            color: white;
        }

        .sidebar a {
            padding: 15px 20px;
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
            transition: background-color 0.3s ease, transform 0.3s ease;
            font-size: 16px;
        }

        .sidebar a:hover {
            background-color: #495057;
            transform: translateX(10px);
        }

        .sidebar a.active {
            background-color: #007bff;
        }

        /* Main content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .faculty-icon {
            background-color: white;
            border-radius: 50%;
            color: #007bff;
            font-size: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border: 2px solid #007bff;
            transition: transform 0.3s ease;
        }

        .faculty-icon:hover {
            transform: scale(1.1);
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

/* Robot styled button - Sleek and Professional */
.robot-btn {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background: #87CEEB; /*linear-gradient(145deg, #6a82fb, #fc5c7d);  Gradient for a sleek look */
    border: none;
    color: white;
    font-size: 30px;
    padding: 20px;
    border-radius: 50%; /* Circular button */
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); /* Softer shadow for depth */
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
}

.robot-btn:hover {
    background: #696969; /*linear-gradient(145deg, #fc5c7d, #6a82fb); /* Reverse gradient on hover */
    transform: scale(1.1); /* Slightly enlarge on hover */
    box-shadow: 0 15px 25px rgba(0, 0, 0, 0.3); /* Increased shadow on hover */
}

.robot-icon {
    font-size: 24px; /* Standard icon size */
    color: #007bff; /* Blue color for the robot icon */
}


    </style>
</head>

<body>
    <div class="sidebar">
        <h4 class="text-center">Faculty Dashboard</h4>
        <a href="manage_exams.php">
            <i class="fas fa-clipboard-list"></i> Manage Exams
        </a>
        <a href="report.php">
            <i class="fas fa-chart-pie"></i> Reports
        </a>
        <a href="login_update.php">
            <i class="fas fa-key"></i> Change Password
        </a>
        <a href="home.php">
            <i class="fas fa-sign-out-alt"></i> Log Out
        </a>
    </div>

    <div class="main-content">
        <div class="header">
            <?php
            include("connection.php");
            $s_id = $_SESSION['username'];
            $query = "SELECT staff_name FROM `staff_tab` WHERE staff_code='$s_id'";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0) {
                $row = mysqli_fetch_array($res);
                $st_name = $row['staff_name'];
            }
            ?>
            <h3>Welcome, <?php echo $st_name; ?></h3>
            <div class="faculty-icon"><?php echo strtoupper(substr($st_name, 0, 1)); ?></div> <!-- Displaying first letter -->
        </div>

        <!-- Subjects Section -->
        <?php
        $query = "SELECT subject_name, semester FROM `subject_tab` WHERE staff_id='$s_id' AND status='1'";
        $res = mysqli_query($conn, $query);
        ?>
        <div class="card mt-4">
            <div class="card-header">Subjects Handled By You</div>
            <div class="card-body">
                <?php if (mysqli_num_rows($res) > 0): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Subject Name</th>
                                <th>Semester</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_array($res)): ?>
                                <tr>
                                    <td><?php echo $row['subject_name']; ?></td>
                                    <td><?php echo $row['semester']; ?></td>
                                    <td>
                                        <button class="btn btn-primary" onclick="viewStudents('<?php echo $row['semester']; ?>')">View Students</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-muted">No subjects available.</p>
                <?php endif; ?>
            </div>
        </div>

       <!-- Robot styled button -->
        <button class="robot-btn" onclick="window.location.href='apix.php'">
       <i class="fas fa-robot robot-icon"></i>
        </button>



    </div>

    <script>
        function viewStudents(semester) {
            window.location.href = "fetch_stud_fac.php?semester=" + semester;
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
