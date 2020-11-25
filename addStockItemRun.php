<?php
include_once("session_init.php");
include_once("connection.php");
?>
<!DOCTYPE html>
<html>

<head>
</head>

<body>

<?php

array_map("htmlspecialchars", $_POST);

$addItemStmt = $connection->prepare("INSERT INTO itemstock (id,name,stock,itemtype) VALUES (NULL,:itemName,:stock,:itemtype)");

$addItemStmt->bindParam(":itemName", $_POST["name"]);
$addItemStmt->bindParam(":stock", $_POST["initialStock"]);
$addItemStmt->bindParam(":itemType", $_POST["type"]);

$addItemStmt->execute();
$addItemStmt->closeCursor();

header("Location: stockManagement.php");

?>

</body>

</html>