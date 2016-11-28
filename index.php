<html>
<head>
<title>openQDA</title>

<link rel="stylesheet" type="text/css" href="css/main.css">

</head>

<body>

<div id="#tudo">

<object data="css/logo.svg" type="image/svg+xml" height=200 width=900></object>

<div id="menu">
<?php include("menu.html"); ?>
</div>

<div id="centro">
    <h2>Summary of the project</h2>

<?php
include("connection.php");

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//images
$sql = "SELECT date FROM sources ORDER BY date DESC";
$result = mysqli_query($conn, $sql);
echo "<span class='fieldname'>Total of images: </span>" . mysqli_num_rows($result) . "\n<br>\n";
$row = mysqli_fetch_assoc($result);
echo "<span class='fieldname'>Last insertion: </span>" . $row["date"] . "\n<br>\n";

//codes
$sql = "SELECT id FROM codes";
$result = mysqli_query($conn, $sql);
echo "<span class='fieldname'>Total of codes available: </span>" . mysqli_num_rows($result) . "\n<br>\n";

//codings
$sql = "SELECT date FROM sourceCoding ORDER BY date DESC";
$result = mysqli_query($conn, $sql);
echo "<span class='fieldname'>Total of codings done: </span>" . mysqli_num_rows($result) . "\n<br>\n";
$row = mysqli_fetch_assoc($result);
echo "<span class='fieldname'>Last insertion: </span>" . $row["date"] . "\n<br>\n";

//atributes
$sql = "SELECT * FROM attributes";
$result = mysqli_query($conn, $sql);
echo "<span class='fieldname'>Total of attributes available: </span>" . mysqli_num_rows($result) . "\n<br>\n";

mysqli_close($conn);
?>
    
</div>

</div>

</body>
</html>