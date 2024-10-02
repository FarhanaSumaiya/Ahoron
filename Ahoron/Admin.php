<?php
session_start();
include('connection.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: A_login.php");
    exit();
}

// Get the admin's username
$admin_username = $_SESSION['admin_username'];

// Handle logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: A_login.php");
    exit();
}

$students = [];
$instructors = [];
$instructor_requests = [];
$payments = [];
$payment_requests = [];
$notices = [];
$messages = [];

// Fetch student details if 'Enroll Student' is clicked
if (isset($_GET['page']) && $_GET['page'] == 'enroll_student') {
    $sql = "SELECT S_ID, First_name, Last_name, username, Gender, Institute_type, Institute_name, Class, Phone_number,  Registration_date FROM Student";
    $result = mysqli_query($con, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $students[] = $row;
        }
    } else {
        $error_message = "Error fetching student details: " . mysqli_error($con);
    }
}
//delete_student_id
if (isset($_POST['delete_student_id'])) {
    $student_id = $_POST['delete_student_id'];
    $sql = "DELETE FROM Student WHERE S_ID = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $student_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: Admin.php?page=enroll_student");
        exit();
    } else {
        $error_message = "Error deleting student: " . mysqli_error($con);
    }
}
// Fetch instructor list
if (isset($_GET['page']) && $_GET['page'] == 'instructor_list') {
    $sql = "SELECT I_ID,First_name,Last_name,username,Gender,Phone_number ,University_name,Department,Salary, Join_date FROM Instructor";
    $result = mysqli_query($con, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $instructors[] = $row;
        }
    } else {
        $error_message = "Error fetching instructor list: " . mysqli_error($con);
    }
}
// Fetch instructor requests
if (isset($_GET['page']) && $_GET['page'] == 'InstructorRequests_list') {
    $sql = "SELECT * FROM Instructor_req";
    $result = mysqli_query($con, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $instructor_requests[] = $row;
        }
    } else {
        $error_message = "Error fetching instructor requests: " . mysqli_error($con);
    }
}
//delete_instructor
if (isset($_POST['delete_instructor_id'])) {
    $instructor_id = $_POST['delete_instructor_id'];
    $sql = "DELETE FROM Instructor WHERE I_Id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $instructor_id );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: Admin.php?page=InstructorRequests_list");
        exit();
    } else {
        $error_message = "Error deleting instructor: " . mysqli_error($con);
    }
}
// Handle instructor request approval
if (isset($_POST['approve_instructor_id'])) {
    $request_id = $_POST['approve_instructor_id'];

    // Get the instructor request details
    $sql = "SELECT * FROM instructor_req WHERE ID = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $request_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $instructor_request = mysqli_fetch_assoc($result);

    if ($instructor_request) {
        // Insert the instructor information into the Instructor table
        $sql = "INSERT INTO Instructor (First_name, Last_name, username, Gender, Phone_number, University_name, Department, Photo, CV, Salary, Password, Submitted_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 10000, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'sssssssssss', 
            $instructor_request['First_name'], 
            $instructor_request['Last_name'], 
            $instructor_request['username'], 
            $instructor_request['Gender'], 
            $instructor_request['Phone_number'], 
            $instructor_request['University_name'], 
            $instructor_request['Department'], 
            $instructor_request['Photo'], 
            $instructor_request['CV'], 
            $instructor_request['Password'], 
            $instructor_request['Submitted_date']
        );

        if (mysqli_stmt_execute($stmt)) {
            // Delete the instructor request from the instructor_req table
            $sql = "DELETE FROM instructor_req WHERE ID = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $request_id);
            mysqli_stmt_execute($stmt);

            header("Location: Admin.php?page=instructor_list");
            exit();
        } else {
            $error_message = "Error approving instructor request: " . mysqli_error($con);
        }
    } else {
        $error_message = "Instructor request not found.";
    }
}
// Handle instructor request deletion
if (isset($_POST['delete_instructor_req_id'])) {
    $request_id = $_POST['delete_instructor_req_id'];
    $sql = "DELETE FROM instructor_req WHERE ID = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $request_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: admin.php?page=InstructorRequests_list");
        exit();
    } else {
        $error_message = "Error deleting instructor request: " . mysqli_error($con);
    }
}

