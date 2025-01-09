<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><center>Upload csv file</center></h1><center>
    <form method="POST" enctype='multipart/form-data'>
        <p>Please select csv file only. <br>Avoid column headers while entering data</p>
        <input type="file" name="staff_file"/>
        <input type="Submit" name="upload" value="Upload"/>
    </form></center>
    <?php if (isset($msg)) { echo $msg; } ?>
</body>
<?php include("staff_add.php");
    include("view_staff.php");
    include("connection.php");
    if(isset($_POST['upload']))
    {
        if($_FILES['staff_file']['name'])
        {
            $filename=explode(".",$_FILES['staff_file']['name']);
            if(end($filename)=="csv")
            {
                $handle=fopen($_FILES['staff_file']['tmp_name'],"r");
                while($data=fgetcsv($handle))
                {
                    $st_id=mysqli_real_escape_string($conn,$data[0]);
                    $st_name=mysqli_real_escape_string($conn,$data[1]);
                    //$sub_name=mysqli_real_escape_string($conn,$data[2]);
                    //$sub_name = !empty($data[2]) ? "'" . $mysqli->real_escape_string($data[2]) . "'" : "NULL";
                    //$sem = !empty($data[3]) ? "'" . $mysqli->real_escape_string($data[3]) . "'" : "NULL";
                    //$sem=mysqli_real_escape_string($conn,$data[3]);
                    //$sub_name = isset($_POST['Subject_name']) ? $_POST['Subject_name'] : null;
                    //$sem = isset($_POST['Semester']) ? $_POST['Semester'] : null;
                    //$l_id=mysqli_real_escape_string($conn,$data[4]);
                    //$uname=mysqli_real_escape_string($conn,$data[5]);
                    //$pass=mysqli_real_escape_string($conn,$data[6]);
                    $query="INSERT into `staff_tab` (staff_code,staff_name,status) values('$st_id','$st_name','1')";
                    $query1="INSERT into `login_tab` (staff_id,password,role,status) values('$st_id','$st_id','Faculty','1')";
                    mysqli_query($conn,$query);
                    mysqli_query($conn,$query1);
                }
                fclose($handle);
                header("location:add_staff_csv.php?insertion=1");
                exit();
            }
            else
            {
                $msg='<label>Please select a CSV file</label>';
            }
        }
        else
        {
            $msg='<label>Please select file</label>';
        }
        if(isset($_POST["insertion"]))
        {
            echo '<script type="text/JavaScript">
            alert("File uploaded successfully");
            </script>';
        }
    }
?>
</html>