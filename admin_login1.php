<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin-top: 30px;
        }
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.1);
        }
        .form-control {
            margin-bottom: 15px;
        }
        .btn-submit {
            background-color: #28a745;
            border: none;
            padding: 12px 24px;
            color: #fff;
            font-size: 18px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-submit:hover {
            background-color: #218838;
        }
        .error-message {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>

<br><br><br><br><br>
    <div class="container-fluid">
        <div class="login-container">
            <form name="login" method="POST">
                <h3 class="text-center mb-4">Admin Login</h3>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-select">
                        <option value="null"></option>
                        <option value="Admin">Admin</option>
                        <option value="Faculty">Faculty</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="user" id="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="pass" id="password" class="form-control" required>
                </div>
                <div class="text-center">
                    <input type="submit" name="submit" value="Submit" class="btn btn-submit">
                    <input type="submit" name="submit" value="Home" class="btn btn-primary" onclick="home()">
                </div>
                <script>
                    function home()
                    {
                        window.location.href="home.php";
                    }
                </script>
                <?php
                    error_reporting(0);
                    include("connection.php");
                    if ((isset($_POST) == ["submit"])) {
                        $role = $_POST['role'];
                        $username = $_POST['user'];
                        $password = $_POST['pass'];
                    
                        // Validate inputs
                        if ($role == "null" || empty($username) || empty($password)) {
                            echo '<p class="error-message">Please fill all fields</p>';
                            //echo '<script type="text/JavaScript">  
     //alert("Please fill all fields"); 
     //</script>' 
; 
                        } else {
                            // Prepare the SQL query
                            $stmt = $conn->prepare("SELECT * FROM `login_tab` WHERE BINARY role=? AND BINARY username=? AND BINARY password=?");
                            $stmt->bind_param("sss", $role, $username, $password);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if (mysqli_num_rows($result) > 0) {
                                // Successful login
                                // Redirect to appropriate dashboard based on role
                                if ($role == "Admin") {
                                    header("Location:admin_dashboard.php");
                                } elseif ($role == "Faculty") {
                                    header("Location:faculty_dashboard.php");
                                }
                            } else {
                                // Invalid credentials
                                //echo '<p class="error-message">Invalid credentials</p>';
                                echo '<script type="text/JavaScript">  
                                alert("Invalid credentials"); 
                                 </script>' ; 
                            }
                        }
                    }
                ?>
            </form>
        </div>
    </div>
</body>
</html>
