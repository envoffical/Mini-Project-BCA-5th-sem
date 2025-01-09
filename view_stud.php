<!doctype html>
<html>
<head>
    <title>Viewing Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{
            margin-left:150px;
            margin-right:150px;
            margin-top:50px;
            background:#f8f9fa;
        }
        #pencil:hover {
            cursor: pointer;  
        }
        #bin:hover {
            cursor: pointer;
        }
        th{
            background-color:#007bff;
        }
    </style>
</head>
<body><br>
    <h1><center>Students</center></h1>
    <input type="submit" name="submit" value="Back" class="btn btn-primary" onclick="back()">

    <?php
        include("connection.php");
        $query = "SELECT * FROM `student_tab` WHERE status=1";
        $res = mysqli_query($conn, $query);
        if (mysqli_num_rows($res) > 0) {
            echo "<br><br> 
            <table class='table table-bordered table-striped table-hover'>
                <thead class='text-center'>
                    <tr class='text-center'>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Batch</th>
                        <th>Email</th> <!-- New Email column -->
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>";                 
                while ($row = mysqli_fetch_array($res)) {
                    echo "<tr>
                        <td>{$row['student_id']}</td>
                        <td>{$row['student_name']}</td>
                        <td>{$row['batch']}</td>
                        <td>{$row['email']}</td> <!-- Displaying Email -->
                        <td>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-fill' id='pencil' viewBox='0 0 16 16' onclick=\"edit('{$row['student_id']}', '{$row['student_name']}', '{$row['batch']}', '{$row['email']}')\">
                                <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z'/>
                            </svg>
                        </td>
                        <td>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash3' id='bin' viewBox='0 0 16 16' onclick=\"del('{$row['student_id']}')\">
                                <path d='M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5'/>
                            </svg>
                        </td>
                    </tr>";
                }
            echo "</table>";
        } else {
            echo "No records found";
        }
    ?>

    <br><br>

    <!-- The Modal -->
    <div class="modal" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Update Student</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="updateForm">
                        <div class="form-group">
                            <label for="student_id">Student ID</label>
                            <input type="text" class="form-control" id="student_id" name="student_id" readonly>
                        </div>
                        <div class="form-group">
                            <label for="student_name">Student Name</label>
                            <input type="text" class="form-control" id="student_name" name="student_name" required>
                        </div>
                        <div class="form-group">
                            <label for="batch">Batch</label>
                            <select name="batch" class="form-control" id="batch" required>
                                <option value=""> </option>
                                <option value="2022-25">2022-25</option>
                                <option value="2023-26">2023-26</option>
                                <option value="2024-28">2024-28</option>
                            </select><br><br>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label> <!-- Email field in the modal -->
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        function back() {
            window.location.href = "admin_dashboard.php";
        }

        function edit(student_id, student_name, batch, email) {
            $('#student_id').val(student_id);
            $('#student_name').val(student_name);
            $('#batch').val(batch);
            $('#email').val(email);  // Set email value in the modal
            $('#editModal').modal('show');
        }

        function del(student_id) {
            if (confirm("Are you sure you want to delete this student?")) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "del_stud.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        location.reload();
                        alert("Success");
                    }
                };
                xhr.send("student_id=" + encodeURIComponent(student_id));
            }
        }

        $(document).ready(function() {
            $('#updateForm').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: 'update_stud.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Student updated successfully'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to update student'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
