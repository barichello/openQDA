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
<h2>Attributes</h2>

<?php
include("connection.php");

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql = "SELECT id, name, memo FROM attributes";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "<div class='item'>\n";
        echo "<span class='fieldname'>id:</span>" . $row["id"] . "<br>\n";
        echo "<span class='fieldname'>Name:</span>" . $row["name"]. "<br>\n<span class='fieldname'>Description:</span>" . $row["memo"] . "<br>\n";
        echo "<span class='fieldname'>Registered values:</span>";
        //printing the values for this attribute in table sourceAttributes
        $result2 = mysqli_query($conn, "SELECT DISTINCT value FROM sourceAttributes WHERE attributes_id='" . $row["id"] . "'");
        while($row2 = mysqli_fetch_assoc($result2)) {
            echo $row2["value"] . ", ";
        }
        echo "\n</div>\n";
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>

</body>
</html>