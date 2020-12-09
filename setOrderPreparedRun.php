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

array_map("htmlspecialchars", $_GET);

$orderId = $_GET["orderId"];
$state = $_GET["state"] == "true" ? 1 : 0;

$updateStmt = $connection->prepare("UPDATE orders SET prepared=:state WHERE orderId=:orderId");
$updateStmt->bindParam(":orderId", $orderId);
$updateStmt->bindParam(":state", $state);

$updateStmt->execute();

header("Location: viewOrders.php");

?>

</body>

</html>