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

/*TAG: change here for new item types*/
/*
Item Types:
    0 - Main
    1 - Side
    2 - Drink
*/

array_map("htmlspecialchars", $_POST);


$itemId = $_POST["itemId"];
$stockModifier = $_POST["stockModifier"];

$editStockStmt = $connection->prepare("UPDATE itemstock SET stock=stock+:stockModifier WHERE id=:itemId");

$editStockStmt->bindParam(":itemId",$itemId);
$editStockStmt->bindParam(":stockModifier",$stockModifier);

$editStockStmt->execute();
$editStockStmt->closeCursor();

header("Location: stockManagement.php");

?>

</body>

</html>