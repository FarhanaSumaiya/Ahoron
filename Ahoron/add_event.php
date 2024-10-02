<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
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

        form input[type="text"], form input[type="date"] {
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
    <div class="container">
        <h2>Add Event to Club</h2>
        <?php
        include('connection.php');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $university = $_POST['university'];
            $club_name = $_POST['club_name'];
            $event_name = $_POST['event_name'];
            $event_link = $_POST['event_link'];
            $event_date = $_POST['event_date'];

            $sql_fetch = "SELECT upcoming_events FROM event WHERE university = ? AND club_name = ?";
            $stmt_fetch = $con->prepare($sql_fetch);
            $stmt_fetch->bind_param("ss", $university, $club_name);
            $stmt_fetch->execute();
            $result_fetch = $stmt_fetch->get_result();

            if ($result_fetch->num_rows > 0) {
                $events = $result_fetch->fetch_assoc();
                $upcoming_events = json_decode($events["upcoming_events"], true);

                $upcoming_events[] = [
                    "event" => $event_name,
                    "link" => $event_link,
                    "date" => $event_date
                ];

                $upcoming_events_json = json_encode($upcoming_events);

                $sql_update = "UPDATE event SET upcoming_events = ? WHERE university = ? AND club_name = ?";
                $stmt_update = $con->prepare($sql_update);
                $stmt_update->bind_param("sss", $upcoming_events_json, $university, $club_name);

                if ($stmt_update->execute()) {
                    echo "<p>Event added successfully.</p>";
                } else {
                    echo "<p>Error: " . $stmt_update->error . "</p>";
                }
                $stmt_update->close();
            } else {
                $upcoming_events = [
                    [
                        "event" => $event_name,
                        "link" => $event_link,
                        "date" => $event_date
                    ]
                ];

                $upcoming_events_json = json_encode($upcoming_events);

                $sql_insert = "INSERT INTO event (university, club_name, upcoming_events) VALUES (?, ?, ?)";
                $stmt_insert = $con->prepare($sql_insert);
                $stmt_insert->bind_param("sss", $university, $club_name, $upcoming_events_json);

                if ($stmt_insert->execute()) {
                    echo "<p>Event added successfully.</p>";
                } else {
                    echo "<p>Error: " . $stmt_insert->error . "</p>";
                }
                $stmt_insert->close();
            }

            $stmt_fetch->close();
            $con->close();
        }
        ?>

        <form method="POST">
            <label for="university">University:</label>
            <input type="text" id="university" name="university" required>

            <label for="club_name">Club Name:</label>
            <input type="text" id="club_name" name="club_name" required>

            <label for="event_name">Event Name:</label>
            <input type="text" id="event_name" name="event_name" required>

            <label for="event_link">Event Link:</label>
            <input type="text" id="event_link" name="event_link" required>

            <label for="event_date">Event Date:</label>
            <input type="date" id="event_date" name="event_date" required>

            <input type="submit" value="Add Event">
        </form>
    </div>
</body>
</html>
