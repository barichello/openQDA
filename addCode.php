<html>
<head>
<title>openQDA</title>

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

    $sql = "INSERT INTO codes (name, memo, color) VALUES ('" . $_POST["name"] . "','" . $_POST["memo"] . "','" . $_POST["color"] . "')";

    if (mysqli_query($conn, $sql)) {
        echo "<h4>New code created!</h4>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
    ?>
</div>

</div>

</body>
</html>