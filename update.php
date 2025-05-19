<!-- filepath: c:\xampp\htdocs\dashboard\update.php -->
<?php
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

$rollno = "";
$name = "";
$email = "";
$age = "";
$gender = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fetch'])) {
    $rollno = htmlspecialchars($_POST['rollno']);

    // Fetch data for the given roll number
    $sql = "SELECT * FROM mentees WHERE rollno='$rollno'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $email = $row['email'];
        $age = $row['age'];
        $gender = $row['gender'];
    } else {
        echo "<script>alert('No record found for Roll No: $rollno');</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $rollno = htmlspecialchars($_POST['rollno']);
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $age = htmlspecialchars($_POST['age']);
    $gender = htmlspecialchars($_POST['gender']);

    // Update the record
    $sql = "UPDATE mentees SET name='$name', email='$email', age='$age', gender='$gender' WHERE rollno='$rollno'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record updated successfully');</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Mentee</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
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
        input[type="email"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <form action="update.php" method="post">
        <h1>Update Mentee</h1>
        <label for="rollno">Roll No:</label>
        <input type="text" id="rollno" name="rollno" value="<?php echo $rollno; ?>" required>
        <input type="submit" name="fetch" value="Fetch Data">

        <?php if (!empty($name)) { ?>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" value="<?php echo $age; ?>" required min="18" max="60">

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="male" <?php echo $gender == 'male' ? 'selected' : ''; ?>>Male</option>
                <option value="female" <?php echo $gender == 'female' ? 'selected' : ''; ?>>Female</option>
                <option value="other" <?php echo $gender == 'other' ? 'selected' : ''; ?>>Other</option>
            </select>

            <input type="submit" name="update" value="Update">
        <?php } ?>
    </form>
    <a href="mentee.php" class="back-link">Back</a>
</body>
</html>