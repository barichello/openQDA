<?php
$servername = "mysql01.mais.mat.br";
$username = "mais6";
$password = "senhasql17";
$dbname = "mais6";

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
    while($row = mysqli_fetch_assoc($result)) {
        //basic info from the sources table
        echo "<div class='unidade'>";
        echo "<img src='sources/" . $row["name"]. "'>\n";
        echo "<span class='fieldname'>ID: </span><span class='fieldvalue'>" . $row["id"]. "</span><br/><span class='fieldname'>Description: </span><span class='fieldvalue'>" . $row["memo"]. "</span><br/>";
        //getting and showing the attributes
        $result2 = mysqli_query($conn, "SELECT * FROM (SELECT sourceAttributes.value, attributes.name, sourceAttributes.source_id FROM sourceAttributes INNER JOIN attributes ON sourceAttributes.attributes_id=attributes.id)fusao WHERE source_id=" . $row["id"]);
        echo "<span class='fieldname'>Atributes</span><br>\n";
        while($row2 = mysqli_fetch_assoc($result2)) {
            echo $row2["name"] . "=" . $row2["value"] . " , ";
        }
        echo "\n<br>\n<br>\n<a class=''actions' href='viewImagewithBites.php?idImage=" . $row["id"] . "'>View</a><br><a class='actions' href='editAttributes.php?idImage=" . $row["id"] . "'>Edit attributes</a>\n<br/><a class='actions' href='applyCodes.php?idImage=" . $row["id"] . "'>Apply code</a>\n<br/>\n</div>\n";
    }
else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>