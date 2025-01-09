<!DOCTYPE html>
<head>
    <title>Student</title>
    <body class="main">    
    <h2>Adding Student</h2>
        <style>
            .main{
                margin:20px;
            }
        </style>
        <form name="Add Student" action="" method="POST" onsubmit="return validate();">
            Register number:<input type="text" name="reg_no"/><br><br>
            Student name:<input type="text" name="stud_name"/><br><br>
            Batch:<select name="batch">
                <option value=""> </option>
                <option value="2022_25">2022-25</option>
                <option value="2023-26">2023-26</option>
                <option value="2024-28">2024-28</option>
</select><br><br>
            Semester:<select name="sem">
                <option value=""> </option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
</select><br><br>
           <input type="Submit" name="submit" value="Add Student" onclick="validate()"/>
            <input type="button" value="Back" onclick="back()"/>
        <script>
            function validate()
            {
                var r_no=document.forms["Add Student"]["reg_no"];
                var s_name=document.forms["Add Student"]["stud_name"];
                var batch=document.forms["Add Student"]["batch"];
                var sem=document.forms["Add Student"]["sem"];
                if((r_no.value=="")||(s_name.value=="")||(batch.value=="")||(sem.value==""))
            {
                alert("Fill all required fields");
                return false;
            }
            return true;
            }
            function back()
            {
                window.location.href="admin_dashboard.php";
            } 
        </script>
        </form>
    </body>
    <?php
        if(isset($_POST["submit"]))
        {
            include("connection.php");
            $reg_no = $_POST['reg_no'];
            $s_name = $_POST['stud_name'];
            $semester = $_POST['sem'];
            $status = 1;
            $batch=$_POST['batch'];

            $query="SELECT COUNT(*) as count FROM `student_tab` WHERE reg_no ='$reg_no'";
            $res1=mysqli_query($conn,$query);
            $row1 = mysqli_fetch_assoc($res1);
            $subject_count = $row1['count'];
            if($subject_count>0) {
            echo '<script type="text/JavaScript">  
            alert("Student already added"); 
            </script>';
            }
            else
            {
            $query1="INSERT INTO `student_tab` (reg_no,name,batch,semester,status) VALUES ('$reg_no','$s_name','$batch','$semester','$status')";
            $res=mysqli_query($conn,$query1);
            // Execute the statement
            if ($res) {
                echo '<script type="text/JavaScript">  
     alert("New student added successfully"); 
     </script>';
            }
            else {
                echo "Error: " . $stmt->error;
            }
            }
            // Close statement and connection
        }
    ?>
</head>
</html>