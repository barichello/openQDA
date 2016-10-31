<html>
<head>
<title>openQDA</title>

<link rel="stylesheet" type="text/css" href="css/main.css">

<script>
function checkImages() {
    var img = new Image();
    var listaNames = document.getElementById("name").value;
    var arrayNomes = listaNames.split(";");
    for (i = 0; i < arrayNomes.length; i++) {
        img.src = "images/" + arrayNomes[i];
        img.style = "visibility: hidden;";
        img.onerror = function() {
            alert("Algum nome de arquivo esta errado");
        }
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
    <h2>Update atribute of several images</h2>

    <form method="post" action="doUpdateAttributesMultipleImages.php">
    <table border=0>
        <tr><td><span class='fieldname'>images:</td><td><input type="text" id="ids" name="ids" size="40" placeholder="Use ; to separate the ids of the images"></td></tr>
        
        <tr><td colspan=2><h2>Atribute</h2></td></tr>
        
        <?php
        include("connection.php");
        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

            // lista de atributos
            $sql = "SELECT id, name FROM attributes";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo "<tr><td><select id='attributes_id' name='attributes_id'>";
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                    }
                echo "</select></td>\n";
                }
            echo '<td><input type="text" id="valueAttribute" name="valueAttribute" size="40" placeholder="New value for the attribute"></td></tr></table>';
            mysqli_close($conn);
            }
            ?> 
            <tr><td colspan=2><input type="submit" name="submit" value="Send"></form></td></tr>
    </table>

</div>

</div>

</body>
</html>


