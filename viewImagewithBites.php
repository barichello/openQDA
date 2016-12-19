<html>
<head>
<title>Pipoca</title>

<link rel="stylesheet" type="text/css" href="css/main.css">

<link href="http://vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
<link rel="stylesheet" href="css/videoplayerskin/polyzor-skin.min.css">

<script src="http://vjs.zencdn.net/5.8.8/video.js"></script>

<style>
img {
    float: left;
    margin: 0 20px 10px 0;
    width: 150px;
    }
.item {
    }
</style>

<script>
function drawCodings(list,dur) {
        //scale of the bar to adjust to the size of the player
        f = 800/dur;
        var y0=5;
        if (list.length>0) {
            current = list[0][2];
            for (i=0; i<list.length; i++) {
            if (list[i][2]!=current) {
                    y0=y0+15;
                    current=list[i][2];
                }
                var rect = document.createElementNS("http://www.w3.org/2000/svg", 'rect');
                rect.setAttributeNS(null, 'x', f*list[i][0]);
                rect.setAttributeNS(null, 'y', y0);
                rect.setAttributeNS(null, 'height', 10);
                rect.setAttributeNS(null, 'width', f*(list[i][1]-list[i][0]));
                rect.setAttributeNS(null, 'fill', list[i][2]);
                document.getElementById('codes').appendChild(rect);
            }
        }
        document.getElementById('codes').style.height = (y0+10);
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
echo "<span class='fieldname'>ID: </span>" . $row["id"] . "<br/><span class='fieldname'>Description: </span>" . $row["memo"]. "<br/>";
//getting and showing the attributes
$result3 = mysqli_query($conn, "SELECT * FROM (SELECT sourceAttributes.value, attributes.name, sourceAttributes.source_id FROM sourceAttributes INNER JOIN attributes ON sourceAttributes.attributes_id=attributes.id)fusao WHERE source_id=" . $_GET["idImage"]);
echo "<span class='fieldname'>Atributes:</span>";
while($row3 = mysqli_fetch_assoc($result3)) {
    echo $row3["name"] . "=" . $row3["value"] . ", ";
}
echo "<br>\n<span class='fieldname'>actions:</span><a href='editAttributes.php?idImage=" . $_GET["idImage"] . "'>Edit attributes</a> | <a href='applyCodes.php?idImage=" . $_GET["idImage"] . "'>Apply code</a>\n<br/><br/>\n";

//image
if ($row["type"]=="i") {
    //drawing the image on the canvas
    list($width, $height) = getimagesize("sources/" . $row["name"]);
    echo "<canvas id='canvas0' style='margin: 20px 0 20px 0;' width=800 height=" . ($height*800)/$width . "></canvas>\n";
    //div for the codings
    echo "\n<br>\n<span class='fieldname'>Codings:</span>\n";
    echo "<div id='abouttheCodes'></div>";
    //script to draw the rectangles
    echo "<script> var x = document.createElement('img');\n x.src = 'sources/" . $row["name"]  . "';\n";
    echo "document.getElementById('canvas0').getContext('2d').drawImage(x,0,0,800," . $height*(800/$width) . ");\n";
    //getting the codings
    $sql2 = "SELECT * FROM ( SELECT source_id, codes_id, boundaries, name, color, date, sourceCoding.memo FROM sourceCoding INNER JOIN codes ON sourceCoding.codes_id = codes.id)fusao WHERE source_id=" . $_GET["idImage"];
    $result2 = mysqli_query($conn, $sql2);
    //drawing the coding
    echo "var canvas = document.getElementById('canvas0'); var ctx = canvas.getContext('2d');ctx.font = '12px Verdana';\n";
    while($row2 = mysqli_fetch_assoc($result2)) {
        echo "ctx.strokeStyle='" . $row2["color"] . "';\n";
        echo "ctx.fillStyle='" . $row2["color"] . "';\n";
        list($x1, $y1, $x2, $y2) = explode(":", $row2["boundaries"]);
        $x1 = (int)$x1;
        $y1 = (int)$y1;
        $x2 = (int)$x2;
        $y2 = (int)$y2;
        echo "ctx.strokeRect(" . $x1*(800/$width) .  "," . $y1*(800/$width) . "," . ($x2-$x1)*(800/$width) . "," . ($y2-$y1)*(800/$width) . ");\n";
        echo "ctx.fillText('" . $row2["name"] . "'," . $row2["x1"]*(800/$width) .  "," . $row2["y1"]*(800/$width) . ");\n"; //trocar ID por nome do code
        //to list the codes before the image
        echo "document.getElementById('abouttheCodes').innerHTML += '<span style=color:" . $row2["color"] . ";>" . $row2["name"] . "</span>: " . $row2["memo"] . "';";
        echo "document.getElementById('abouttheCodes').innerHTML += ' <a class=deletelink href=doDeleteCoding.php?date=" . str_replace(" ","x",$row2["date"]) . ">[delete coding]</a></br>';";
        }
        
    echo "</script>";       
}

//video
if ($row["type"]=="v") {
    //creating the player
    echo "<video id='my-video' class='video-js vjs-polyzor-skin' controls style='width: 800px; height: 600px;' preload='metadata'><source src='sources/" . $row["name"] . "' type='video/mp4'></video>\n";
    //creating the svg for the codes
    echo "<svg width=800 height=100 id='codes'></svg>\n";
    echo "<br><br><div id='abouttheCodes'></div><br>\n";
    //getting the codings
    $sql2 = "SELECT * FROM ( SELECT source_id, codes_id, boundaries, name, color, date, sourceCoding.memo FROM sourceCoding INNER JOIN codes ON sourceCoding.codes_id = codes.id ORDER BY codes_id)fusao WHERE source_id=" . $_GET["idImage"];
    $result2 = mysqli_query($conn, $sql2);
     
    //preparing the array with the codings
    echo "<script>\n";
    echo "videojs('my-video', {}, function(){ this.on('loadedmetadata', function(){";
        echo "var listCodings = new Array();\n";
        while($row2 = mysqli_fetch_assoc($result2)) {
            list($begin,$end) = explode(":", $row2["boundaries"]);
            echo "listCodings.push([" . $begin . "," . $end . ",'" . $row2['color'] . "']);\n";
            echo "document.getElementById('abouttheCodes').innerHTML += '<span style=color:" . $row2["color"] . ";>" . $row2["name"] . "</span> (" . $row2["boundaries"] . ") : " . $row2["memo"] . "';";
            echo "document.getElementById('abouttheCodes').innerHTML += ' <a class=deletelink href=doDeleteCoding.php?date=" . str_replace(" ","x",$row2["date"]) . ">[delete code]</a></br>';";
            }
        echo "drawCodings(listCodings, this.duration());});});\n";
    echo "</script>\n";
}

//create the links for navigation among sources
$d = str_replace(" ","x",$row["date"]); //tweaking the string to send by GET
echo "<div></br><span class='fieldname'>Navigate: </span><a href=viewImagewithBites.php?idImage=" . ($row["id"]-1) . ">Previous</a> | <a href=viewImagewithBites.php?idImage=" . ($row["id"]+1) . ">Next</a> | <a href=uploadedTogether.php?date=" . $d . ">Other sources uploaded with this one</a></div>";
    
mysqli_close($conn);
?> 

</div>
</div>

</body>
</html>
