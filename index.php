<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style type="text/css">
        body {
            background-color: #f4f4f4;
            color: #333;
            font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
            font-size: 1em;
            margin: 0;
            padding: 0;
        }
        
        h1 {
            font-size: 2.5em;
            color: #333;
            text-align: center;
            margin-top: 20px;
        }
        
        p {
            text-align: center;
            font-size: 1.2em;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            font-size: 1.2em;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        h2 {
            text-align: center;
            margin-top: 40px;
            font-size: 1.5em;
        }

        h3 {
            text-align: center;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <h1>Register Here!</h1>
    <p>Fill in your name and email address, then click <strong>Submit</strong> to register.</p>
    
    <form method="post" action="index.php" enctype="multipart/form-data">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" required />

        <label for="email">Email</label>
        <input type="text" name="email" id="email" required />

        <input type="submit" name="submit" value="Submit" />
    </form>

    <?php
    // DB connection info
    $host = "fkvesic1-server.mysql.database.azure.com";
    $user = "eywsthmwzn";
    $pwd = "VjkD$St7sSF50x5G";
    $db = "fkvesic1";

    // Connect to database
    $conn = mysqli_connect($host, $user, $pwd, $db);
    if (mysqli_connect_errno()) {
        echo "<h3>Failed to connect to MySQL:</h3>" . mysqli_connect_error();
    }

    // Insert registration info
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['name']) && !empty($_POST['email'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $date = date("Y-m-d");

        // Insert data
        $sql_insert = "INSERT INTO registration_tbl (name, email, date) VALUES ('$name','$email','$date')";
        if ($conn->query($sql_insert) === TRUE) {
            echo "<h3>Your registration is successful!</h3>";

            // Retrieve data
            $sql_select = "SELECT * FROM registration_tbl";
            $registrants = $conn->query($sql_select);
            if ($registrants->num_rows > 0) {
                echo "<h2>People who are registered:</h2>";
                echo "<table>";
                echo "<tr><th>Name</th><th>Email</th><th>Date</th></tr>";
                while ($registrant = $registrants->fetch_assoc()) {
                    echo "<tr><td>" . htmlspecialchars($registrant['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($registrant['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($registrant['date']) . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<h3>No one is currently registered.</h3>";
            }
        } else {
            echo "<h3>Registration failed. Please try again.</h3>";
        }
    }
    ?>
</body>
</html>
