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

$removalStmt = $connection->prepare("DELETE FROM itemstock WHERE id=:id");
$removalStmt->bindParam(":id",$_GET["id"]);

$removalStmt->execute();

header("Location: stockManagement.php");

?>

</body>

</html>