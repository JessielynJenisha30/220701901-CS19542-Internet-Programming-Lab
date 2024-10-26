<!DOCTYPE html>
<html>
<head>
    <title>Banking Application</title>
</head>
<body>
    <h1>Banking Application</h1>
    <nav>
        <ul>
            <li><a href="?action=display_customers">Display Customer Information</a></li>
            <li><a href="?action=display_accounts">Display Account Information</a></li>
            <li><a href="?action=insert_customer">Insert Customer Information</a></li>
            <li><a href="?action=insert_account">Insert Account Information</a></li>
        </ul>
    </nav>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "banking_app";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle form submissions
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['submit_customer'])) {
            $cname = $_POST['cname'];

            if (!empty($cname)) {
                $stmt = $conn->prepare("INSERT INTO CUSTOMER (CNAME) VALUES (?)");
                $stmt->bind_param("s", $cname);

                if ($stmt->execute()) {
                    echo "New customer created successfully<br>";
                } else {
                    echo "Error: " . $stmt->error . "<br>";
                }

                $stmt->close();
            } else {
                echo "Customer name is required<br>";
            }
        } elseif (isset($_POST['submit_account'])) {
            $cid = $_POST['cid'];
            $atype = $_POST['atype'];
            $balance = $_POST['balance'];

            if (!empty($cid) && !empty($atype) && !empty($balance) && ($atype == 'S' || $atype == 'C')) {
                $stmt = $conn->prepare("INSERT INTO ACCOUNT (ATYPE, BALANCE, CID) VALUES (?, ?, ?)");
                $stmt->bind_param("sdi", $atype, $balance, $cid);

                if ($stmt->execute()) {
                    echo "New account created successfully<br>";
                } else {
                    echo "Error: " . $stmt->error . "<br>";
                }

                $stmt->close();
            } else {
                echo "All fields are required and account type must be 'S' or 'C'<br>";
            }
        }
    }

    // Handle displaying content based on selected action
    if (isset($_GET['action'])) {
        $action = $_GET['action'];

        if ($action == 'display_customers') {
            echo "<h2>Customer Information</h2>";
            $sql = "SELECT * FROM CUSTOMER";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "ID: " . $row["CID"]. " - Name: " . $row["CNAME"]. "<br>";
                }
            } else {
                echo "0 results<br>";
            }
        } elseif ($action == 'display_accounts') {
            echo "<h2>Account Information</h2>";
            $sql = "SELECT * FROM ACCOUNT";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "Account Number: " . $row["ANO"]. " - Type: " . $row["ATYPE"]. " - Balance: " . $row["BALANCE"]. " - Customer ID: " . $row["CID"]. "<br>";
                }
            } else {
                echo "0 results<br>";
            }
        } elseif ($action == 'insert_customer') {
            ?>
            <h2>Insert Customer Information</h2>
            <form action="" method="post">
                <label for="cname">Customer Name:</label>
                <input type="text" id="cname" name="cname" required><br><br>
                <input type="submit" name="submit_customer" value="Submit">
            </form>
            <?php
        } elseif ($action == 'insert_account') {
            ?>
            <h2>Insert Account Information</h2>
            <form action="" method="post">
                <label for="cid">Customer ID:</label>
                <input type="number" id="cid" name="cid" required><br><br>
                <label for="atype">Account Type (S for Savings, C for Current):</label>
                <input type="text" id="atype" name="atype" pattern="[SC]" required><br><br>
                <label for="balance">Balance:</label>
                <input type="number" step="0.01" id="balance" name="balance" required><br><br>
                <input type="submit" name="submit_account" value="Submit">
            </form>
            <?php
        }
    }

    $conn->close();
    ?>
</body>
</html>
