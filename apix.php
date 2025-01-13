<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Query Interface</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .form-control, .btn {
            margin: 10px 0;
        }
        .output-box {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .output-title {
            font-size: 20px;
            font-weight: bold;
        }
        .output-text {
            font-size: 16px;
            color: #333;
        }
        .btn-clear {
            background-color: #dc3545;
            color: white;
        }
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
        }
    </style>
</head>
<body>

    <!-- Back Button -->
    <a href="faculty_dashboard.php" class="btn btn-secondary back-button">Back</a>

    <div class="container">
        <h1 class="text-center">Student Result AI Query</h1>
        <form method="POST" id="queryForm">
            <div class="mb-3">
                <label for="userQuery" class="form-label">Enter your query:</label>
                <input type="text" class="form-control" id="userQuery" name="userQuery" placeholder="Ask something like 'What is the class average?'" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-clear" onclick="clearForm()">Clear</button>
        </form>

        <div class="output-box mt-5">
            <div class="output-title">Response:</div>
            <div class="output-text" id="res">
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    include("connection.php");

                    $msg = $_POST['userQuery'];

                    // Your existing generateQuery function here...
                    function generateQuery($msg) {
                        $apiKey = ' '; //Enter your api key from google studio 
                        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=" . $apiKey;
                        // Add your table structure description here...
                        //$tableStructure = "The result_management database consists of several tables, each with its own structure and relationships.

    /*1. *batch_tab*: This table stores information about academic batches. It contains two fields: batch (a varchar with a length of 10, serving as the primary key) and semester (a varchar with a length of 10). It holds data such as batch names and their corresponding semesters.
    2. *exam_tab*: This table records exam details. It has fields like exam_id (an auto-incremented integer as the primary key), exam_name (a varchar with a length of 20), exam_date (a date field), batch (a varchar with a length of 10 referencing the batch_tab), subject_code (a varchar with a length of 10), total_mark (an integer), and publish (an integer representing the publication status). This table keeps track of each exam and its associated batch, subject, and total marks.
    3. *login_tab*: This table manages login credentials. It includes login_id (an auto-incremented integer as the primary key), student_id (a varchar of length 30), staff_id (a varchar of length 30), password (a varchar of length 10), role (a varchar of length 10 representing roles such as 'Student' or 'Faculty'), and status (an integer representing the login status). It has foreign keys to both student_tab and staff_tab.
    4. *marks_tab*: This table stores marks of students for each exam. It consists of mark_id (an auto-incremented integer as the primary key), subject_code (a varchar of length 10), exam_id (an integer), student_id (a varchar of length 10), and mark_obtained (a varchar of length 11). It maintains the relationship between students, subjects, and their marks.
    5. *staff_tab*: This table holds information about the faculty members. It includes fields such as staff_code (a varchar of length 30 serving as the primary key), staff_name (a varchar of length 30), status (an integer representing the active status), and email (a varchar of length 255). It also enforces unique constraints on the email field.
    6. *student_tab*: This table stores student data. It consists of student_id (a varchar of length 30 serving as the primary key), student_name (a varchar of length 30), batch (a varchar of length 7 referencing batch_tab), status (an integer), and email (a varchar of length 255 with a unique constraint).";*/
   
    $tableStructure = "The result_management database consists of several tables, each with its own structure and relationships.

    1. batch_tab: This table stores information about academic batches. It contains two fields: batch (a varchar with a length of 10, serving as the primary key) and semester (a varchar with a length of 10). It holds data such as batch names and their corresponding semesters.
    2. exam_tab: This table records exam details. It has fields like exam_id (an auto-incremented integer as the primary key), exam_name (a varchar with a length of 20), exam_date (a date field), batch (a varchar with a length of 10 referencing the batch_tab), subject_code (a varchar with a length of 10), total_mark (an integer), and publish (an integer representing the publication status). This table keeps track of each exam and its associated batch, subject, and total marks.
    3. subject_tab: This table holds subjct details. It has fields like subject_code(primary key), subject_name(varchar), semester(integer type), staff_id(varchar, foreign key referencing staff_code of staff_tab), status (integer type). It maintains relationship between subjects nad staff.
    4. marks_tab: This table stores marks of students for each exam. It consists of mark_id (an auto-incremented integer as the primary key), subject_code (a varchar of length 10), exam_id (an integer), student_id (a varchar of length 10), and mark_obtained (a varchar of length 11). It maintains the relationship between students, subjects, and their marks.
    5. student_tab: This table stores student data. It consists of student_id (a varchar of length 30 serving as the primary key), student_name (a varchar of length 30), batch (a varchar of length 7 referencing batch_tab), status (an integer), and email (a varchar of length 255 with a unique constraint).";
   
   
   
   
   
   
   
   
    $prompt = "I am giving the table structure.".$tableStructure." give me just the query to according to".$msg."Remove all extra words like sql and all extra characters in it";
                        
                        //$prompt = "I am giving the table structure: " . $tableStructure . " Give me just the query for: " . $msg;
                        $data = array(
                            "contents" => array(
                                array(
                                    "parts" => array(
                                        array(
                                            "text" => $prompt
                                        )
                                    )
                                )
                            )
                        );
                        $ch = curl_init($apiUrl);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                        $response = curl_exec($ch);
                        curl_close($ch);
                        $result = json_decode($response, true);
                        return $result['candidates'][0]['content']['parts'][0]['text'] ?? "Error processing the query.";
                    }

                    $query= generateQuery($msg);
                    $query = preg_replace('/\bsql\b/i', '', $query);
                    $query = str_replace("`", "", $query);
                    //echo $query;
                    //echo $query;
                    

                    // Check if the AI returned a valid query, if not, skip execution
                    if (stripos($query, "Error") === false) { // Ensure the query does not contain "Error"
                        $query = str_replace("`", "", $query);  // Clean up the query

                        // Execute the query in MySQL
                        $res = mysqli_query($conn, $query);
                        if ($res) {
                            $phpres = [];
                            if (mysqli_num_rows($res) > 0) {
                                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                    $phpres[] = $row;
                                }
                            } else {
                                $phpres = "No records found";
                            }
                        } else {
                            echo "Error executing the query: " . mysqli_error($conn);
                        }
                    } else {
                        // Handle the case where the AI returned an error
                        echo "AI failed to generate a valid query: " . $query;
                    }

                    // Function to generate result in chatbot-like format
                    function generateResult($phpres, $msg) {
                        $apiKey = '  ';//Enter your api key from google studio 
                        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=" . $apiKey;
                        $phpres_str = is_array($phpres) ? "Here are the details:\n" : $phpres;
                        if (is_array($phpres)) {
                            foreach ($phpres as $row) {
                                foreach ($row as $key => $value) {
                                    $phpres_str .= ucfirst($key) . ": " . $value . "\n";
                                }
                            }
                        }
                        //$prompt = "The user asked: " . $msg . ". Here is the answer: " . $phpres_str."give the response as html table without html and body tag and use table tag if there are multiple entries so as to insert it in a html page.";
                         $prompt = "The user asked: " . $msg . ". Here is the answer: " . $phpres_str."give the response as html table without html and body tag and use table tag with table borders if there are multiple entries so as to insert it in a html page.";
                        $data = array(
                            "contents" => array(
                                array(
                                    "parts" => array(
                                        array(
                                            "text" => $prompt
                                        )
                                    )
                                )
                            )
                        );
                        $ch = curl_init($apiUrl);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                        $response = curl_exec($ch);
                        curl_close($ch);
                        $result = json_decode($response, true);
                        return $result['candidates'][0]['content']['parts'][0]['text'] ?? "Error generating the result.";
                    }

                    // Output the formatted result if query executed successfully
                    if (!empty($phpres)) {
                        echo generateResult($phpres, $msg);
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        function clearForm() {
            document.getElementById("queryForm").reset();
            document.querySelector(".output-text").innerHTML = "";
        }
    </script>
</body>
</html>
