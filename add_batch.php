<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Add and View Batches</title>
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            max-width: 600px;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn {
            min-width: 120px;
            padding: 10px 15px;
            font-size: 16px;
        }

        /* Close button styling */
        .btn-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: transparent;
            border: none;
            font-size: 20px;
            color: #6c757d;
            cursor: pointer;
            transition: color 0.3s;
        }

        .btn-close:hover {
            color: #dc3545;
        }

        /* Alert box styling */
        .alert {
            margin-top: 20px;
        }

        table {
            width: 100%;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #dee2e6;
        }

        table th {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Close button -->
    <button class="btn-close" onclick="closePage()">&times;</button>

    <form name="batch_add" method="POST" onsubmit="return validateForm()">
        <div class="form-group">
            <label for="batchInput">Batch (Example: 2024-28):</label>
            <input type="text" class="form-control" id="batchInput" name="batch" placeholder="Enter batch year 2024-28" required>
        </div>
        <div class="form-group text-center">
            <input type="submit" name="submit" value="Insert" class="btn btn-primary">
        </div>
    </form>

    <?php
        include("connection.php");
        if (isset($_POST['submit'])) {
            $batch = $_POST['batch'];
            $sem = "1";
            $query = "INSERT INTO `batch_tab` VALUES ('$batch','$sem')";
            $res = mysqli_query($conn, $query);
            if ($res) {
                echo "<div class='alert alert-success'>New batch added successfully!</div>";
            } else {
                echo "<div class='alert alert-danger'>Error adding batch!</div>";
            }
        }
    ?>

    <h2 class="text-center">Batches</h2>
    <?php
        $query = "SELECT * FROM `batch_tab`";
        $res = mysqli_query($conn, $query);
        if (mysqli_num_rows($res) > 0) {
            echo '<table class="table table-bordered">';
            echo '<thead><tr><th>Batch</th><th>Semester</th></tr></thead>';
            echo '<tbody>';
            while ($row = mysqli_fetch_array($res)) {
                echo '<tr>';
                echo '<td>' . $row['batch'] . '</td>';
                echo '<td>' . $row['semester'] . '</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        } else {
            echo "<div class='alert alert-info'>No data found</div>";
        }
    ?>
</div>

<script>
    function closePage() {
        window.location.href = "admin_dashboard.php";
    }

    function validateForm() {
        var batch = document.getElementById("batchInput").value;
        var num = /^[0-9-]+$/; // Regular expression for digits and hyphens

        if (num.test(batch)) {
            return true;
        } else {
            return false;
        }
    }
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
