<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body><br><br><br>
    <?php
        include("connection.php");
        $s_id = $_SESSION['username'];
        $query="SELECT staff_name FROM `staff_tab` WHERE staff_code='$s_id'";
        $res=mysqli_query($conn,$query);
        if(mysqli_num_rows($res)>0)
        {
            $row=mysqli_fetch_array($res);
            $st_name=$row['staff_name'];
        }
        echo "Welcome ",$st_name;
        $query="SELECT subject_name,semester from `subject_tab` WHERE staff_id='$s_id' and status='1'";
        $res=mysqli_query($conn,$query);
        echo '<br><br>';
        echo "Subjects handled by you";
        echo '<br>';
        if(mysqli_num_rows($res)>0)
        {
            echo '<table border="1">';
            echo '<th>Subject name</th>';
            echo '<th>Semester</th>';
            while($row=mysqli_fetch_array($res))
            {
                echo '<tr>';
                echo '<td>';echo $row['subject_name'];echo '</td>';
                echo '<td>';echo $row['semester'];echo '</td>';
                echo '<td>';echo '<input type="Submit" name="Submit" value="View Students">';echo '</td>';
                echo '</tr>';
            }
            echo '</table>';
        }
    ?>
    <center><input type="Submit" name="submit" value="Change username or password" onclick="update()"/><br><br>
    <input type="button" name="submit" value="Home" onclick="home()"/><br><br>
    <input type="Submit" name="submit" value="Upload marks" onclick="marks()"/><br><br>
</center>
<script>
    function update()
    {
        window.location.href="login_update.php";
    }
    function home()
    {
        window.location.href="home.php";
    }
    function marks(){
        window.location.href="marks_upload.php";
    }
</script>
</body>
</html>