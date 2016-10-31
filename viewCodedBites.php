<html>
<head>
<title>openQDA</title>

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

<h2>View coded bites</h2>

<?php
include("connection.php");

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "<span class='fieldname'>Code's id:</span>" . $_GET["id"] . "\n<br><br>\n";

$sql = "SELECT * FROM (SELECT images.name, imageCoding.x1, imageCoding.x2, imageCoding.y1, imageCoding.y2, imageCoding.codes_id FROM images INNER JOIN imageCoding ON images.id = imageCoding.images_id)fusao WHERE codes_id = '" . $_GET["id"] . "'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "<div class='bites' style='background: url(images/" . $row["name"] . "); background-position: -" . min($row["x1"],$row["x2"]) . "px -" . min($row["y1"],$row["y2"]) . "px; width: " . abs($row["x2"]-$row["x1"]) . "px; height: " . abs($row["y2"]-$row["y1"]) . "px;'></div>\n<br>";
    }
    
} else {
    echo "0 results";
}

mysqli_close($conn);
?> 

</div>
</div>

</body>
</html>