// Fetch payment requests
if (isset($_GET['page']) && $_GET['page'] == 'view_payment_requests') {
    $sql = "SELECT * FROM Payment_req";
    $result = mysqli_query($con, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $payment_requests[] = $row;
        }
    } else {
        $error_message = "Error fetching payment requests: " . mysqli_error($con);
    }
}

// Fetch payment list
if (isset($_GET['page']) && $_GET['page'] == 'payment_list') {
    $sql = "SELECT * FROM Payment";
    $result = mysqli_query($con, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $payments[] = $row;
        }
    } else {
        $error_message = "Error fetching payment list: " . mysqli_error($con);
    }
}
// Handle payment request approval
if (isset($_POST['approve_request_id'])) {
    $request_id = $_POST['approve_request_id'];

    // Get the payment request details
    $sql = "SELECT * FROM Payment_req WHERE ID = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $request_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $payment_request = mysqli_fetch_assoc($result);

    if ($payment_request) {
        // Insert the payment information into the Payment table
        $sql = "INSERT INTO Payment (ID,Amount, Transaction_ID, Payment_date) VALUES (?, ?, ?,?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'isis', $payment_request['ID'], $payment_request['Amount'], $payment_request['Transaction_ID'], $payment_request['Payment_date']);
        
        if (mysqli_stmt_execute($stmt)) {
            // Delete the payment request from the Payment_req table
            $sql = "DELETE FROM Payment_req WHERE ID = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $request_id);
            mysqli_stmt_execute($stmt);

            header("Location: Admin.php?page=view_payment_requests");
            exit();
        } else {
            $error_message = "Error approving payment request: " . mysqli_error($con);
        }
    } else {
        $error_message = "Payment request not found.";
    }
}

// Handle payment request deletion
if (isset($_POST['delete_request_id'])) {
    $request_id = $_POST['delete_request_id'];
    $sql = "DELETE FROM Payment_req WHERE ID = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $request_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: Admin.php?page=view_payment_requests");
        exit();
    } else {
        $error_message = "Error deleting payment request: " . mysqli_error($con);
    }
}

// Fetch notices
if (isset($_GET['page']) && $_GET['page'] == 'view_notice') {
    $sql = "SELECT * FROM Notice";
    $result = mysqli_query($con, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $notices[] = $row;
        }
    } else {
        $error_message = "Error fetching notices: " . mysqli_error($con);
    }
}

// Handle adding notice
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_notice'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $sql = "INSERT INTO Notice (title, description) VALUES ('$title', '$description')";
    $result = mysqli_query($con, $sql);
    
    if (!$result) {
        $notice_error = "Error occurred: " . mysqli_error($con);
    } else {
        $notice_success = "Notice added successfully!";
    }
}

//delete_notice
if (isset($_POST['delete_notice_id'])) {
    $notice_id = $_POST['delete_notice_id'];
    $sql = "DELETE FROM Notice WHERE notice_ID = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $notice_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: Admin.php?page=view_notice");
        exit();
    } else {
        $error_message = "Error deleting notice: " . mysqli_error($con);
    }
}

// Handle sending s_message
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['s_submit_message'])) {
    $id = $_POST['id'];
    $message = $_POST['message'];

    $sql = "INSERT INTO AS_message (ID, Message) VALUES ('$id', '$message')";
    $result = mysqli_query($con, $sql);
    
    if (!$result) {
        $message_error = "Error occurred: " . mysqli_error($con);
    } else {
        $message_success = "Message sent successfully!";
    }
}

// Fetch messages if 'view all s_Messages' is clicked
if (isset($_GET['page']) && $_GET['page'] == 's_view_messages') {
    $sql = "SELECT * FROM AS_message";
    $result = mysqli_query($con, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $messages[] = $row;
        }
    } else {
        $error_message = "Error fetching messages: " . mysqli_error($con);
    }
}
// Fetch messages if 'read s_Messages' is clicked
if (isset($_GET['page']) && $_GET['page'] == 's_read_messages') {
    $sql = "SELECT * FROM S_message";
    $result = mysqli_query($con, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $messages[] = $row;
        }
    } else {
        $error_message = "Error fetching messages: " . mysqli_error($con);
    }
}

// Handle sending I_message
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['I_submit_message'])) {
    $id = $_POST['id'];
    $message = $_POST['message'];

    $sql = "INSERT INTO AI_message (ID, Message) VALUES ('$id', '$message')";
    $result = mysqli_query($con, $sql);
    
    if (!$result) {
        $message_error = "Error occurred: " . mysqli_error($con);
    } else {
        $message_success = "Message sent successfully!";
    }
}

