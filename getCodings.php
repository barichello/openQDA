<?php

include("connection.php");
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//query to get the filename in order to get the size of the image
$sql2 = "SELECT name, type FROM sources WHERE id=" . $_GET["idImage"];
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($result2);
if ($row2['type']=="i") {
    list($width, $height) = getimagesize("sources/" . $row2['name']);
    }

//getting the codings
$sql = "SELECT * FROM ( SELECT source_id, codes_id, boundaries, name, color, date, sourceCoding.memo FROM sourceCoding INNER JOIN codes ON sourceCoding.codes_id = codes.id)fusao WHERE source_id=" . $_GET["idImage"] . 
" ORDER BY codes_id";
$result = mysqli_query($conn, $sql);

$i=0;
while($row = mysqli_fetch_assoc($result)) {
    //image
    if ($row2['type']=="i") {
        //convert the boundaries
        list($x1,$y1,$x2,$y2) = explode(":", $row["boundaries"]);
        //writing to a array
        $arr[$i] = array('date' => $row['date'], 'color' => $row['color'], 'codes_id' => $row['codes_id'], 'name' => $row['name'],'memo' => $row['memo'],'x1' => $x1*800/$width, 'y1' => $y1*800/$width, 'x2' => $x2*800/$width, 'y2' => $y2*800/$width);
    }
    //video
    if ($row2['type']=="v") {
        //convert the boundaries
        list($begin,$end) = explode(":", $row["boundaries"]);
        //writing to a array
        $arr[$i] = array('date' => $row['date'], 'color' => $row['color'], 'codes_id' => $row['codes_id'], 'name' => $row['name'],'memo' => $row['memo'],'begin' => $begin, 'end' => $end);
    }
    $i=$i+1;
}
    
echo json_encode($arr);
?>
