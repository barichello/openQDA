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

//deleting all the codings
$sql = "DELETE FROM sourceCoding WHERE codes_id='" . $_GET["id"] . "'";
if (mysqli_query($conn, $sql)) {
    echo "<h4>Codings removed.</h4>";
    $last_id = mysqli_insert_id($conn);
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

//deleting all the codings
$sql = "DELETE FROM codes WHERE id='" . $_GET["id"] . "'";
if (mysqli_query($conn, $sql)) {
    echo "<h4>Code removed.</h4>";
    $last_id = mysqli_insert_id($conn);
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}


mysqli_close($conn);
?>

Actions: <a href='viewCodes.php'>Return to the list of codes</a> | <a href='newCode.php'>Create a new code</a>

</div>

</div>
    
</body>
</html>
