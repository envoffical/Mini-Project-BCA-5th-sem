<?php
session_start(); // Ensure the session is started

// Check if staff_id is set in the session
if (!isset($_SESSION['st_id'])) {
    die("Error: You must log in to access this page.");
}

include("connection.php");

// Get the staff_id from the session
$stud_id = $_SESSION['st_id'];
$ex_pass=$_SESSION['pass'];
if (isset($_POST['submit'])) {
    $current_pass = $_POST['current_pass'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];

    // Ensure new passwords match
    if ($new_pass === $confirm_pass) {
        // Fetch the current password from the database for verification
        /*$query = "SELECT binary password FROM login_tab WHERE student_id = '$stud_id'";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)>0)
        {
            while($row=mysqli_fetch_array($result))
            {
                $ex_pass=$row[0];
            }
        }*/
        if($ex_pass==$current_pass)
        {
            $update_query = "UPDATE `login_tab` SET password = '$new_pass' WHERE student_id = '$stud_id'";
            $res = mysqli_query($conn, $update_query);

            if ($res) {
                echo '<script type="text/javascript">alert("Password updated successfully.");</script>';
            } else {
                echo '<script type="text/javascript">alert("Password update failed. Please try again.");</script>';
            }
        }
        else {
            echo '<script type="text/javascript">alert("Incorrect current password.");</script>';
        }
    } else {
        echo '<script type="text/javascript">alert("New passwords do not match. Please try again.");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('minibg7.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        .container {
            margin-top: 50px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn-custom {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .btn-back {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-back:hover {
            background-color: #5a6268;
        }

        h1 {
            margin-bottom: 30px;
            color: #007bff;
        }

        /* Style for the round button with staff…*/
         .round-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #007bff;
            color: white;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <div class="container">
        <h1 class="text-center">Change Password</h1>
        <form name="change_password" method="POST">
            <div class="form-group">
                <label for="current_pass">Current Password:</label>
                <input type="password" id="current_pass" name="current_pass" class="form-control" required />
            </div>
            <div class="form-group">
                <label for="new_pass">New Password:</label>
                <input type="password" id="new_pass" name="new_pass" class="form-control" required />
            </div>
            <div class="form-group">
                <label for="confirm_pass">Confirm New Password:</label>
                <input type="password" id="confirm_pass" name="confirm_pass" class="form-control" required />
            </div>
            <div class="text-center">
                <input type="submit" name="submit" value="Change Password" class="btn btn-custom" />
                <br><br>
                <button type="button" class="btn btn-back" onclick="window.location.href='student_dashboard.php';">Back</button>
            </div>
        </form>
    </div>

</body>

</html>