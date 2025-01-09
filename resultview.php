<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="\miniproject\home.css" rel="stylesheet"/>
    <style>
        body {
            background-image: url('minibg7.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-family: Arial, sans-serif;
        }

        .login-container {
            background: rgba(0, 0, 0, 0.5);
            padding: 30px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            margin-bottom: 30px;
            font-weight: bold;
        }

        .login-container input[type="text"], 
        .login-container input[type="password"] {
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
        }

        .btn-custom {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container text-center">
        <h2 id="head">Student Login</h2>
        <form name="checkresult" method="POST">
            <div class="form-group">
                <input type="text" name="st_id" class="form-control" placeholder="Username" required/>
            </div>
            <div class="form-group">
                <input type="password" name="pass" class="form-control" placeholder="Password" required/>
            </div>
            <input type="submit" name="submit" class="btn btn-success btn-custom" value="Login"/>
           <input type="button" value="Home" class="btn btn-primary btn-custom" onclick="home()"/>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function home() {
            window.location.href = "home.php";
        }
    </script>

    <?php
    if (isset($_POST['submit'])) {
        include("connection.php");
        $_SESSION['st_id'] = $_POST['st_id'];
        $s_id = $_SESSION['st_id'];
        $_SESSION['pass'] = $_POST['pass'];$pass = $_SESSION['pass'];
        //$pass = $_POST['pass'];
        if (empty($s_id) || empty($pass)) {
            echo '<p class="error-message">Please fill all fields</p>';
        } else {
            $query = "SELECT * FROM `login_tab` WHERE student_id= '$s_id' and password= '$pass'";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0) {
                header("Location:student_dashboard.php");
                exit();
            } else {
                echo '<script type="text/JavaScript">  
                alert("Invalid credentials"); 
                </script>';
            }
        }
    }
    ?>
</body>
</html>
