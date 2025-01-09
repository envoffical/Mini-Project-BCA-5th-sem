<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h3 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
            color: #343a40;
        }
        label {
            font-weight: bold;
            color: #495057;
        }
    </style>
    <div class="container">
    <h2><center>Report Details</center></h2>
</body>
</html>
<label for="batch">Select Batch:</label>
<?php
    session_start();
    include("connection.php");
    //require_once('TCPDF-main/tcpdf.php');
    $s_id=$_SESSION['username'];
    $query1 = "SELECT distinct batch FROM `batch_tab` WHERE semester IN(select distinct semester from `subject_tab` where staff_id='$s_id')";
    $res1 = mysqli_query($conn, $query1);
    if(mysqli_num_rows($res1)>0)
    {
        echo '<select class="form-control" name="batch_dropdown" id="batch_dropdown"> required'; 
        echo '<option value="">Select a batch</option>';
        while($row=mysqli_fetch_array($res1))
        {
            echo '<option value="' . $row['batch'] . '">' . $row['batch'] . '</option>'; 
        }
        echo '</select>';
    }
    else{
        echo 'No batches available.';
    }
    echo '<br><br>';
?>
    <div class="form-group">
    <label for="subject">Select Subject:</label>
    <select class="form-control" name="subject_dropdown" id="subject_dropdown" >
        <option value="">Select a subject</option>
    </select>
</div>
    <br>

    <!-- Exam Dropdown (Initially empty, filled after subject selection) -->
    <div class="form-group">
    <label for="exam">Select Exam:</label>
    <select class="form-control" name="exam_dropdown" id="exam_dropdown">
        <option value="">Select an exam</option>
    </select>
</div>
    <div class="form-group">
    <form method="POST" action="generate_report.php">
    <input type="hidden" id="hidden_batch" name="hidden_batch" value="">
    <input type="hidden" id="hidden_subject" name="hidden_subject" value="">
    <input type="hidden" id="selected_exam" name="selected_exam" value=""><br>
    <label for="criteria">Select Criteria:</label><br>
    <select class="form-control" name="criteria" id="criteria" onchange="showThresholdInput()">
    <option value="">Select a criteria</option>
        <option value="All">All</option>
        <option value="Pass">Pass</option>
        <option value="Failed">Failed</option>
        <option value="above threshold percentage">Above threshold percentage</option>
        <option value="below threshold percentage">Below threshold percentage</option>
</select><br><br>
        <div id="thresholdInput" style="display:none;">
        <label for="threshold">Enter threshold percentage:</label><br>
        <input type="text" id="threshold" name="threshold" placeholder="Enter percentage" class="form-control">
    </div><br><br>
    <input type="submit" name="submit" value="Generate Report" class="btn btn-success">
</form></div>
    <script>
        // Fetch subjects based on selected batch
        $('#batch_dropdown').on('change', function() {
            var batch = $(this).val();
            if(batch) {
                $.ajax({
                    type: 'POST',
                    url: 'fetch_subjects.php', // Server-side script to process the request
                    data: { batch: batch },
                    success: function(response) {
                        $('#subject_dropdown').html(response); // Fill subject dropdown
                        $('#exam_dropdown').html('<option value="">Select an exam</option>'); // Reset exam dropdown
                    }
                });
                $('#hidden_batch').val(batch);
            } else {
                $('#subject_dropdown').html('<option value="">Select a subject</option>');
                $('#exam_dropdown').html('<option value="">Select an exam</option>');
                $('#hidden_batch').val(''); // Reset hidden batch value
            }
        });

        // Fetch exams based on selected subject
        $('#subject_dropdown').on('change', function() {
            var subject = $(this).val();
            var batch = $('#batch_dropdown').val();
            if(subject&&batch) {
                $.ajax({
                    type: 'POST',
                    url: 'fetch_exams.php', // Server-side script to process the request
                    data: { subject: subject, batch: batch },
                    success: function(response) {
                        $('#exam_dropdown').html(response); // Fill exam dropdown
                    }
                });
                $('#hidden_subject').val(subject);
            } else {
                $('#exam_dropdown').html('<option value="">Select an exam</option>');
                $('#hidden_subject').val(''); 
            }
        });
        $('#exam_dropdown').on('change', function() {
        var selectedExam = $(this).val(); // Get the selected exam value
        $('#selected_exam').val(selectedExam);
    });

    function showThresholdInput() {
        var criteria = document.getElementById("criteria").value;
        var thresholdInput = document.getElementById("thresholdInput");

        if (criteria === "above threshold percentage" || criteria === "below threshold percentage") {
            thresholdInput.style.display = "block";
        } else {
            thresholdInput.style.display = "none";
        }
    }
    </script>
    </div>
</body>
</html>    
