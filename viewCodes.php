<html>
<head>
<title>Pipoca</title>

<link rel="stylesheet" type="text/css" href="css/main.css">

<script>
function deleteCode(n) {
    if (confirm("If you delete this code, you will also loose all the sections codified with it. Do you want to proceed?")) {
        window.location = "doDeleteCode.php?id=" + n;
        }
    }
</script>

</head>

<body>

<div id="#tudo">

<object data="css/logo.svg" type="image/svg+xml" height=200 width=900></object>

<div id="menu">
<?php include("menu.html"); ?>
</div>

<div id="centro">
<h2>Available Codes</h2>
<?php
include("connection.php");

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT id, name, memo, color FROM codes";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "<div class='item'>\n";
        echo "<span class='fieldname'>id:</span>" . $row["id"]. "\n<br>\n <span class='fieldname'>Name:</span>" . $row["name"]. "\n<br>\n<span class='fieldname'>Description:</span>" . $row["memo"] . " \n<br>\n<span class='fieldname'>Color:</span> <span style='color: " . $row["color"] . ";'>" . $row["color"] . "</span>\n<br>\n";
        echo "<span class='fieldname'>actions:</span><a href='javascript:deleteCode(" . $row["id"] .")'>Delete code</a> | <a href='editCode.php?id=" . $row["id"] . "'>Edit code</a>\n";
        echo "</div>\n";
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