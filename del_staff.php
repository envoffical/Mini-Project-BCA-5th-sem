<?php
include("connection.php");
if (isset($_POST['s_id'])) {
    $st_id = mysqli_real_escape_string($conn, $_POST['s_id']);
    $query = "UPDATE `staff_tab` SET status=0 WHERE staff_id='$st_id'";
    $res = mysqli_query($conn, $query);

    if ($res) {
        echo "Operation Successful";
    } else {
        echo "Operation failed: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request";
}
?>