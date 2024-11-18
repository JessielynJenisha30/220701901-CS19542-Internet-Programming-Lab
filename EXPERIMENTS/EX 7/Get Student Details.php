<?php
if (isset($_GET['regNo'])) {
    $regNo = $_GET['regNo'];

    // Database connection
    $conn = new mysqli("localhost", "username", "password", "your_database");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to get student details
    $sql = "SELECT * FROM students WHERE reg_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $regNo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<h2>Student Details</h2>";
        echo "<p>Registration No: " . $row["reg_no"] . "</p>";
        echo "<p>Name: " . $row["name"] . "</p>";
        echo "<p>Course: " . $row["course"] . "</p>";
        echo "<p>Year: " . $row["year"] . "</p>";
        echo "<p>Email: " . $row["email"] . "</p>";
    } else {
        echo "<p>No details found for the selected registration number.</p>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<p>Invalid request. Please select a valid registration number.</p>";
}
?>
