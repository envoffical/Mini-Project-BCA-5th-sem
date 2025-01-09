<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('minibg7.jpg') no-repeat center center fixed;
            background-size: cover;
            background-blend-mode: overlay;
            color: #fff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            position: relative;
            animation: fadeIn 1.5s ease-in-out forwards;
        }

        /* Fade-in animation for the entire body */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        /* Overlay effect */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .container {
            margin-top: 30px;
            background-color: rgba(255, 255, 255, 0.15);
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            z-index: 2;
            position: relative;
        }

        .header {
            text-align: center;
            margin-bottom: 50px;
            animation: slideIn 1.8s ease-out forwards;
        }

        /* Slide-in and fade-in effect for the header */
        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateY(-50px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header h1 {
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(45deg, #f0f, #0ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 2px;
        }

        .box {
            background: rgba(255, 255, 255, 0.25);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            margin: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            flex: 1;
            z-index: 2;
            position: relative;
            animation: boxFadeIn 1.8s ease forwards;
        }

        /* Subtle fade-in for the boxes */
        @keyframes boxFadeIn {
            0% {
                opacity: 0;
                transform: scale(0.95);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .box:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.4);
        }

        .box h3 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #fff;
        }

        .btn-group-vertical .btn {
            font-size: 1.1rem;
            padding: 12px 25px;
            border-radius: 5px;
            background-color: #4379F2;
            color: #fff;
            margin-bottom: 15px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-group-vertical .btn:hover {
            background-color: #365eb7;
            transform: scale(1.05);
        }

        .btn i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        /* Sign out button (Back button) */
        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 10px 20px;
            background: #ff4d4d;
            color: #fff;
            font-weight: 600;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            z-index: 2;
        }

        .back-btn:hover {
            background-color: #e63946;
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2.5rem;
            }

            .btn-group-vertical .btn {
                padding: 10px 15px;
                font-size: 1rem;
            }

            .box {
                margin-bottom: 20px;
            }

            .d-flex {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

    <!-- Back button -->
    <a href="home.php" class="btn back-btn"><i class="fas fa-sign-out-alt"></i> Sign Out</a>

    <!-- Flex Row for Boxes -->
    <div class="d-flex flex-wrap justify-content-center">
        <!-- Subject Management -->
        <div class="box">
            <h3>Subject</h3>
            <div class="btn-group-vertical">
                <button class="btn" onclick="location.href='add_subject.php'"><i class="fas fa-upload"></i> Upload</button>
                <button class="btn" onclick="location.href='view_subject.php'"><i class="fas fa-eye"></i> View</button>
                <button class="btn" onclick="location.href='template_sub.php'"><i class="fas fa-file-alt"></i> Template</button>
            </div>
        </div>

        <!-- Staff Management -->
        <div class="box">
            <h3>Staff</h3>
            <div class="btn-group-vertical">
                <button class="btn" onclick="location.href='staff_add.php'"><i class="fas fa-upload"></i> Upload</button>
                <button class="btn" onclick="location.href='view_staff.php'"><i class="fas fa-eye"></i> View</button>
                <button class="btn" onclick="location.href='view_staff_st0.php'"><i class="fas fa-users"></i> View All</button>
                <button class="btn" onclick="location.href='template_staff.php'"><i class="fas fa-file-alt"></i> Template</button>
            </div>
        </div>

        <!-- Student Management -->
        <div class="box">
            <h3>Student</h3>
            <div class="btn-group-vertical">
                <button class="btn" onclick="location.href='stud_add.php'"><i class="fas fa-upload"></i> Upload</button>
                <button class="btn" onclick="location.href='view_stud.php'"><i class="fas fa-eye"></i> View</button>
                <button class="btn" onclick="location.href='view_stud_st0.php'"><i class="fas fa-users"></i> View All</button>
                <button class="btn" onclick="location.href='template_stud.php'"><i class="fas fa-file-alt"></i> Template</button>
            </div>
        </div>

        <!-- Batch Management -->
        <div class="box">
            <h3>Batch</h3>
            <div class="btn-group-vertical">
                <button class="btn" onclick="location.href='batch_upgrade.php'"><i class="fas fa-layer-group"></i> Batch Upgrade</button>
                <button class="btn" onclick="location.href='add_batch.php'"><i class="fas fa-plus"></i> Add Batch</button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
