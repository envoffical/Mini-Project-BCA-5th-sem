<?php 
    session_start();
    include("connection.php");
    $batch = $_SESSION['batch'];
    $s_id = $_SESSION['st_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        body {
            background-color: #f8f9fa;
            padding: 50px;
        }
        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }
        .form-group label {
            font-weight: bold;
        }
        #submitBtn {
            margin-top: 20px;
            width: 100%;
        }
        .modal-content {
            border-radius: 10px;
        }
        .modal-header {
            background-color: #007bff;
            color: #ffffff;
        }
        .modal-body table {
            width: 100%;
        }
        .modal-body th, .modal-body td {
            padding: 8px;
            text-align: left;
        }
        .modal-body th {
            background-color: #f2f2f2;
        }
        /* Style for X Button */
        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            cursor: pointer;
        }
        .close-btn:hover {
            color: #000;
        }
    </style>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

    <!-- Form Container -->
    <div class="form-container">
        <!-- X Button to redirect -->
        <span class="close-btn" onclick="redirectToDashboard()">X</span>

        <h2 class="text-center">Select Semester and Exam</h2>
        <form id="semForm" method="POST" action="display_studmarks.php">
            <div class="form-group">
                <label for="semester">Select a Semester</label>
                <select class="form-control" name="sem" id="semester">
                    <option value="">Select a semester</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
            </div>

            <div class="form-group">
                <label for="exam">Exams Conducted:</label>
                <select class="form-control" id="exam" name="exam">
                    <option value="">Select Exam</option>
                </select>
            </div>

            <input type="submit" name="submit" id="submitBtn" class="btn btn-primary">
        </form>
    </div>
            </div>
        </div>
    </div>

    <script>
        // Function to redirect to student dashboard
        function redirectToDashboard() {
            window.location.href = 'student_dashboard.php';  // Redirects to the dashboard page
        }

        $(document).ready(function() {
            // When the semester dropdown changes
            $('#semester').change(function() {
                var selectedSemester = $(this).val();

                if (selectedSemester) {
                    $.ajax({
                        url: 'get_exams.php',  // PHP script to get exams
                        type: 'POST',
                        data: {semester: selectedSemester},
                        success: function(response) {
                            $('#exam').html(response);  // Populate exams dropdown
                        },
                        error: function(xhr, status, error) {
                            console.log("AJAX Error: " + status + error);
                        }
                    });
                } else {
                    $('#exam').html('<option value="">Select Exam</option>');
                }
            });
        });
    </script>

</body>
</html>
