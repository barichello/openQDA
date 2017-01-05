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

    $sql = "UPDATE attributes SET name='" . $_POST["name"] . "', memo='" . $_POST["memo"] . "' WHERE id=" . $_POST["id"];
    
    if (mysqli_query($conn, $sql)) {
        echo "<h4>Attribute updated!</h4>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
    ?>
    
    Actions: <a href='viewAttributes.php'>Return to the list of attributes</a> | <a href='newAttribute.pph'>Create a new attribute</a>
    
</div>

</div>

</body>
</html>