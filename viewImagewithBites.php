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

<?php
include("connection.php");

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//pegando a imagem
$sql = "SELECT * FROM images WHERE id='" . $_GET["idImage"] . "'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

//basic info
echo "<span class='fieldname'>ID: </span>" . $row["id"] . "<br/><span class='fieldname'>Description: </span>" . $row["memo"]. "<br/>";

//getting and showing the attributes
$result3 = mysqli_query($conn, "SELECT * FROM (SELECT imageAttributes.value, attributes.name, imageAttributes.images_id FROM imageAttributes INNER JOIN attributes ON imageAttributes.attributes_id=attributes.id)fusao WHERE images_id=" . $_GET["idImage"]);
echo "<span class='fieldname'>Atributes:</span>";
while($row3 = mysqli_fetch_assoc($result3)) {
    echo $row3["name"] . "=" . $row3["value"] . ", ";
}
echo "<br>\n<span class='fieldname'>actions:</span><a href='editAttributes.php?idImage=" . $_GET["idImage"] . "'>Edit attributes</a> | <a href='applyCodes.php?idImage=" . $_GET["idImage"] . "'>Apply code</a>";

//drawing the image on the canvas
list($width, $height) = getimagesize("sources/" . $row["name"]);
echo "<canvas id='canvas0' style='margin: 20px 0 20px 0;' width=800 height=" . ($height*800)/$width . "></canvas>\n";

//espaco pra colocar as descricoes dos pedacos codificados
echo "\n<br>\n<span class='fieldname'>Codings:</span>\n";
echo "<div id='abouttheCodes'></div>";

//comeco dos scripts pra desenhar os retangulos
echo "<script> var x = document.createElement('img');\n x.src = 'sources/" . $row["name"]  . "';\n";
echo "document.getElementById('canvas0').getContext('2d').drawImage(x,0,0,800," . $height*(800/$width) . ");\n";

//pegando as regioes codificadas dessa imagem - ACRESCENTEI MEMO
$sql2 = "SELECT * FROM ( SELECT images_id, codes_id, x1, y1, x2, y2, name, color, imageCoding.memo FROM imageCoding INNER JOIN codes ON imageCoding.codes_id = codes.id)fusao WHERE images_id=" . $_GET["idImage"];
$result2 = mysqli_query($conn, $sql2);

//desenhando os retangulos na imagem
echo "var canvas = document.getElementById('canvas0'); var ctx = canvas.getContext('2d');ctx.font = '12px Verdana';\n";
while($row2 = mysqli_fetch_assoc($result2)) {
    echo "ctx.strokeStyle='" . $row2["color"] . "';\n";
    echo "ctx.fillStyle='" . $row2["color"] . "';\n";
    echo "ctx.strokeRect(" . $row2["x1"]*(800/$width) .  "," . $row2["y1"]*(800/$width) . "," . ($row2["x2"]-$row2["x1"])*(800/$width) . "," . ($row2["y2"]-$row2["y1"])*(800/$width) . ");\n";
    echo "ctx.fillText('" . $row2["name"] . "'," . $row2["x1"]*(800/$width) .  "," . $row2["y1"]*(800/$width) . ");\n"; //trocar ID por nome do code
    //para mostrar os dados dos codes antes da imagem
    echo "document.getElementById('abouttheCodes').innerHTML += '<span style=color:" . $row2["color"] . ";>" . $row2["name"] . "</span>: " . $row2["memo"] . "';";
    echo "document.getElementById('abouttheCodes').innerHTML += ' <a class=deletelink href=doDeleteCoding.php?imageId=" . $row2["images_id"] . "&codeId="  . $row2["codes_id"] .  ">[delete code]</a></br>';";
    }

    
echo "</script>";
$d = str_replace(" ","x",$row["date"]); //tweaking the string to send by GET
echo "<div></br><span class='fieldname'>Navigate: </span><a href=http://www.mais.mat.br/webQDA/viewImagewithBites.php?idImage=" . ($row["id"]-1) . ">Previous image</a> | <a href=http://www.mais.mat.br/webQDA/viewImagewithBites.php?idImage=" . ($row["id"]+1) . ">Next image</a> | <a href=http://www.mais.mat.br/webQDA/uploadedTogether.php?date=" . $d . ">Other images uploaded with this one</a></div>";
    
mysqli_close($conn);
?> 

</div>
</div>

</body>
</html>