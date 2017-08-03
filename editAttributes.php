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
    <h2>Edit attributes</h2>

<?php

include("connection.php");

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//montando o seletor de codigos disponiveis
$sql = "SELECT * FROM (SELECT attributes.id, attributes.name, attributes.memo, sourceAttributes.value, sourceAttributes.source_id FROM attributes LEFT JOIN sourceAttributes ON attributes.id=sourceAttributes.attributes_id)fusao WHERE source_id=" . $_GET["idImage"];

$result = mysqli_query($conn, $sql);
echo "<form method=GET action='doEditAttributes.php'>\n";
echo "<table border=0 valign='top'>\n";
echo "<input type=hidden name='idImage' value='" . $_GET["idImage"] . "'>\n";
while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td><input type=hidden name='idAttributes[]' value='" . $row["id"] . "'>\n";
        echo "<span class='fieldname'>" . $row["name"] . "</td><td><input type=text name='values[]' value='" . $row["value"] . "'></td>\n";
        echo "<td><span class='discrete'>" . $row["memo"] . "</span></td></tr>\n";
    }
echo "<tr><td colspan=3 align=center><br/><input type='Submit' value='OK'></td></tr>\n</table>\n</form>\n";

mysqli_close($conn);
?> 

<div>
<span class='fieldname'>Navigate: </span> <a href=viewImagewithBites.php?idImage=<?php echo $_GET["idImage"] ?> >Back to source</a> | <a href=viewAttributes.php>View all attributes</a>
</div>

</div>
</div>

</body>
</html>
