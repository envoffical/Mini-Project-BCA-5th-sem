<?php
include("connection.php");

if (isset($_POST['current_pass']) && isset($_POST['staff_id'])) {
    $current_pass = $_POST['current_pass'];
    $staff_id = $_POST['staff_id'];

    // Fetch the stored password from the database
    $query = "SELECT password FROM `login_tab` WHERE staff_code = '$staff_id'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    // Check if the password exists and matches
    if ($data && password_verify($current_pass, $data['password'])) {
        echo "valid";
    } else {
        echo "invalid";
    }
}
?>
