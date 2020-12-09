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

/*TAG: change here for new item types*/
$addOrder = $connection->prepare("INSERT INTO orders (orderId,mainItemId,sideItemId,drinkItemId,userId,prepared,notes) VALUES (null,:mainItemId,:sideItemId,:drinkItemId,:userId,0,:notes)");

$addOrder->bindParam(":mainItemId",$_POST["mainItemId"]);
$addOrder->bindParam(":sideItemId",$_POST["sideItemId"]);
$addOrder->bindParam(":drinkItemId",$_POST["drinkItemId"]);
$addOrder->bindParam(":userId",$_SESSION["userId"]);
$addOrder->bindParam(":notes",$_POST["notes"]);

$addOrder->execute();
$addOrder->closeCursor();

/*TAG: change here for new item types*/
foreach (array($_POST["mainItemId"], $_POST["sideItemId"], $_POST["drinkItemId"]) as $itemId) {

    $reduceStmt = $connection->prepare("UPDATE itemstock SET stock=stock-1 WHERE id=:itemId");
    $reduceStmt->bindParam(":itemId",$itemId);
    $reduceStmt->execute();

    $reduceStmt->closeCursor();

}

header("Location: index.php");

?>

</body>

</html>