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
    <h2>Create a new attribute</h2>

<form method="post" action="addAttribute.php">
<table border=0>
    <tr><td><span class='fieldname'>name</span></td><td><input type="text" id="name" name="name" size="40"></td></tr>
    <tr><td><span class='fieldname'>description:</span></td><td><textarea rows=4 cols=40 id="memo" name="memo" placeholder="Description of the code"></textarea></td></tr>
    <tr><td colspan=2><span class='fieldname'><input type="submit" name="submit" value="Send"></td></tr>
</table>
</form>

</div>

</div>

</body>
</html>