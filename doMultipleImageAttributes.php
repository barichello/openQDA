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

$arrayNomes = explode(';',$_POST["name"]);

foreach ($arrayNomes as $n => $nome) {

        //inserindo a imagem
        $sql = "INSERT INTO images (name, owner, status, memo) VALUES ('" . $nome . "','" . $_POST["owner"] . "', 1, '" . $_POST["memo"] . "')";
        if (mysqli_query($conn, $sql)) {
            echo "<br>New record created successfully!<br>";
            $last_id = mysqli_insert_id($conn);
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        //pegando os atributos e inserindo no banco de dados
        $vetorAtributos = $_POST["atributos"];
        $vetorValorAtributos = $_POST["valorAtributos"];
        foreach ($vetorAtributos as $i => $atributo) {
            if ($vetorValorAtributos[$i]!='') {
                $sql = "INSERT INTO imageAttributes (images_id, attributes_id, value) VALUES ('" . $last_id . "','" . $atributo . "','" . $vetorValorAtributos[$i] . "')";
                if (mysqli_query($conn, $sql)) {
                    echo "Attribute created, ";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
            else {
                $sql = "INSERT INTO imageAttributes (images_id, attributes_id) VALUES ('" . $last_id . "','" . $atributo . "')";
                if (mysqli_query($conn, $sql)) {
                    echo "Attribute created, ";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        }
}
    
mysqli_close($conn);
?>

</div>

</div>
    
</body>
</html>