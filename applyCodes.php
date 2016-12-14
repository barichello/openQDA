<html>
<head>
<title>openQDA</title>

<link rel="stylesheet" type="text/css" href="css/main.css">

<link rel="stylesheet" type="text/css" href="css/imgareaselect-default.css" />
<script type="text/javascript" src="scripts/jquery.min.js"></script>
<script type="text/javascript" src="scripts/jquery.imgareaselect.pack.js"></script>

<link href="http://vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
<link rel="stylesheet" href="css/videoplayerskin/polyzor-skin.min.css">

<script src="http://vjs.zencdn.net/5.8.8/video.js"></script>

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
    vars = "source_id=" + document.getElementById('source_id').value + "&codes_id=" + document.getElementById('codes_id').value + "&x1=" + document.getElementById('x1').value + "&x2=" + document.getElementById('x2').value + "&y1=" + document.getElementById('y1').value + "&y2=" + document.getElementById('y2').value + "&memo=" + document.getElementById('memo').value + "&owner=" + document.getElementById('owner').value + "&status=" + document.getElementById('status').value + "&type=" + document.getElementById('type').innerHTML;
    hr.send(vars); // Actually execute the request
    document.getElementById("result").innerHTML = "processing...";
}

//function to transfer the boundaris of the range to 
function boundariesVideo() {
    var p = videojs('my-video');
    document.getElementById('x1').value = Math.round(document.getElementById('rangeBegin').value*p.duration()/100);
    document.getElementById('y1').value = Math.round(document.getElementById('rangeEnd').value*p.duration()/100);
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

//getting the source
$sql = "SELECT * FROM sources WHERE id='" . $_GET["idImage"] . "'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

//basic info
echo "<span class='fieldname'>ID: </span>" . $row["id"]. "<br/><span class='fieldname'>Description: </span>" . $row["memo"]. "<br/>";
echo "<span style='display:none;' id='type'>" . $row["type"] . "</span>";

//getting and showing the attributes
$result3 = mysqli_query($conn, "SELECT * FROM (SELECT sourceAttributes.value, attributes.name, sourceAttributes.source_id FROM sourceAttributes INNER JOIN attributes ON sourceAttributes.attributes_id=attributes.id)fusao WHERE source_id=" . $_GET["idImage"]);
echo "<span class='fieldname'>Atributes:</span>";
while($row3 = mysqli_fetch_assoc($result3)) {
    echo $row3["name"] . "=" . $row3["value"] . ", ";
}

//image
if ($row["type"]=="i") {
    list($width, $height) = getimagesize("sources/" . $row["name"]);
    echo "<img src='sources/" . $row['name'] .  "' id='image' style='margin: 20px 0 20px 0; width:800px'>\n";
    echo "<span style='display:none;' id='altura'>" . $height . "</span>";
    echo "<span style='display:none;' id='largura'>" . $width . "</span>";
}

//video
if ($row["type"]=="v") {
    echo "<video id='my-video' class='video-js vjs-polyzor-skin' controls style='width: 800px; height: 600px;' preload='metadata'><source src='sources/" . $row["name"] . "' type='video/mp4'></video>\n";
    echo "<br><span class='fieldname'>Select in the sliders below the begin and the end of the section:</span><br>";
    echo "<div style='width: 100%; height: 24px;'><input type='range' id='rangeBegin' min=0 max=100 style='width:800px; vertical-align: middle;' onchange='javascript:boundariesVideo();'><span class='fieldname'> (begin)</span></div>\n";
    echo "<div style='width: 100%; height: 24px;'><input type='range' id='rangeEnd' min=0 max=100 style='width:800px; vertical-align: middle;' onchange='javascript:boundariesVideo();'><span class='fieldname'> (end)</span></div>\n";
    echo "<script>videojs('my-video');</script>";
}

//creating the code selector
$sql = "SELECT name, id FROM codes";
$result = mysqli_query($conn, $sql);
echo "<div style='float: left;'>";
echo "<span class='fieldname'>Select the code:</span><select id='codes_id'>";
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
    }
}
echo "</select>\n<br>\n";
mysqli_close($conn);
?> 
<center><input type=Submit value="Apply code" onclick="ajax_post();"></center>
</div>

<div style='float: left;'>
<textarea id="memo" cols=70 rows=3 placeholder="Comment about the coding here..."></textarea>
</div>

<!--hidden fields with basic info for the coding-->
<input type=hidden id="owner" value="leo">
<input type=hidden id="status" value=1>
<input type=hidden id="source_id" value=<?php echo "'" . $_GET["idImage"] . "'";?> >

<!--hidden fields to keep the boundaries-->
<input type=hidden id="x1" name="x1">
<input type=hidden id="y1" name="y1">
<input type=hidden id="x2" name="x2">
<input type=hidden id="y2" name="y2">

<script type="text/javascript">
//image
if (document.getElementById("type").innerHTML == "i") {
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
}
//video
if (document.getElementById("type").innerHTML == "v") {
    document.getElementById("x2").value = 0;
    document.getElementById("y2").value = 0;
}

</script>

<div style='clear:both;'>
<br>
<span id="result"></span>
<br>

<?php
echo "\n<div style='clear:both;'>\n<br><br>\n<span class='fieldname'>actions:</span><a href='viewImagewithBites.php?idImage=" . $_GET["idImage"] . "'>Back</a> | <a href='editAttributes.php?idImage=" . $_GET["idImage"] . "'>Edit attributes</a>\n<br/>\n";
?>

</div>

</div>
</div>

</body>
</html>