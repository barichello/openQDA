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
    //inserindo o atributo na tabela de atributos
    $sql = "INSERT INTO attributes (name, memo) VALUES ('" . $_POST["name"] . "','" . $_POST["memo"] . "')";
    if (mysqli_query($conn, $sql)) {
        echo "<h4>New attribute created successfully!</h4>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    //criando as entradas para esse aributo para todas as imagens
    $lastID = mysqli_insert_id($conn);
    $sql = "SELECT id FROM sources";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $sql2 = "INSERT INTO sourceAttributes (source_id, attributes_id) VALUES ('" . $row["id"] . "','" . $lastID . "')";
            $result2 = mysqli_query($conn, $sql2);
        }
    }

    mysqli_close($conn);
    ?>
</div>

</div>

</body>
</html>


