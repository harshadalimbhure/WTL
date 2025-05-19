<!-- filepath: c:\xampp\htdocs\dashboard\delete.php -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mentee";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $rollno = htmlspecialchars($_POST['rollno']);

    // Validate input
    if (empty($rollno)) {
        echo "<p style='color: red;'>Roll number is required.</p>";
        exit;
    }

    // Delete record
    $sql = "DELETE FROM mentees WHERE rollno='$rollno'";
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Record deleted successfully.</p>";
    } else {
        echo "<p style='color: red;'>Error deleting record: " . $conn->error . "</p>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Record</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        input[type="text"],
        input[type="submit"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #dc3545;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #c82333;
        }
        .back-link {
            margin-top: 10px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .back-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form action="delete.php" method="post">
        <h1>Delete Record</h1>
        <label for="rollno">Enter Roll No:</label>
        <input type="text" id="rollno" name="rollno" required>
        <input type="submit" value="Confirm">
    </form>

    <!-- Link to redirect back to mentee.php -->
    <a href="mentee.php" class="back-link">Back</a>
</body>
</html>