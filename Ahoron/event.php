<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
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

        .club-details, .events {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .club-details p, .event p {
            margin: 10px 0;
        }

        .event {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .event:last-child {
            border-bottom: none;
        }

        .event a {
            color: #009688;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .event a:hover {
            color: #00796b; /* Darker teal */
        }
    </style>
</head>
<body>
    <header>
        <a href="student.php">Home</a>
        <a href="index.php">Log out</a>
    </header>

    <div class="container">
        <?php
        include('connection.php');

        if (isset($_GET['club_name'])) {
            $club_name = $con->real_escape_string($_GET['club_name']);

            $sql_club = "SELECT description, establishment_date, mission FROM club WHERE club_name = ?";
            $stmt_club = $con->prepare($sql_club);
            $stmt_club->bind_param("s", $club_name);
            $stmt_club->execute();
            $result_club = $stmt_club->get_result();

            if ($result_club->num_rows > 0) {
                $club = $result_club->fetch_assoc();
                echo "<div class='club-details'>";
                echo "<h2>{$club_name}</h2>";
                echo "<p><strong>Description:</strong> " . htmlspecialchars($club["description"]) . "</p>";
                echo "<p><strong>Established Date:</strong> " . htmlspecialchars($club["establishment_date"]) . "</p>";
                echo "<p><strong>Mission:</strong> " . htmlspecialchars($club["mission"]) . "</p>";
                echo "</div>";

                $sql_events = "SELECT past_events, upcoming_events FROM event WHERE club_name = ?";
                $stmt_events = $con->prepare($sql_events);
                $stmt_events->bind_param("s", $club_name);
                $stmt_events->execute();
                $result_events = $stmt_events->get_result();

                if ($result_events->num_rows > 0) {
                    $events = $result_events->fetch_assoc();

                    echo "<div class='events'>";
                    echo "<h2>Upcoming Events</h2>";
                    $upcoming_events = json_decode($events["upcoming_events"], true);
                    if (!empty($upcoming_events)) {
                        foreach ($upcoming_events as $event) {
                            echo "<div class='event'>";
                            echo "<p><strong>Event:</strong> " . htmlspecialchars($event["event"]) . "</p>";
                            echo "<p><strong>Link:</strong> <a href='" . htmlspecialchars($event["link"]) . "'>" . htmlspecialchars($event["link"]) . "</a></p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No upcoming events found.</p>";
                    }
                    echo "</div>";

                    echo "<div class='events'>";
                    echo "<h2>Past Events</h2>";
                    $past_events = json_decode($events["past_events"], true);
                    if (!empty($past_events)) {
                        foreach ($past_events as $event) {
                            echo "<div class='event'>";
                            echo "<p><strong>Event:</strong> " . htmlspecialchars($event["event"]) . "</p>";
                            echo "<p><strong>Link:</strong> <a href='" . htmlspecialchars($event["link"]) . "'>" . htmlspecialchars($event["link"]) . "</a></p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No past events found.</p>";
                    }
                    echo "</div>";
                } else {
                    echo "<p>No events found for {$club_name}.</p>";
                }

                $stmt_events->close();
            } else {
                echo "<p>No details found for {$club_name}.</p>";
            }

            $stmt_club->close();
        } else {
            echo "<p>Club name parameter is missing.</p>";
        }

        $con->close();
        ?>
    </div>
</body>
</html>
