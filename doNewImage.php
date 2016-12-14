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

//uploading the file
$target_file = "sources/" . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 10000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "mp4" ) {
    echo "Sorry, only JPG, JPEG, PNG & MP4 files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}




//including it in the database
include("connection.php");
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysql_error());
}
//inserting the file
$sql = "INSERT INTO sources (name, owner, status, memo, type) VALUES ('" . $_FILES["fileToUpload"]["name"] . "','" . $_POST["owner"] . "', 1, '" . $_POST["memo"] . "','" . $_POST["type"] . "')";
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
        $sql = "INSERT INTO sourceAttributes (source_id, attributes_id, value) VALUES ('" . $last_id . "','" . $atributo . "','" . $vetorValorAtributos[$i] . "')";
        if (mysqli_query($conn, $sql)) {
            echo "Attribute created, ";
        }
        else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    else {
        $sql = "INSERT INTO sourceAttributes (source_id, attributes_id) VALUES ('" . $last_id . "','" . $atributo . "')";
        if (mysqli_query($conn, $sql)) {
            echo "Attribute created, ";
        }
        else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
mysqli_close($conn);
?>

</div>

</div>
    
</body>
</html>