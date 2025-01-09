<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viewing Staff Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
        }
        .table thead th {
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
        }
        .table tbody td {
            text-align: center;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .modal-content {
            border-radius: 10px;
        }
        .icon-btn {
            cursor: pointer;
            font-size: 1.2rem;
        }
        .icon-btn:hover {
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <button class="btn btn-primary mb-4" onclick="back()">Back</button>
        <h1>Staff Management</h1>

        <?php
            include("connection.php");

            // Handle delete request by setting status=0
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_staff'])) {
                $s_id = $_POST['s_id'];
                $query = "UPDATE `staff_tab` SET `status` = 0 WHERE `staff_code` = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $s_id);

                if ($stmt->execute()) {
                    echo "<script>alert('Staff status updated to inactive successfully');</script>";
                } else {
                    echo "<script>alert('Error updating record: " . $stmt->error . "');</script>";
                }

                $stmt->close();
            }

            // Handle update request for staff details
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_staff'])) {
                $staff_code = $_POST['staff_code'];
                $staff_name = $_POST['staff_name'];
                $email = $_POST['email']; // New email field
                $query = "UPDATE `staff_tab` SET `staff_name` = ?, `email` = ? WHERE `staff_code` = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sss", $staff_name, $email, $staff_code);

                if ($stmt->execute()) {
                    echo "<script>alert('Staff updated successfully');</script>";
                } else {
                    echo "<script>alert('Error updating record: " . $stmt->error . "');</script>";
                }

                $stmt->close();
            }

            // Fetch and display active staff records
            $query = "SELECT * FROM `staff_tab` WHERE status=1";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0) {
                echo "<div class='table-responsive'>
                    <table class='table table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th>Staff ID</th>
                                <th>Staff Name</th>
                                <th>Email</th> <!-- New email column -->
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>";
                while ($row = mysqli_fetch_array($res)) {
                    $s_id = addslashes($row['staff_code']);
                    echo "<tr>
                        <td>{$row['staff_code']}</td>
                        <td>{$row['staff_name']}</td>
                        <td>{$row['email']}</td> <!-- Display email -->
                        <td>
                            <i class='fas fa-edit icon-btn' onclick=\"edit('{$row['staff_code']}', '{$row['staff_name']}', '{$row['email']}')\"></i>
                        </td>
                        <td>
                            <i class='fas fa-trash-alt icon-btn' onclick=\"del('{$s_id}')\"></i>
                        </td>
                    </tr>";
                }
                echo "</tbody></table></div>";
            } else {
                echo "<div class='alert alert-warning text-center'>No records found</div>";
            }
        ?>
    </div>

    <!-- The Modal for Editing -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Update Staff</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateForm" method="POST">
                        <div class="form-group">
                            <label for="staff_code">Staff ID</label>
                            <input type="text" class="form-control" id="staff_code" name="staff_code" readonly>
                        </div>
                        <div class="form-group">
                            <label for="staff_name">Staff Name</label>
                            <input type="text" class="form-control" id="staff_name" name="staff_name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required> <!-- New email field -->
                        </div>
                        <button type="submit" name="update_staff" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function back() {
            window.location.href = 'admin_dashboard.php';
        }

        function edit(staff_code, staff_name, email) {
            $('#staff_code').val(staff_code);
            $('#staff_name').val(staff_name);
            $('#email').val(email); // Populate email field
            $('#editModal').modal('show');
        }

        function del(staff_code) {
            if (confirm("Are you sure you want to mark this staff as inactive?")) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '';
                
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 's_id';
                input.value = staff_code;
                
                const deleteInput = document.createElement('input');
                deleteInput.type = 'hidden';
                deleteInput.name = 'delete_staff';
                
                form.appendChild(input);
                form.appendChild(deleteInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>
