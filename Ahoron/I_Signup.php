<?php
session_start();
include('connection.php');
$success_message = "";
$error_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fn = $_POST['fn'];  
    $ln = $_POST['ln']; 
    $un = $_POST['un']; 
    $gn = $_POST['g'];
    $phn = $_POST['phn']; 
    $unina = $_POST['unina'];  
    $dept = $_POST['dept']; 
    $pw = $_POST['p']; 

    $target_file = basename($_FILES["pic"]["name"]);
    $filename = $un.".".strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $tempname = $_FILES["pic"]["tmp_name"]; 
    $folder1 = "i_image/".$filename;   

    if (move_uploaded_file($tempname, $folder1)) {
        $msg = "Image uploaded successfully";
    } else {
        $msg = "Failed to upload image";
    }

    $target_file = basename($_FILES["cv"]["name"]);
    $filename = $un.".".strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $tempname = $_FILES["cv"]["tmp_name"];  
    $folder2 = "I_CV/".$filename;   

    if (move_uploaded_file($tempname, $folder2)) {
        $msg = "CV uploaded successfully";
    } else {
        $msg = "Failed to upload CV";
    }

    // Start transaction
    mysqli_begin_transaction($con);

    try {
        // Check if the username is unique
        $sql_check_username = "SELECT * FROM Instructor WHERE username='$un'";
        $result_check_username = mysqli_query($con, $sql_check_username);

        if (mysqli_num_rows($result_check_username) > 0) {
            throw new Exception("Username already exists. Please choose a unique username.");
        }

        // Check if the phone number is unique
        if (!empty($phn)) {
            $sql_check_phone = "SELECT * FROM Instructor WHERE Phone_number='$phn'";
            $result_check_phone = mysqli_query($con, $sql_check_phone);

            if (mysqli_num_rows($result_check_phone) > 0) {
                throw new Exception("Phone number already exists. Please choose a unique phone number.");
            }
        }

        $sql = "INSERT INTO Instructor_req (First_name, Last_name, username, Gender, Phone_number, University_name, Department, Photo, CV, Password) 
                VALUES('$fn', '$ln', '$un','$gn','$phn','$unina', '$dept', '$folder1','$folder2','$pw')";

        $result = mysqli_query($con, $sql);
        if (!$result) {
            throw new Exception("Error occurred: " . mysqli_error($con));
        } else {
            $success_message = "Your CV is submitted. Please wait for admin's approval! After Admin's approvation you can login with your username and password!!! ";
        }

        // Commit the transaction
        mysqli_commit($con);

    } catch (Exception $e) {
        // Rollback transaction if any error occurs
        mysqli_rollback($con);
        $error_message = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Registration</title>
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
        <h2>Instructor Signup</h2>
        <?php if (!empty($success_message)): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <label for="fn">Enter your first Name</label>
            <input type="text" id="fn" name="fn" required>
            
            <label for="ln">Enter your last Name</label>
            <input type="text" id="ln" name="ln" required>
            
            <label for="un">Enter your user Name</label>
            <input type="text" id="un" name="un" placeholder="should be unique! can't change later!" required>
            
            <label>Select your Gender</label>
            <label>
                <input type="radio" name="g" value="Male"> Male
            </label>
            <label>
                <input type="radio" name="g" value="Female"> Female
            </label>
            
            <label for="phn">Enter your phone number</label>
            <input type="text" id="phn" name="phn" required>
            
            <label for="unina">Enter your University name</label>
            <input type="text" id="unina" name="unina" required>
            
            <label for="dept">Enter your Department</label>
            <input type="text" id="dept" name="dept" required>
            
            <label for="pic">Select your Photo</label>
            <input type="file" id="pic" name="pic" required>
            
            <label for="cv">Select your C.V.</label>
            <input type="file" id="cv" name="cv" required>
            
            <label for="p">Enter your Password</label>
            <input type="password" id="p" name="p" placeholder="Enter Password" required>
            
            <input type="submit" name="save" value="Register">
        </form>
    </div>
</body>
</html>
