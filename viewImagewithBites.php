<html>
<head>
<title>Pipoca</title>

<link rel="stylesheet" type="text/css" href="css/main.css">

<link href="http://vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
<link rel="stylesheet" href="css/videoplayerskin/polyzor-skin.min.css">

<script src="http://vjs.zencdn.net/5.8.8/video.js"></script>
<script type="text/javascript" src="scripts/jquery.min.js"></script>

<script>
function deleteSource(n) {
    if (confirm("If you delete this source, you will loose all content related to it. Do you want to proceed?")) {
        window.location = "doDeleteSource.php?id=" + n;
        }
    }
</script>

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

//so i can access this info later
echo "<span id='type' style='display: none;'>" . $row["type"] . "</span>";

//actions on the source
echo "<br>\n<span class='fieldname'>actions:</span><a href='editAttributes.php?idImage=" . $_GET["idImage"] . "'>Edit attributes</a> | <a href='applyCodes.php?idImage=" . $_GET["idImage"] . "'>Apply code</a> | <a href='javascript:deleteSource(" . $row["id"] .")'>Delete source</a>\n<br/><br/>\n";

//image
if ($row["type"]=="i") {
    //creating the canvas
    list($width, $height) = getimagesize("sources/" . $row["name"]);
    echo "<canvas id='canvas0' style='margin: 20px 0 20px 0;' width=800 height=" . ($height*800)/$width . "></canvas>\n";
    //drawing the image on the canvas
    echo "<script> var x = document.createElement('img');\n x.src = 'sources/" . $row["name"]  . "';\n";
    echo "document.getElementById('canvas0').getContext('2d').drawImage(x,0,0,800," . $height*(800/$width) . ");\n";
    echo "</script>\n";
    //div for the codings
    echo "<div id='abouttheCodes'></div>";
}

//video
if ($row["type"]=="v") {
    //creating the player
    echo "<video id='my-video' class='video-js vjs-polyzor-skin' controls style='width: 800px; height: 600px;' preload='metadata'><source src='sources/" . $row["name"] . "' type='video/mp4'></video>\n";
    //creating the svg for the codes
    echo "<svg width=800 height=100 id='codes'></svg>\n";
    //div for the codings
    echo "<br><br><div id='abouttheCodes'></div><br>\n";
}

//create the links for navigation among sources
$d = str_replace(" ","x",$row["date"]); //tweaking the string to send by GET
echo "<div></br><span class='fieldname'>Navigate: </span><a href=viewImagewithBites.php?idImage=" . ($row["id"]-1) . ">Previous</a> | <a href=viewImagewithBites.php?idImage=" . ($row["id"]+1) . ">Next</a> | <a href=uploadedTogether.php?date=" . $d . ">Other sources uploaded with this one</a></div>";

mysqli_close($conn);
?>

</div>
</div>

<script>
    $( document ).ready(function() {
        console.log("carregou");
        //requesting
        $.getJSON( "getCodings.php",{idImage:<? echo $_GET['idImage'] ?>}, function(data){
            console.log("requisicao voltou");
            //drawing the codes after the request returns
            //image
            if (document.getElementById('type').innerHTML=="i") {
                console.log("imagem");
                var canvas = document.getElementById('canvas0');
                var ctx = canvas.getContext('2d');
                $.each(data, function(key, value){
                    //creating the rectangles  
                    ctx.strokeStyle = value['color'];
                    ctx.strokeRect(value['x1'], value['y1'], Math.abs(value['x1']-value['x2']), Math.abs(value['y1']-value['y2']));
                    //textual info about the codes
                    document.getElementById('abouttheCodes').innerHTML += '<span style=color:' + value["color"] + ';>' + value["name"] + '</span>: ' + value["memo"];
                    document.getElementById('abouttheCodes').innerHTML += ' <a class=deletelink href=doDeleteCoding.php?date=' + value["date"].replace(" ","x") + '&id=' + <? echo $_GET['idImage'] ?> + '>[delete coding]</a></br>\n';
                });
            }
            //video
            if (document.getElementById('type').innerHTML=="v") {
                console.log("video");
                videojs('my-video', {}, function(){ this.on('loadedmetadata', function(){
                    f = 800/this.duration(); //scale of video's timeline
                    var currentCode = 0;
                    var y0 = 0;
                    $.each(data, function(key, value){
                        if (currentCode != value["codes_id"]) {
                            y0=y0+15;
                            currentCode = value["codes_id"];
                        }
                        //creating the rectangles
                        var rect = document.createElementNS("http://www.w3.org/2000/svg", 'rect');
                        rect.setAttributeNS(null, 'x', f*value["begin"]);
                        rect.setAttributeNS(null, 'y', y0);
                        rect.setAttributeNS(null, 'height', 10);
                        rect.setAttributeNS(null, 'width', f*(value["end"]-value["begin"]));
                        rect.setAttributeNS(null, 'fill', value["color"]);
                        document.getElementById('codes').appendChild(rect);
                        //textual info about the codes                        
                        document.getElementById('abouttheCodes').innerHTML += '<span style=color:' + value["color"] + ';>' + value["name"] + '</span>: ' + value["memo"];
                        document.getElementById('abouttheCodes').innerHTML += ' <a class=deletelink href=doDeleteCoding.php?date=' + value["date"].replace(" ","x") + '&id=' + <? echo $_GET['idImage'] ?> + '>[delete coding]</a></br>\n';
                    }) //end of the each
                    document.getElementById('codes').style.height = y0+10;
                });});
            }
        });
    });
</script>

</body>
</html>
