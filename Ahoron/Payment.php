<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Options</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/kTcZabJxo9O6AljsPShNEuB7B6rvClJ0WI53dU7X6s8E4/YuK5v1pC5lh96KdHn5H3IerjZwQr6lQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        header {
            width: 100%;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            text-align: left;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            position: absolute;
            top: 0;
            left: 0;
        }
        header a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
        }
        .payment-options {
            margin-top: 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }
        .payment-options a {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }
        .payment-options a:hover {
            background-color: #e0e0e0;
        }
        .payment-options i {
            font-size: 24px;
            color: #3498db;
        }
        form {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        form input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px;
            margin-bottom: 10px;
        }
        form input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #3498db;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        form input[type="submit"]:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    include('connection.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $transaction_id = $_POST['transaction_id'];
        $student_id = $_SESSION['S_ID']; // Assuming the student ID is stored in the session
        $amount = $_POST['amount'];// Replace with the actual amount or get it dynamically if needed

        $sql = "INSERT INTO Payment_req (ID, Transaction_ID, Amount) VALUES ('$student_id', '$transaction_id','$amount')";
        $result = mysqli_query($con, $sql);

        if ($result) {
            echo "<p style='color: green;'>Payment request submitted successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error occurred: " . mysqli_error($con) . "</p>";
        }
    }
    ?>

    <header>
        <a href="Student.php"><i class="fas fa-home"></i> Home</a>
    </header>

    <div class="payment-options">
    
        <a href="https://www.bkash.com/products-services/payment" style="text-decoration: none;"><img src="image/Bkash.png" alt="Logo" style="width: 40px;"></a>
        <a href="https://www.dutchbanglabank.com/rocket/merchant-payment.html" style="text-decoration: none;"><img src="image/rocket.png" alt="Logo" style="width: 40px;"></a>
        <a href="https://www.dutchbanglabank.com/electronic-banking/credit-cards.html" style="text-decoration: none;"><img src="image/dbbl.png" alt="Logo" style="width: 40px;"></a>
        <a href="https://nagad.com.bd/services/?service=merchant-pay"style="text-decoration: none;"><img src="image/nagad.webp" alt="Logo" style="width: 40px;"></a>
        <a href="https://www.upaybd.com/products/make-payment" style="text-decoration: none;"><img src="image/upay.png" alt="Logo" style="width: 40px;"></a>
    </div>

    <p>Already paid?</p>
    <form action="" method="post">
        <input type="text" name="transaction_id" placeholder="Transaction ID" required>
		<input type="text" name="amount" placeholder="Enter Amount" required>
        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>
