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
</style>

<script>
function ajax_post(){

    // Create our XMLHttpRequest object
    var hr = new XMLHttpRequest();
    hr.open("POST", "doRetrieve.php", true);
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
    //vars = "string=SELECT DISTINCT * FROM images WHERE images.id IN (select images_id FROM imageAttributes WHERE attributes_id=2 AND value='8 set 4') AND images.id IN (SELECT images_id FROM imageAttributes WHERE attributes_id=1 AND value='Janet')";
    
    //montando a string do mysql
    var comando = "string=SELECT DISTINCT * FROM images"; //basico
    //primeiro os atributos
    var conector = 0;
    var listIds=document.getElementsByName('idAttributes[]');
    var listValues=document.getElementsByName('values[]');
    var i;
    for (i=0; i < document.getElementById("totalA").value; i++) {
        if (listValues[i].value != "") {
            if (conector==0) {
                comando = comando + " WHERE";
                conector = 1;
            } else {
                comando = comando + " AND";
            }
            comando = comando + " images.id IN (SELECT images_id FROM imageAttributes WHERE attributes_id=" + listIds[i].value + " AND value='" + listValues[i].value + "')";
        }
    }
    //agora os codes
    if (document.getElementById("codes_id").value != 'default') {
        if (conector==0) {
            comando = comando + " WHERE";
            conector = 1;
        } else {
            comando = comando + " AND";
        }
        comando = comando + " images.id IN (SELECT images_id FROM imageCoding WHERE codes_id=" + document.getElementById("codes_id").value + ")";
    }
                
    // Actually execute the request
    hr.send(comando);
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

//montando a lista de atributos
$sql = "SELECT * FROM attributes";
$result = mysqli_query($conn, $sql);
echo "<h2>Retrieve images</h2>";
echo "<input type=hidden name='idImage' value='" . $_GET["idImage"] . "'>\n";
$i = 0;
while($row = mysqli_fetch_assoc($result)) {
        echo "<input type=hidden name='idAttributes[]' value='" . $row["id"] . "'>\n<br>";
        echo $row["name"] . " = <input type=text name='values[]' value=''>\n<br>";
        echo "<span class='discrete'>" . $row["memo"] . "</span>\n<br>";
        //getting the values of this attribute
        echo "<span class='discrete'>Values used: ";
        $result2 = mysqli_query($conn, "SELECT DISTINCT value FROM imageAttributes WHERE attributes_id='" . $row["id"] . "'");
        while($row2 = mysqli_fetch_assoc($result2)) {
            echo $row2["value"] . ", ";
        }
        echo "</span>\n<br>";
        $i =$i+1;
    }
//guaradando o total de atributos
echo "<input type=hidden id='totalA' value='" . $i . "'>\n<br>\n";

//montando o seletor de codigos disponiveis
$sql = "SELECT name, id FROM codes";
$result = mysqli_query($conn, $sql);
echo "<h2>Codes</h2>";
echo "<select id='codes_id'>";
echo "<option value='default' selected='selected'>Select a code</option>";
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
    }
}
echo "</select>\n";
mysqli_close($conn);

?>

<br><br><input type=Submit value="Retrieve images" onclick="ajax_post();">
<br>
<div id="result"></div>

</div>
</div>

</body>
</html>