// Fetch messages if 'view all I_Messages' is clicked
if (isset($_GET['page']) && $_GET['page'] == 'I_view_messages') {
    $sql = "SELECT * FROM AI_message";
    $result = mysqli_query($con, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $messages[] = $row;
        }
    } else {
        $error_message = "Error fetching messages: " . mysqli_error($con);
    }
}
// Fetch messages if 'read I_Messages' is clicked
if (isset($_GET['page']) && $_GET['page'] == 'I_read_messages') {
    $sql = "SELECT * FROM I_message";
    $result = mysqli_query($con, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $messages[] = $row;
        }
    } else {
        $error_message = "Error fetching messages: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        header {
            background-color: #3498db;
            padding: 20px 0;
            text-align: center;
            color: #fff;
            position: relative;
        }
        .admin-info {
            position: absolute;
            right: 20px;
            top: 20px;
            color: #fff;
            font-weight: bold;
        }
        nav {
            background-color: #2980b9;
            padding: 10px 0;
            text-align: center;
        }
        nav a {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            margin: 0 10px;
            border-radius: 5px;
            background-color: #3498db;
            transition: background-color 0.3s ease;
        }
        nav a:hover {
            background-color: #1e6091;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .option {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .option h2 {
            color: #333;
        }
        .logout-button {
            background-color: #e74c3c;
            padding: 10px 20px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-left: 10px;
            transition: background-color 0.3s ease;
        }
        .logout-button:hover {
            background-color: #c0392b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            text-align: left;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #3498db;
            color: white;
        }
		.delete-button {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .delete-button:hover {
            background-color: #c0392b;
        }
		.approve-button {
            background-color: #12c119;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .approve-button:hover {
            background-color: #008000;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
        <div class="admin-info">
            Welcome <?php echo htmlspecialchars($admin_username); ?> 
            <a href="A_login.php" class="logout-button">Logout</a>
        </div>
    </header>
    <div class="container">
        <div class="option">
            <a href="?page=enroll_student">
                <h2>Enroll Student</h2>
            </a>
            <p>Manage student enrollment.</p>
        </div>
		<div class="option">
		 <a href="?page=instructor_options">
            <h2>Instructor List</h2></a>
            <p>View and manage instructors.</p>
        </div>
        <div class="option">
            <a href="?page=payment_options">
                <h2>Payment</h2>
            </a>
            <p>Handle payment details.</p>
        </div>
        <div class="option">
		 <a href="?page=notice_options">
            <h2>Notice</h2></a>
            <p>Post and view notices.</p>
        </div>
        <div class="option">
		 <a href="?page=s_message_options">
            <h2>Student Messages</h2></a>
            <p>View messages from Student.</p>
        </div>
		<div class="option">
		 <a href="?page=I_message_options">
            <h2>Instructor Messages</h2></a>
            <p>View messages from Instructor.</p>
        </div>
		<div class="option">
		 <a href="A_club.php">
            <h2>Clubs</h2></a>
            <p>Manage different University's club</p>
        </div>
    </div>
    <div class="container">
        <?php if (isset($_GET['page']) && $_GET['page'] == 'enroll_student'): ?>
            <div class="option">
                <h2>Student Enrollment</h2>
                <?php if (isset($error_message)): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php else: ?>
                    <table>
                        <tr>
                            <th>Student ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                            <th>Gender</th>
                            <th>Institute Type</th>
                            <th>Institute Name</th>
                            <th>Class</th>
                            <th>Phone Number</th>
                            <th>Register At</th>
							<th>Delete</th>
                        </tr>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['S_ID']); ?></td>
                                <td><?php echo htmlspecialchars($student['First_name']); ?></td>
                                <td><?php echo htmlspecialchars($student['Last_name']); ?></td>
                                <td><?php echo htmlspecialchars($student['username']); ?></td>
                                <td><?php echo htmlspecialchars($student['Gender']); ?></td>
                                <td><?php echo htmlspecialchars($student['Institute_type']); ?></td>
                                <td><?php echo htmlspecialchars($student['Institute_name']); ?></td>
                                <td><?php echo htmlspecialchars($student['Class']); ?></td>
                                <td><?php echo htmlspecialchars($student['Phone_number']); ?></td>
                                <td><?php echo htmlspecialchars($student['Registration_date']); ?></td>
								<td><form method="post" action="">
                                        <input type="hidden" name="delete_student_id" value="<?php echo $student['S_ID']; ?>">
                                        <button type="submit" class="delete-button">Delete</button>
                                    </form></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
       <!-- message -->
         <?php elseif (isset($_GET['page']) && $_GET['page'] == 's_message_options'): ?>
            <div class="option">
                <h2>Messages</h2>
                <a href="?page=s_send_message">Send Message</a>
                <a href="?page=s_view_messages">View sent Messages</a>
				 <a href="?page=s_read_messages">Read Message</a>
				
            </div>
        <!-- Send Message -->
        <?php elseif (isset($_GET['page']) && $_GET['page'] == 's_send_message'): ?>
            <div class="option">
                <h2>Send Message</h2>
                <?php if (isset($message_error)): ?>
                    <p style="color: red;"><?php echo $message_error; ?></p>
                <?php elseif (isset($message_success)): ?>
                    <p style="color: green;"><?php echo $message_success; ?></p>
                <?php endif; ?>
                <form action="" method="post">
                    <input type="hidden" name="s_submit_message" value="1">
                    <input type="text" name="id" placeholder="Write ID" required>
                    <input type="text" name="message" placeholder="Write Message" required>
                    <input type="submit" value="Submit">
                </form>
            </div>
        <!-- View Messages -->
        <?php elseif (isset($_GET['page']) && $_GET['page'] == 's_view_messages'): ?>
            <div class="option">
                <h2>View Sent Messages</h2>
                <?php if (isset($error_message)): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php else: ?>
                    <table>
                        <tr>
                            <th>Sent to ID</th>
                            <th>Message</th>
                            <th>Send Time</th>
                        </tr>
                        <?php foreach ($messages as $message): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($message['ID']); ?></td>
                                <td><?php echo htmlspecialchars($message['Message']); ?></td>
                                <td><?php echo htmlspecialchars($message['Send_time']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
			<!-- read Messages -->
          <?php elseif (isset($_GET['page']) && $_GET['page'] == 's_read_messages'): ?>
            <div class="option">
                <h2>Read Messages</h2>
                <?php if (isset($error_message)): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php else: ?>
                    <table>
                        <tr>
                            <th>Send By ID</th>
                            <th>Message</th>
                            <th>Receive Time</th>
                        </tr>
                        <?php foreach ($messages as $message): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($message['ID']); ?></td>
                                <td><?php echo htmlspecialchars($message['Message']); ?></td>
                                <td><?php echo htmlspecialchars($message['Send_time']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
			<!-- message -->
         <?php elseif (isset($_GET['page']) && $_GET['page'] == 'I_message_options'): ?>
            <div class="option">
                <h2>Messages</h2>
                <a href="?page=I_send_message">Send Message</a>
                <a href="?page=I_view_messages">View sent Messages</a>
				 <a href="?page=I_read_messages">Read Message</a>
				
            </div>
        <!-- Send Message -->
        <?php elseif (isset($_GET['page']) && $_GET['page'] == 'I_send_message'): ?>
            <div class="option">
                <h2>Send Message</h2>
                <?php if (isset($message_error)): ?>
                    <p style="color: red;"><?php echo $message_error; ?></p>
                <?php elseif (isset($message_success)): ?>
                    <p style="color: green;"><?php echo $message_success; ?></p>
                <?php endif; ?>
                <form action="" method="post">
                    <input type="hidden" name="I_submit_message" value="1">
                    <input type="text" name="id" placeholder="Write ID" required>
                    <input type="text" name="message" placeholder="Write Message" required>
                    <input type="submit" value="Submit">
                </form>
            </div>
        <!-- View Messages -->
        <?php elseif (isset($_GET['page']) && $_GET['page'] == 'I_view_messages'): ?>
            <div class="option">
                <h2>View Sent Messages</h2>
                <?php if (isset($error_message)): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php else: ?>
                    <table>
                        <tr>
                            <th>Sent to ID</th>
                            <th>Message</th>
                            <th>Send Time</th>
                        </tr>
                        <?php foreach ($messages as $message): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($message['ID']); ?></td>
                                <td><?php echo htmlspecialchars($message['Message']); ?></td>
                                <td><?php echo htmlspecialchars($message['Send_time']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
			<!-- read Messages -->
          <?php elseif (isset($_GET['page']) && $_GET['page'] == 'I_read_messages'): ?>
            <div class="option">
                <h2>Read Messages</h2>
                <?php if (isset($error_message)): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php else: ?>
                    <table>
                        <tr>
                            <th>Send By ID</th>
                            <th>Message</th>
                            <th>Receive Time</th>
                        </tr>
                        <?php foreach ($messages as $message): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($message['ID']); ?></td>
                                <td><?php echo htmlspecialchars($message['Message']); ?></td>
                                <td><?php echo htmlspecialchars($message['Send_time']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        <!-- Payment Options -->
        <?php elseif (isset($_GET['page']) && $_GET['page'] == 'payment_options'): ?>
            <div class="option">
                <h2>Payment</h2>
                <a href="?page=view_payment_requests">View Payment Requests</a>
                <a href="?page=payment_list">Payment List</a>
            </div>
        <!-- View Payment Requests -->
        <?php elseif (isset($_GET['page']) && $_GET['page'] == 'view_payment_requests'): ?>
            <div class="option">
                <h2>View Payment Requests</h2>
                <?php if (isset($error_message)): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php else: ?>
                    <table>
                        <tr>
                            <th>Request ID</th>
                            <th>Transaction ID</th>
                            <th>Request Date</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach ($payment_requests as $request): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($request['ID']); ?></td>
                                <td><?php echo htmlspecialchars($request['Transaction_ID']); ?></td>
								<td><?php echo htmlspecialchars($request['Amount']); ?></td>
                                <td><?php echo htmlspecialchars($request['Payment_date']); ?></td>
                                <td>
                                    <form method="POST" style="display:inline-block;">
                                        <input type="hidden" name="approve_request_id" value="<?php echo $request['ID']; ?>">
                                        <button type="submit" class="approve-button">Approve</button>
                                    </form>
                                    <form method="POST" style="display:inline-block;">
                                        <input type="hidden" name="delete_request_id" value="<?php echo $request['ID']; ?>">
                                        <button type="submit" class="delete-button">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        <!-- Payment List -->
        <?php elseif (isset($_GET['page']) && $_GET['page'] == 'payment_list'): ?>
            <div class="option">
                <h2>Payment List</h2>
                <?php if (isset($error_message)): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php else: ?>
                    <table>
                        <tr>
                            <th>Payment ID</th>
                            <th>Student ID</th>
                            <th>Transaction ID</th>
							<th>Amount</th>
							<th>Payment Date</th>
							<th>Approve Date</th>
							
                        </tr>
                        <?php foreach ($payments as $payment): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($payment['Payment_ID']); ?></td>
                                <td><?php echo htmlspecialchars($payment['ID']); ?></td>
                                <td><?php echo htmlspecialchars($payment['Transaction_ID']); ?></td>
							    <td><?php echo htmlspecialchars($payment['Amount']); ?></td>
								<td><?php echo htmlspecialchars($payment['Payment_date']); ?></td>
                                <td><?php echo htmlspecialchars($payment['Approve_date']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
      
        <?php elseif (isset($_GET['page']) && $_GET['page'] == 'instructor_options'): ?>
            <div class="option">
                <h2>Instructor</h2>
                <a href="?page=InstructorRequests_list">View Instructor Requests</a>
                <a href="?page=instructor_list">Instructor List</a>
            </div>
        <!-- Instructor Request List -->
        <?php elseif (isset($_GET['page']) && $_GET['page'] == 'InstructorRequests_list'): ?>
            <div class="option">
                <h2>Instructor Requests</h2>
                <?php if (isset($error_message)): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php else: ?>
                    <table>
                        <tr>
                            <th>Instructor ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                            <th>Gender</th>
                            <th>Phone Number</th>
                            <th>University Name</th>
                            <th>Department</th>
                            <th>Submitted At</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach ($instructor_requests as $instructor): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($instructor['ID']); ?></td>
                                <td><?php echo htmlspecialchars($instructor['First_name']); ?></td>
                                <td><?php echo htmlspecialchars($instructor['Last_name']); ?></td>
                                <td><?php echo htmlspecialchars($instructor['username']); ?></td>
                                <td><?php echo htmlspecialchars($instructor['Gender']); ?></td>
                                <td><?php echo htmlspecialchars($instructor['Phone_number']); ?></td>
                                <td><?php echo htmlspecialchars($instructor['University_name']); ?></td>
                                <td><?php echo htmlspecialchars($instructor['Department']); ?></td>
                                <td><?php echo htmlspecialchars($instructor['Submitted_date']); ?></td>
                                <td>
                                    <form method="POST" style="display:inline-block;">
                                        <input type="hidden" name="approve_instructor_id" value="<?php echo $instructor['ID']; ?>">
                                        <button type="submit" class="approve-button">Approve</button>
                                    </form>
                                    <form method="POST" style="display:inline-block;">
                                        <input type="hidden" name="delete_instructor_req_id" value="<?php echo $instructor['ID']; ?>">
                                        <button type="submit" class="delete-button">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        <!-- Instructor List -->
        <?php elseif (isset($_GET['page']) && $_GET['page'] == 'instructor_list'): ?>
            <div class="option">
                <h2>Instructor List</h2>
                <?php if (isset($error_message)): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php else: ?>
                    <table>
                        <tr>
                            <th>Instructor ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                            <th>Gender</th>
                            <th>Phone Number</th>
                            <th>University Name</th>
                            <th>Department</th>
                            <th>Salary</th>
                            <th>Joined Date</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach ($instructors as $instructor): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($instructor['I_ID']); ?></td>
                                <td><?php echo htmlspecialchars($instructor['First_name']); ?></td>
                                <td><?php echo htmlspecialchars($instructor['Last_name']); ?></td>
                                <td><?php echo htmlspecialchars($instructor['username']); ?></td>
                                <td><?php echo htmlspecialchars($instructor['Gender']); ?></td>
                                <td><?php echo htmlspecialchars($instructor['Phone_number']); ?></td>
                                <td><?php echo htmlspecialchars($instructor['University_name']); ?></td>
                                <td><?php echo htmlspecialchars($instructor['Department']); ?></td>
                                <td><?php echo htmlspecialchars($instructor['Salary']); ?></td>
                                <td><?php echo htmlspecialchars($instructor['Join_date']); ?></td>
                                <td>
                                    <form method="POST" style="display:inline-block;">
                                        <input type="hidden" name="delete_instructor_id" value="<?php echo $instructor['I_ID']; ?>">
                                        <button type="submit" class="delete-button">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        <!-- Notice Options -->
        <?php elseif (isset($_GET['page']) && $_GET['page'] == 'notice_options'): ?>
            <div class="option">
                <h2>Notice</h2>
                <a href="?page=view_notice">View Notice</a>
                <a href="?page=add_notice">Add Notice</a>
            </div>
        <!-- View Notice -->
        <?php elseif (isset($_GET['page']) && $_GET['page'] == 'view_notice'): ?>
            <div class="option">
                <h2>View Notice</h2>
                <?php if (isset($error_message)): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php else: ?>
                    <table>
                        <tr>
                            <th>Notice ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Posted Date</th>
							<th>Delete</th>
                        </tr>
                        <?php foreach ($notices as $notice): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($notice['Notice_ID']); ?></td>
                                <td><?php echo htmlspecialchars($notice['Title']); ?></td>
                                <td><?php echo htmlspecialchars($notice['Description']); ?></td>
                                <td><?php echo htmlspecialchars($notice['Posted_date']); ?></td>
								<td><form method="post" action="">
                                        <input type="hidden" name="delete_notice_id" value="<?php echo $notice['Notice_ID']; ?>">
                                        <button type="submit" class="delete-button">Delete</button>
                                    </form></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        <!-- Add Notice -->
        <?php elseif (isset($_GET['page']) && $_GET['page'] == 'add_notice'): ?>
            <div class="option">
                <h2>Add Notice</h2>
                <?php if (isset($notice_error)): ?>
                    <p style="color: red;"><?php echo $notice_error; ?></p>
                <?php elseif (isset($notice_success)): ?>
                    <p style="color: green;"><?php echo $notice_success; ?></p>
                <?php endif; ?>
                <form action="" method="post">
                    <input type="hidden" name="add_notice" value="1">
                    <input type="text" name="title" placeholder="Notice Title" required>
                    <textarea name="description" placeholder="Notice Description" required></textarea>
                    <input type="submit" value="Submit">
                </form>
            </div>
			 <?php endif; ?>
    </div>
	
</body>
</html>