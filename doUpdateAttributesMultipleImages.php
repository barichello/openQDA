<?php

include("connection.php");

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysql_error());
}

//percorrendo a lista de ids
$arrayIds = explode(';',$_POST["ids"]);
foreach ($arrayIds as $n => $id) {
        $sql = "UPDATE sourceAttributes SET value='" . $_POST["valueAttribute"] . "' WHERE source_id='" . $id . "' AND attributes_id='" . $_POST["attributes_id"] . "'";
        if (mysqli_query($conn, $sql)) {
               echo "Attribute updated!<br>";
        } else {
               echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
}
    
mysqli_close($conn);
?>

