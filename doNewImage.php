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

//uploading the file
$target_file = "sources/" . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.<br>";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 10000000) {
    echo "Sorry, your file is too large.<br>";
    $uploadOk = 0;
}
// Allow certain file formats
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "JPEG" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "mp4" ) {
    echo "Sorry, only JPG, JPEG, PNG & MP4 files are allowed.<br>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.<br>";
    
// if everything is ok, upload the file and go for the database
} else {

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "<h4>The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.</h4>";
        include("connection.php");
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("Connection failed: " . mysql_error());
        }
        //inserting the file
        $sql = "INSERT INTO sources (name, owner, status, memo, type) VALUES ('" . $_FILES["fileToUpload"]["name"] . "','" . $_POST["owner"] . "', 1, '" . $_POST["memo"] . "','" . $_POST["type"] . "')";
        if (mysqli_query($conn, $sql)) {
            echo "<h4>New record created successfully!</h4>";
            $last_id = mysqli_insert_id($conn);
            //inserting the attributes
            $vetorAtributos = $_POST["atributos"];
            $vetorValorAtributos = $_POST["valorAtributos"];
            if ($vetorValorAtributos.length !== 0) {
                foreach ($vetorAtributos as $i => $atributo) {
                    if ($vetorValorAtributos[$i]!='') {
                        $sql = "INSERT INTO sourceAttributes (source_id, attributes_id, value) VALUES ('" . $last_id . "','" . $atributo . "','" . $vetorValorAtributos[$i] . "')";
                        if (mysqli_query($conn, $sql)==FALSE) {
                            echo "Error when inserting attribute: " . $sql . "<br>" . mysqli_error($conn);
                        }
                    }
                    else {
                        $sql = "INSERT INTO sourceAttributes (source_id, attributes_id) VALUES ('" . $last_id . "','" . $atributo . "')";
                        if (mysqli_query($conn, $sql)==FALSE) {
                            echo "Error when inserting attribute: : " . $sql . "<br>" . mysqli_error($conn);
                        }
                    }
                }
            } //attributes inserted
        } else {
            echo "Error connecting to the database: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


?>

<div>
<span class='fieldname'>Navigate: </span> <a href=newImage.php>Add new source</a> | <a href=viewImages.php>View inserted source</a>
</div>
    
    
</div>

</div>
    
</body>
</html>
