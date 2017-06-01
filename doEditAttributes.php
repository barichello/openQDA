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
    <?php
    include("connection.php");

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $idAtributos = $_GET['idAttributes'];
    $valores = $_GET['values'];

    foreach( $idAtributos as $i => $a ) {
        $sql = "UPDATE sourceAttributes SET value='" . $valores[$i] . "' WHERE source_id=" . $_GET["idImage"] . " AND attributes_id=" . $a;
        $result = mysqli_query($conn, $sql);
        if (mysqli_affected_rows($conn) != 0) {
            echo "<h4>Attribute updated.</h4>\n";
        }
    }        

    mysqli_close($conn);
    ?> 

<div>
<span class='fieldname'>Navigate: </span> <a href=viewImagewithBites.php?idImage=<?php echo $_GET["idImage"] ?> >Back to source</a> | <a href=viewAttributes.php>View all attributes</a>
</div>
    
</div>
</div>
    
</body>
</html>