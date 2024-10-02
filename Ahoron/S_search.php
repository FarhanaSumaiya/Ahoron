<?php
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search_term = $_POST['search_term'];

    $sql = "SELECT university, club_name FROM club WHERE university LIKE ? OR club_name LIKE ?";
    $stmt = $con->prepare($sql);
    $like_term = "%" . $search_term . "%";
    $stmt->bind_param("ss", $like_term, $like_term);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2>Search Results</h2>";
        echo "<div class='clubs-container'>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='club'><a href='fetch_clubs.php?university=" . urlencode($row["university"]) . "'>" . $row["university"] . " - " . $row["club_name"] . "</a></div>";
        }
        echo "</div>";
    } else {
        echo "<p>No results found for '{$search_term}'.</p>";
    }

    $stmt->close();
    $con->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<title>Delete Club</title>-->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5; /* Light gray background */
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            width: 100%;
            padding: 15px;
            box-sizing: border-box;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #009688; /* Teal header background */
        }

        header a {
            text-decoration: none;
            color: #fff; /* White text color */
            font-weight: bold;
            transition: color 0.3s ease;
        }

        header a:hover {
            color: #ffa500; /* Orange color on hover */
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff; /* Blue header text color */
        }

        form {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        form input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        form input[type="submit"] {
            background-color: #009688; /* Teal */
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        form input[type="submit"]:hover {
            background-color: #00796b; /* Darker teal */
        }
    </style>
</head>
<body>
 <header>
        <a href="student.php">Home</a>
        <a href="index.php">Logged out</a>
    </header>

    <div class="container">
<h2>Search Clubs</h2>
<form method="POST">
    <label for="search_term">Search:</label>
    <input type="text" id="search_term" name="search_term" required>
    <input type="submit" value="Search">
</form>
</div>
</body>
</html>
