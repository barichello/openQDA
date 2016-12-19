<html>
<head>
<title>Pipoca</title>

<link rel="stylesheet" type="text/css" href="css/main.css">

<style>
img {
    float: left;
    margin: 0 20px 10px 0;
    width: 150px;
    }
.item {
    }
</style>

</head>

<body>

<div id="#tudo">

<object data="css/logo.svg" type="image/svg+xml" height=200 width=900></object>

<div id="menu">
<?php include("menu.html"); ?>
</div>

<div id="centro">

<h2>Latest sources inserted</h2>

<?php
include("connection.php");

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//getting the lastest date
$sql = "SELECT date FROM sources ORDER BY date DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$d = $row["date"];

//getting the registers inserted at the same date as the latest
$sql = "SELECT * FROM sources WHERE date='" . $d . "'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    echo "\n<br>\nNumber of results: " . mysqli_num_rows($result) . "\n<br><br>\n";
    while($row = mysqli_fetch_assoc($result)) {
        //basic info from the sources table
        echo "<div class='item'>";
        if ($row["type"]=="i") {
                echo "<img src='sources/" . $row["name"]. "'>\n";
                }
        if ($row["type"]=="v") {
                echo "<img src='css/video-icon.png'>\n";
                } 
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
    echo ":( I could not find any image matching your criteria...";
}


mysqli_close($conn);
?> 

</div>
</div>

</body>
</html>