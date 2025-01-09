<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Batch Upgrade</title>
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
            padding: 30px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        h3 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
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
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Close button -->
        <button class="btn-close" onclick="closePage()">&times;</button>

        <center>
            <h3>Batch Upgrade</h3>
            <form name="batch" method="POST" class="form">
                <div class="form-group">
                    <label for="batchSelect">Batch:</label>
                    <?php
                        include("connection.php");
                        $query = "SELECT DISTINCT batch FROM `batch_tab`";
                        $result = mysqli_query($conn, $query);

                        echo '<select id="batchSelect" name="batch" class="form-control">';
                        echo '<option value="">Select a batch</option>';
                        while ($row = mysqli_fetch_array($result)) {
                            echo '<option value="' . $row['batch'] . '">' . $row['batch'] . '</option>';
                        }
                        echo '</select>';
                    ?>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Upgrade" class="btn btn-primary">
                </div>
            </form>
        </center>

        <!-- PHP to process the form and upgrade the batch -->
        <?php
        if (isset($_POST['submit'])) {
            $batch = $_POST['batch'];
            $query = "SELECT semester FROM `batch_tab` WHERE batch='$batch'";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_array($res)) {
                    $sem = $row['semester'];
                }

                if ($sem == 6) {
                    $semn = "Pass out";
                } else if ($sem == "Pass out") {
                    echo "<div class='alert alert-warning'>No more semester upgrades possible.</div>";
                    exit;
                } else {
                    $semn = $sem + 1;
                }

                echo "<div class='alert alert-info'>Current semester: $sem</div>";

                if (isset($_POST['batch'])) {
                    $update_query = "UPDATE `batch_tab` SET `semester` = '$semn' WHERE batch='$batch'";
                    if (mysqli_query($conn, $update_query)) {
                        echo "<div class='alert alert-success'>Semester updated successfully.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error updating semester: " . mysqli_error($conn) . "</div>";
                    }
                }
            }
        }
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
        // Close page function
        function closePage() {
            window.location.href = "admin_dashboard.php";
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
