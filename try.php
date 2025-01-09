<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('minibg7.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: -1;
        }

        .login-container {
            max-width: 400px;
            width: 100%;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .login-container h3 {
            font-weight: 600;
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .btn-submit {
            background-color: #28a745;
            border: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
            width: 100%;
        }

        .btn-submit:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

        .btn-primary {
            width: 100%;
            margin-top: 10px;
        }

        .error-message {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-top: -15px;
            margin-bottom: 15px;
        }

        .form-label {
            font-weight: bold;
            color: #555;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #888;
        }

        @media (max-width: 576px) {
            .login-container {
                padding: 20px;
            }

            .btn-submit, .btn-primary {
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="login-container">
        <form name="login" method="POST">
            <h3>Login</h3>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="">Select Role</option>
                    <option value="Admin">Admin</option>
                    <option value="Faculty">Faculty</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="pass" id="password" class="form-control" required>
            </div>
            <div>
                <button type="submit" name="submit" class="btn btn-submit">Submit</button>
                <button type="button" class="btn btn-primary" onclick="home()">Home</button>
            </div>
            <!--<div class="footer">Forgot your password? <a href="#">Reset here</a></div>-->
        </form>

        <script>
            function home() {
                window.location.href = "home.php";
            }
        </script>

        <?php
        error_reporting(0);
        include("connection.php");
        if (isset($_POST['submit'])) {
            $role = $_POST['role'];
            $username = $_POST['username'];
            $password = $_POST['pass'];

            if (empty($role) || empty($username) || empty($password)) {
                echo '<p class="error-message">Please fill all fields</p>';
            } else {
                $stmt = $conn->prepare("SELECT * FROM `login_tab` WHERE BINARY role=? AND BINARY staff_id=? AND BINARY password=?");
                $stmt->bind_param("sss", $role, $username, $password);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    if ($role == "Admin") {
                        header("Location: admin_dashboard.php");
                    } elseif ($role == "Faculty") {
                        $_SESSION['username'] = $username;
                        header("Location: faculty_dashboard.php");
                    }
                } else {
                    echo '<script>alert("Invalid credentials");</script>';
                }
            }
        }
        ?>
    </div>
</body>
</html>
