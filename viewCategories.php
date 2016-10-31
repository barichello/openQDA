<?php
include("connection.php");

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "<h2>Categories</h2>";

$sql = "SELECT id, name, memo FROM categories";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "id: " . $row["id"]. " - Name: " . $row["name"]. " - Description: " . $row["memo"]. "<br>";
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?> 