<!-- filepath: c:\xampp\htdocs\dashboard\mentee.php -->
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $rollno = htmlspecialchars($_POST['rollno'] ?? '');
    $age = htmlspecialchars($_POST['age'] ?? '');
    $gender = htmlspecialchars($_POST['gender'] ?? '');

    if ($action === "add") {
        // Validate inputs
        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            echo "Invalid name. Only letters and spaces are allowed.";
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format.";
            exit;
        }

        if ($age < 18 || $age > 60) {
            echo "Age must be between 18 and 60.";
            exit;
        }

        if (empty($gender)) {
            echo "Gender is required.";
            exit;
        }

        // Insert record
        $sql = "INSERT INTO mentees (name, email, rollno, age, gender) VALUES ('$name', '$email', '$rollno', '$age', '$gender')";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($action === "update") {
        // Update record
        $sql = "UPDATE mentees SET name='$name', email='$email', age='$age', gender='$gender' WHERE rollno='$rollno'";
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($action === "delete") {
        // Delete record
        $sql = "DELETE FROM mentees WHERE rollno='$rollno'";
        if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($action === "display") {
        // Display records
        $sql = "SELECT * FROM mentees";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<table border='1' style='width:100%; text-align:left;'>";
            echo "<tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roll No</th>
                    <th>Age</th>
                    <th>Gender</th>
                  </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["name"]) . "</td>
                        <td>" . htmlspecialchars($row["email"]) . "</td>
                        <td>" . htmlspecialchars($row["rollno"]) . "</td>
                        <td>" . htmlspecialchars($row["age"]) . "</td>
                        <td>" . htmlspecialchars($row["gender"]) . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "No records found.";
           
        }
       
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentee Information Form</title>
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
        input[type="button"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 10px;
        }
        input[type="button"]:hover {
            background-color: #218838;
        }
        input[type="submit"] {
            background-color: #dc3545;
        }
        input[type="submit"]:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <form action="mentee.php" method="post" onsubmit="return validateForm()">
        <h1>Mentee Information Form</h1>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="rollno">Roll No:</label>
        <input type="text" id="rollno" name="rollno" required>
        
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required min="18" max="60">
        
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="">Select</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
        
        <input type="hidden" id="action" name="action">
        <input type="button" value="Add" onclick="submitForm('add')">
        <input type="button" value="Update" onclick="redirectToUpdate()">
        <input type="button" value="Delete" onclick="redirectToDelete()"> 
        <input type="button" value="Display" onclick="submitForm('display')">
    </form>

    <script>
        function validateForm() {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const age = document.getElementById('age').value;
            const gender = document.getElementById('gender').value;

            const namePattern = /^[a-zA-Z\s]+$/;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!namePattern.test(name)) {
                alert('Name must contain only letters and spaces.');
                return false;
            }

            if (!emailPattern.test(email)) {
                alert('Please enter a valid email address.');
                return false;
            }

            if (age < 18 || age > 60) {
                alert('Age must be between 18 and 60.');
                return false;
            }

            if (gender === "") {
                alert('Please select a gender.');
                return false;
            }

            return true;
        }

        function submitForm(action) {
            document.getElementById('action').value = action;
            document.forms[0].submit();
        }

        function redirectToDelete() {
            // Redirect to delete.php
            window.location.href = "delete.php";
        }

        function redirectToUpdate(){
            window.location.href = "update.php";
        }

    </script>
</body>
</html>