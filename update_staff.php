<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = $_POST['staff_'];
    $name = $_POST['staff_name'];
    //$s_name = $_POST['s_name'];
    //$semester = $_POST['semester'];

    $query = "UPDATE staff_tab SET staff_name='$name' WHERE staff_code='$staff_id'";
    if (mysqli_query($conn, $query)) {
        echo "Success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
