<html>
<head>
<title>Pipoca</title>

<link rel="stylesheet" type="text/css" href="css/main.css">

</head>

<body>

<div id="#tudo">

<object data="css/logo.svg" type="image/svg+xml" height=200 width=900></object>

<div id="menu">
<?php include("menu.html"); ?>
</div>

<div id="centro">
    <?php
    
    include("connection.php");

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysql_error());
}

//deleting all sources
$sql = "DELETE FROM sources WHERE id='" . $_GET["id"] . "'";
if (mysqli_query($conn, $sql)) {
    echo "<h4>Sources removed.</h4>";
    $last_id = mysqli_insert_id($conn);
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

//deleting all the codings
$sql = "DELETE FROM sourceCoding WHERE source_id='" . $_GET["id"] . "'";
if (mysqli_query($conn, $sql)) {
    echo "<h4>Codings removed.</h4>";
    $last_id = mysqli_insert_id($conn);
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

//deleting all the atributes
$sql = "DELETE FROM sourceAttributes WHERE source_id='" . $_GET["id"] . "'";
if (mysqli_query($conn, $sql)) {
    echo "<h4>Attributes removed.</h4>";
    $last_id = mysqli_insert_id($conn);
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}


mysqli_close($conn);
?>

Actions: <a href='viewImages.php'>View latest sources</a> | <a href='newImage.php'>Upload a new source</a>

</div>

</div>
    
</body>
</html>