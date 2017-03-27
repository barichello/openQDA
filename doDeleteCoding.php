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
        die("Connection failed: " . mysql_error());
    }

    //deleting coding
    $d = str_replace("x"," ",$_GET["date"]);
    $sql = "DELETE FROM sourceCoding WHERE date='" . $d . "'";

    if (mysqli_query($conn, $sql)) {
        echo "<h4>Coding removed.</h4>";
        $last_id = mysqli_insert_id($conn);
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
        
    mysqli_close($conn);
    
    echo "Actions: <a href='viewImagewithBites.php?idImage='" . $_GET["id"] . ">Return to image</a>";
    
    ?>
    
</div>

</div>
    
</body>
</html>
