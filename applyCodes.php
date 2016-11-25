<html>
<head>
<title>openQDA</title>

<link rel="stylesheet" type="text/css" href="css/main.css">

<link rel="stylesheet" type="text/css" href="css/imgareaselect-default.css" />

<style>
img {
    float: left;
    margin: 0 20px 10px 0;
    width: 150px;
    }
.item {
    }
</style>
<script type="text/javascript" src="scripts/jquery.min.js"></script>
<script type="text/javascript" src="scripts/jquery.imgareaselect.pack.js"></script>

<script>
function ajax_post(){
    // Create our XMLHttpRequest object
    var hr = new XMLHttpRequest();
    hr.open("POST", "addCoding.php", true);
    // Set content type header information for sending url encoded variables in the request
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Access the onreadystatechange event for the XMLHttpRequest object
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			document.getElementById("result").innerHTML = return_data;
	    }
    }
    // Send the data to PHP now... and wait for response to update the status div
    vars = "images_id=" + document.getElementById('images_id').value + "&codes_id=" + document.getElementById('codes_id').value + "&x1=" + document.getElementById('x1').value + "&x2=" + document.getElementById('x2').value + "&y1=" + document.getElementById('y1').value + "&y2=" + document.getElementById('y2').value + "&memo=" + document.getElementById('memo').value + "&owner=" + document.getElementById('owner').value + "&status=" + document.getElementById('status').value
    hr.send(vars); // Actually execute the request
    document.getElementById("result").innerHTML = "processing...";
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
echo "<span class='fieldname'>ID: </span>" . $row["id"]. "<br/><span class='fieldname'>Description: </span>" . $row["memo"]. "<br/>";
//getting and showing the attributes
$result3 = mysqli_query($conn, "SELECT * FROM (SELECT imageAttributes.value, attributes.name, imageAttributes.images_id FROM imageAttributes INNER JOIN attributes ON imageAttributes.attributes_id=attributes.id)fusao WHERE images_id=" . $_GET["idImage"]);
echo "<span class='fieldname'>Atributes:</span>";
while($row3 = mysqli_fetch_assoc($result3)) {
    echo $row3["name"] . "=" . $row3["value"] . ", ";
}

//echo "<img style='max-width: 800;' src='images/" . $row["name"] . "'>\n";
list($width, $height) = getimagesize("sources/" . $row["name"]);
echo "<img src='sources/" . $row['name'] .  "' id='image' style='margin: 20px 0 20px 0; width:800px'>\n";
echo "<span style='display:none;' id='altura'>" . $height . "</span>";
echo "<span style='display:none;' id='largura'>" . $width . "</span>";
//montando o seletor de codigos disponiveis
$sql = "SELECT name, id FROM codes";
$result = mysqli_query($conn, $sql);
echo "<div id='coords' class='controls' style='width:90%'>";

echo "<select id='codes_id'>";
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
    }
}
echo "</select>\n<br>\n";

mysqli_close($conn);
?> 

<script type="text/javascript">
$(document).ready(function () {
    $('img#image').imgAreaSelect({
        handles: true,
        onSelectEnd: function (img, selection) {
            document.getElementById("x1").value = selection.x1;
            document.getElementById("y1").value = selection.y1;
            document.getElementById("x2").value = selection.x2;
            document.getElementById("y2").value = selection.y2;
        },
        imageHeight: document.getElementById("altura").innerHTML,
        imageWidth: document.getElementById("largura").innerHTML
    });
});
</script>

<input type=hidden id="owner" value="leo">
<input type=hidden id="status" value=1>
<input type=hidden id="images_id" value=<?php echo "'" . $_GET["idImage"] . "'";?>>
X<sub>1</sub> = <input type=text size=5 id="x1" name="x1">; Y<sub>1</sub> = <input type=text size=5 id="y1" name="y1"> <br/>
X<sub>2</sub> = <input type=text size=5 id="x2" name="x2">; Y<sub>2</sub> = <input type=text size=5 id="y2" name="y2"> <br/>
<textarea id="memo" cols=30 rows=5 placeholder="Comment about the coding here..."></textarea> <br/>
<input type=Submit value="Apply code" onclick="ajax_post();"> <br/>
<span id="result"></span>

</div>

</div>
</div>

</body>
</html>