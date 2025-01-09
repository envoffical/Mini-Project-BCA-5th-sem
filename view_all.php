<!doctype html>
<html>
<head>
    <title>Viewing Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        #pencil:hover {
            cursor: pointer;  
        }
        #bin:hover {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1><center>Subjects</center></h1>

    <?php
        include("connection.php");
        $query = "SELECT * from `subject_tab` WHERE status=1";
        $res = mysqli_query($conn, $query);
        if (mysqli_num_rows($res) > 0) {
            echo "<br><br><br><br> <center> <table class='table table-bordered'>
                <tr>
                    <th>Subject code</th>
                    <th>Subject name</th>
                    <th>Semester</th>
                    <th>Staff</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr> <center>";               
                while ($row = mysqli_fetch_array($res)) {
                    $subject_name = addslashes($row['s_name']);
                    echo "<tr>
                        <td>{$row['subject_code']}</td>
                        <td>{$row['s_name']}</td>
                        <td>{$row['semester']}</td>
                        <td>{$row['staff_id']}</td>
                        <td>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-fill' id='pencil' viewBox='0 0 16 16' onclick=\"edit('{$row['subject_code']}', '{$row['s_name']}', '{$row['semester']}', '{$row['staff_id']}')\">
                                <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z'/>
                            </svg>
                        </td>
                        <td>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash3' id='bin' viewBox='0 0 16 16' onclick=\"del('{$subject_name}')\">
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
    <input type="submit" name="submit" value="Home" class="btn btn-primary" onclick="home()">
    <input type="submit" name="submit" value="Back" class="btn btn-primary" onclick="back()">

    <!-- The Modal -->
    <div class="modal" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Update Subject</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="updateForm">
                        <div class="form-group">
                            <label for="subject_code">Subject Code</label>
                            <input type="text" class="form-control" id="subject_code" name="subject_code" readonly>
                        </div>
                        <div class="form-group">
                            <label for="s_name">Subject Name</label>
                            <input type="text" class="form-control" id="s_name" name="s_name" required>
                        </div>
                        <div class="form-group">
                            <label for="semester">Semester</label>
                            <input type="text" class="form-control" id="semester" name="semester" required>
                        </div>
                        <div class="form-group">
                            <label for="staff_id">Staff ID</label>
                            <input type="text" class="form-control" id="staff_id" name="staff_id" required>
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
        function home() {
            window.location.href = "home.php";
        }

        function back() {
            window.location.href = "admin_dashboard.php";
        }

        function edit(subject_code, subject_name, semester, staff_id) {
            $('#subject_code').val(subject_code);
            $('#s_name').val(subject_name);
            $('#semester').val(semester);
            $('#staff_id').val(staff_id);
            $('#editModal').modal('show');
        }

        function del(subject) {
            if (confirm("Are you sure you want to delete this subject?")) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "del_sub.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Optionally, you can refresh the page or remove the row from the DOM
                        location.reload();
                        alert("Success");
                    }
                };
                xhr.send("sub=" + encodeURIComponent(subject));
            }
        }

        $(document).ready(function() {
            $('#updateForm').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: 'update_sub.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Subject updated successfully'
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
                            text: 'Failed to update subject'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
