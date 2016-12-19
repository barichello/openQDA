<html>
<head>
<title>Pipoca</title>

<link rel="stylesheet" type="text/css" href="css/main.css">

<style>
img {
    float: left;
    margin: 0 20px 10px 0;
    width: 150px;
    }
    
td {
    padding: 5px 5px 15px 5px;
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
    
    //montando a string do mysql
    var comando = "string=SELECT DISTINCT * FROM sources"; //basico
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
            comando = comando + " sources.id IN (SELECT source_id FROM sourceAttributes WHERE attributes_id=" + listIds[i].value + " AND value='" + listValues[i].value + "')";
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
        comando = comando + " sources.id IN (SELECT source_id FROM sourceCoding WHERE codes_id=" + document.getElementById("codes_id").value + ")";
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
echo "<h2>Retrieve sources</h2>";
echo "<input type=hidden name='idImage' value='" . $_GET["idImage"] . "'>\n";
$i = 0;
echo "<table border=0>";
while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>";
        echo "<input type=hidden name='idAttributes[]' value='" . $row["id"] . "'>\n";
        echo "<span class='fieldname'>" . $row["name"] . "</span></td><td><input type=text name='values[]' value=''></td>\n";
        echo "<td><span class='discrete'>" . $row["memo"] . "</span><br>\n";
        //getting the values of this attribute
        echo "<span class='discrete'>Registered values: ";
        $result2 = mysqli_query($conn, "SELECT DISTINCT value FROM sourceAttributes WHERE attributes_id='" . $row["id"] . "'");
        while($row2 = mysqli_fetch_assoc($result2)) {
            echo $row2["value"] . ", ";
        }
        echo "</span></td></tr>\n";
        $i =$i+1;
    }


//total of attributes
echo "<tr><td><input type=hidden id='totalA' value='" . $i . "'>\n";

//montando o seletor de codigos disponiveis
$sql = "SELECT name, id FROM codes";
$result = mysqli_query($conn, $sql);
echo "<span class='fieldname'>Codings</span></td><td colspan=2><select id='codes_id'>";
echo "<option value='default' selected='selected'>Select a code</option>";
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
    }
}
echo "</select></td></tr>\n";
mysqli_close($conn);

?>

<tr><td colspan=3><br/><center><input type=Submit value="Retrieve images" onclick="ajax_post();"></center></td></tr>
</table>
<br>
<div id="result"></div>

</div>
</div>

</body>
</html>