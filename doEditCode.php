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

    $sql = "UPDATE codes SET name='" . $_POST["name"] . "', memo='" . $_POST["memo"] . "', color='" . $_POST["color"] . "' WHERE id=" . $_POST["id"];
    
    if (mysqli_query($conn, $sql)) {
        echo "<h4>Code updated!</h4>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
    ?>
    
    Actions: <a href='viewCodes.php'>Return to the list of codes</a> | <a href='newCode.pph'>Create a new code</a>
    
</div>

</div>

</body>
</html>