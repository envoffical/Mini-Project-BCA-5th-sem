<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('minibg7.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            animation: fadeIn 2s ease-in-out;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom right, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.3));
            backdrop-filter: blur(5px);
            z-index: -1;
        }

        .header {
            width: 100%;
            text-align: center;
            margin-top: 20px;
            animation: slideIn 1.5s ease-in-out;
        }

        h1 {
            font-family: 'Roboto', sans-serif;
            font-weight: 600;
            margin-bottom: 10px;
            color: #f0f0f0;
            opacity: 0;
            animation: fadeInText 2s ease forwards;
        }

        .marquee {
            font-weight: 300;
            color: #f0f0f0;
            margin-bottom: 20px;
            opacity: 0;
            animation: fadeInMarquee 2.5s ease forwards;
        }

        .content {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
            animation: fadeInContent 3s ease forwards;
        }

        .btn {
            font-size: 1.2rem;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-success:hover, .btn-primary:hover {
            background-color: rgba(255, 255, 255, 0.4);
            transform: scale(1.05);
        }

        .table-container {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.25);
            text-align: center;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            0% {
                transform: translateY(-50px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeInText {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInMarquee {
            0% {
                opacity: 0;
                transform: translateX(-50px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInContent {
            0% {
                opacity: 0;
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="header">
        <h1>Student Result Management System</h1>
        <marquee>Department of Computer Applications</marquee>
    </div>

    <div class="content">
        <div class="table-container">
            <form method="POST" action="resultview.php">
                <button type="submit" class="btn btn-success btn-lg btn-block">Student Login</button>
            </form>
            <br>
            <form method="POST" action="admin_login.php">
                <button type="submit" class="btn btn-primary btn-lg btn-block mb-3">Faculty and Administrative Staff</button>
            </form>
        </div>
    </div>
</body>
</html>
