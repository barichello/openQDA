<?php

include("connection.php");

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    echo "Coding not registered.";
    die("Connection failed: " . mysql_error());
}

$sql = "INSERT INTO imageCoding (images_id, codes_id, x1,y1,x2,y2,owner,status,memo) VALUES ('" . $_POST["images_id"] . "','" . $_POST["codes_id"] . "','" . $_POST["x1"] . "','" . $_POST["y1"] . "','" . $_POST["x2"] . "','" . $_POST["y2"] . "','" . $_POST["owner"] . "','" . $_POST["status"] . "','" . $_POST["memo"] ."')";

if (mysqli_query($conn, $sql)) {
    echo "New coding registered!";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>