
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Exam Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<?php
    include("connection.php");
    $s_id = $_SESSION['username'];
?>
<body>
    <div class="container mt-5">
        <!-- Button to trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#examModal">
            Create Exam
        </button>

        <!-- Modal -->
        <div class="modal fade" id="examModal" tabindex="-1" aria-labelledby="examModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="examModalLabel">Enter Exam Details</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="process_exam.php" method="POST" id="examForm">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exam_name">Exam Name</label>
                                <input type="text" class="form-control" id="exam_name" name="exam_name" required>
                            </div>
                            <div class="form-group">
                                <label for="exam_date">Exam Date</label>
                                <input type="date" class="form-control" id="exam_date" name="exam_date" required>
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <select class="form-control" id="subject" name="subject" required>
                                    <option value="">Select subject</option>
                                    <?php
                                        $query="SELECT subject_name from `subject_tab` WHERE staff_id='$s_id' and status='1'";
                                        $res=mysqli_query($conn,$query);
                                        while($row = mysqli_fetch_array($res))
                                        {
                                            echo '<option value="' . $row['subject_name'] . '">' . $row['subject_name'] . '</option>';
                                        }
                                        echo "</select>";
                                    ?>
                            </div>
                            <div class="form-group">
                                <label for="batch">Batch</label>
                                <select class="form-control" id="batch" name="batch" required>
                                    <option value="">Select Batch</option>
                                    <?php
                                        $query="SELECT distinct batch from `student_tab`";
                                        $res=mysqli_query($conn,$query);
                                        while($row = mysqli_fetch_array($res))
                                        {
                                            echo '<option value="' . $row['batch'] . '">' . $row['batch'] . '</option>';
                                        }
                                        echo "</select>";
                                    ?>
                            </div>
                            <div class="form-group">
                                <!--<label for="semester">Semester</label>
                                <select class="form-control" id="sem" name="sem" required>
                                    <option value="">Select semester</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                            </div>-->
                            <div class="form-group">
                                <label for="total_mark">Mark</label>
                                <input type="number" class="form-control" id="total_mark" name="total_mark" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
                            <button type="submit" class="btn btn-primary" name="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
    $('#examForm').on('submit', function(event){
        event.preventDefault(); // Prevent default form submission

        // Clear previous alerts
        $('#formAlert').html('');

        // Serialize form data
        var formData = $(this).serialize();

        // Send AJAX request
        $.ajax({
            url: 'process_exam.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response){
                if(response.success){
                    // Display success message
                    $('#formAlert').html('<div class="alert alert-success" role="alert">' + response.message + '</div>');
                    // Optionally, reset the form fields
                    $('#examForm')[0].reset();
                } else {
                    // Display error message
                    $('#formAlert').html('<div class="alert alert-danger" role="alert">' + response.message + '</div>');
                }
            },
            error: function(xhr, status, error){
                // Handle AJAX errors
                $('#formAlert').html('<div class="alert alert-danger" role="alert">An error occurred while processing the request.</div>');
            }
        });
    });
});

    </script>
</body>
</html>
