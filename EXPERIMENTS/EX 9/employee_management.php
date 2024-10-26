<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "company_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'insert') {
            // Insert employee data
            $ename = $_POST['ename'];
            $desig = $_POST['desig'];
            $dept = $_POST['dept'];
            $doj = $_POST['doj'];
            $salary = $_POST['salary'];

            $sql = "INSERT INTO EMPDETAILS (ENAME, DESIG, DEPT, DOJ, SALARY)
                    VALUES ('$ename', '$desig', '$dept', '$doj', '$salary')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully<br>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } elseif ($_POST['action'] == 'view') {
            // Retrieve employee data
            $sql = "SELECT * FROM EMPDETAILS";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<h3>Employee Details:</h3>";
                while($row = $result->fetch_assoc()) {
                    echo "ID: " . $row["EMPID"]. " - Name: " . $row["ENAME"]. " - Designation: " . $row["DESIG"]. " - Department: " . $row["DEPT"]. " - DOJ: " . $row["DOJ"]. " - Salary: " . $row["SALARY"]. "<br>";
                }
            } else {
                echo "0 results";
            }
        }
    }
}

$conn->close();
?>

<!-- HTML Form for Inserting and Viewing Employee Data -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
</head>
<body>
    <h1>Employee Management System</h1>

    <h2>Insert New Employee</h2>
    <form method="post" action="">
        <input type="hidden" name="action" value="insert">
        <label for="ename">Name:</label>
        <input type="text" id="ename" name="ename" required><br><br>
        <label for="desig">Designation:</label>
        <input type="text" id="desig" name="desig" required><br><br>
        <label for="dept">Department:</label>
        <input type="text" id="dept" name="dept" required><br><br>
        <label for="doj">Date of Joining:</label>
        <input type="date" id="doj" name="doj" required><br><br>
        <label for="salary">Salary:</label>
        <input type="number" id="salary" name="salary" required><br><br>
        <input type="submit" value="Submit">
    </form>

    <h2>View Employees</h2>
    <form method="post" action="">
        <input type="hidden" name="action" value="view">
        <input type="submit" value="View All Employees">
    </form>
</body>
</html>
