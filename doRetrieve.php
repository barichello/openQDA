<?php

include("connection.php");

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    echo "Retrieval failed. ";
    die("Connection failed: " . mysql_error());
}

$sql = $_POST["string"];

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    echo "\n<br>\nNumber os results: " . mysqli_num_rows($result) . "\n<br><br>\n";
    while($row = mysqli_fetch_assoc($result)) {
        //basic info from the sources table
        echo "<div class='item'>";
        echo "<img src='sources/" . $row["name"]. "'>\n";
        echo "<span class='fieldname'>ID: </span><span class='fieldvalue'>" . $row["id"]. "</span><br/><span class='fieldname'>Description: </span><span class='fieldvalue'>" . $row["memo"]. "</span><br/>";
        //getting and showing the attributes
        $result2 = mysqli_query($conn, "SELECT * FROM (SELECT sourceAttributes.value, attributes.name, sourceAttributes.source_id FROM sourceAttributes INNER JOIN attributes ON sourceAttributes.attributes_id=attributes.id)fusao WHERE source_id=" . $row["id"]);
        echo "<span class='fieldname'>Atributes:</span>\n";
        while($row2 = mysqli_fetch_assoc($result2)) {
            echo $row2["name"] . "=" . $row2["value"] . " , ";
        }
        echo "\n<br>\n<a class=''actions' href='viewImagewithBites.php?idImage=" . $row["id"] . "'>View</a> | <a class='actions' href='editAttributes.php?idImage=" . $row["id"] . "'>Edit attributes</a> | <a class='actions' href='applyCodes.php?idImage=" . $row["id"] . "'>Apply code</a>\n";
        echo "\n<div style='clear: both;'><!-- --></div>\n</div>\n";
    }
}
else {
    echo ":( I could not find any image matching your criterias...";
}

mysqli_close($conn);
?>