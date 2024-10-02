<?php
session_start();
include('connection.php');

// Initialize variables
$success_message = "";
$error_message = "";
$student_id = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST["fn"];
    $last_name = $_POST["ln"];
    $username = $_POST["un"];
    $gender = $_POST["gender"];
    $institute_type = $_POST["institute_type"];
    $institute_name = $_POST["insnm"];
    $class = $_POST["class"];
    $phone_number = $_POST["number"];
    $password = $_POST["pw"];

    // Start transaction
    mysqli_begin_transaction($con);

    try {
        // Check if the username is unique
        $sql_check_username = "SELECT * FROM Student WHERE username='$username'";
        $result_check_username = mysqli_query($con, $sql_check_username);

        if (mysqli_num_rows($result_check_username) > 0) {
            throw new Exception("Username already exists. Please choose a unique username.");
        }

        // Check if the phone number is unique
        if (!empty($phone_number)) {
            $sql_check_phone = "SELECT * FROM Student WHERE Phone_number='$phone_number'";
            $result_check_phone = mysqli_query($con, $sql_check_phone);

            if (mysqli_num_rows($result_check_phone) > 0) {
                throw new Exception("Phone number already exists. Please choose a unique phone number.");
            }
        }

        // Prepare SQL statement
        $sql = "INSERT INTO Student (First_name, Last_name, username, Gender, Institute_type, Institute_name, Class, Phone_number, Password) VALUES ('$first_name', '$last_name', '$username', '$gender', '$institute_type', '$institute_name', '$class', " . ($phone_number ? "'$phone_number'" : "NULL") . ", '$password')";
        $result = mysqli_query($con, $sql);

        // Execute SQL statement
        if (!$result) {
            throw new Exception("Error occurred: " . mysqli_error($con));
        } else {
            // Get the last inserted ID
            $student_id = mysqli_insert_id($con);

            // Commit transaction
            mysqli_commit($con);

            $success_message = "Signup successful! Your Student ID is: $student_id Remember your ID for further use!";
        }
    } catch (Exception $e) {
        // Rollback transaction if any error occurs
        mysqli_rollback($con);
        $error_message = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup Page</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f0f0f0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            height: 100vh;
            margin: 0;
        }
        .navbar {
            width: 100%;
            background-color: #3498db;
            padding: 5px;
            box-sizing: border-box;
            position: relative;
            display: flex;
            align-items: center;
        }
        .navbar a {
            color: #fff;
            font-size: 20px;
            text-decoration: none;
            padding: 10px;
        }
        .signup-container {
            width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
        }
        .signup-container h2 {
            text-align: center;
        }
        .signup-container form {
            display: flex;
            flex-direction: column;
        }
        .signup-container label {
            display: block;
            margin-bottom: 10px;
        }
        .signup-container input[type="text"], .signup-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 3px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .signup-container button {
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .signup-container button:hover {
            background-color: #2980b9;
        }
        .success-message, .error-message {
            text-align: center;
            margin-bottom: 20px;
        }
        .success-message {
            color: green;
        }
        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <a href="Login1.php">Login</a>
    </div>

    <div class="signup-container">
        <h2>Student Signup</h2>
        <?php if ($success_message): ?>
            <p class="success-message"><?php echo $success_message; ?></p>
            <a href="S_login.php">Go to Login</a>
        <?php else: ?>
            <?php if ($error_message): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form action="" method="post">
                <label for="first_name">First Name:</label>
                <input type="text" id="fname" name="fn" required>
                
                <label for="last_name">Last Name:</label>
                <input type="text" id="lname" name="ln" required>
                
                <label for="username">User Name:</label>
                <input type="text" id="uname" name="un" required placeholder="Should be Unique, can't change!!">
                
                <b>Select your Gender</b>  
                Male <input type="radio" name="gender" value="Male" required>  
                Female <input type="radio" name="gender" value="Female" required>  
                <br><br>
                
                <b>Select your Institute type</b>  
                School<input type="radio" name="institute_type" value="School/College" required>
                College <input type="radio" name="institute_type" value="School/College" required>  				
                University <input type="radio" name="institute_type" value="University" required>  
                <br><br>
                
                <label for="insname">Institute Name:</label>
                <input type="text" id="insname" name="insnm" required>
                
                <label for="class">Class:</label>
                <input type="text" id="year_sem" name="class" required placeholder="Enter class (8/9/10/11/12)/Year,Semester">
                
                <label for="phone_numbers">Phone Numbers:</label>
                <input type="text" id="phone_numbers" name="number" placeholder="Enter phone numbers">
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="pw" required>
                
                <button type="submit">Signup</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
