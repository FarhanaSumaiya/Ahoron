<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Clubs Management</title>
    <link rel="stylesheet" href="style.css">
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
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #3498db; /* Teal header background */
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

        h1 {
            text-align: center;
            margin: 20px 0;
            color: #007bff; /* Blue header text color */
        }

        nav {
            text-align: center;
            margin-bottom: 20px;
        }

        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #009688;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #00796b; /* Darker teal */
        }

        .content {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .event {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .event h2 {
            margin: 0 0 10px 0;
            color: #007bff; /* Blue event title */
        }

        .event p {
            margin: 5px 0;
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
        <a href="Admin.php">Home</a>
        <a href="A_login.php?action=logout">Logged out</a>
    </header>

    <h1>University Clubs Management</h1>
    <nav>
        <a href="?page=view">View</a>
        <a href="?page=add">Add</a>
        <a href="?page=update">Update</a>
        <a href="?page=delete">Delete</a>
        <a href="?page=search">Search</a>
        <a href="?page=Add_event">Add event</a>
    </nav>

    <div class="content">
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            switch ($page) {
                case 'view':
                    include 'view.php';
                    break;
                case 'add':
                    include 'add.php';
                    break;
                case 'update':
                    include 'update.php';
                    break;
                case 'delete':
                    include 'delete.php';
                    break;
                case 'search':
                    include 'search.php';
                    break;
                case 'Add_event':
                    include 'add_event.php';
                    break;
                default:
                    echo "<p>Page not found.</p>";
                    break;
            }
        } else {
		
		}
        ?>
    </div>
</body>
</html>
