<?php
include_once("session_init.php");
include_once("passwordGeneration.php");
include_once("findRoleId.php");
include_once("connection.php");
?>
<!DOCTYPE html>
<html>

<head>
</head>

<body>

<?php

array_map("htmlspecialchars", $_POST);

$getUsernamesStmt = $connection->prepare("SELECT username FROM users WHERE username=:username");
$getUsernamesStmt->bindParam(":username", $_POST["username"]);
$getUsernamesStmt->execute();

if ($_ = $getUsernamesStmt->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION["addUserFailed"] = true;
        header("Location: addUser.php");
}

$getUsernamesStmt->closeCursor();

/*TAG: Change here for new permissions*/
$foundRoleId = getOrMakeRoleIdByPermissions($connection,
$_POST["permAddUsers"] == true,
$_POST["permSubmitOrders"] == true,
$_POST["permEditStock"] == true,
false /*Only the admin should have permission to reset the database*/
);

$addUserStmt = $connection->prepare(
"INSERT INTO users(userId,roleId,username,passwordHash,houseId,surname,forename)
VALUES (NULL,:roleId,:username,SHA1(:password),:houseId,:surname,:forename)"
);

$addUserStmt->bindParam(":roleId", $foundRoleId);

$addUserStmt->bindParam(":username", $_POST["username"]);

$generatedPassword = generatePasswordFromSeed($_POST["passwordSeed"]);
$addUserStmt->bindParam(":password", $generatedPassword);

$addUserStmt->bindParam(":houseId", $_POST["houseId"]);

$addUserStmt->bindParam(":surname",$_POST["surname"]);

$addUserStmt->bindParam(":forename",$_POST["forename"]);

$addUserStmt->execute();

$connection=null;

$_SESSION["lastUserUsername"] = $_POST["username"];
$_SESSION["lastUserPassword"] = $generatedPassword;

header("Location: userManagement.php");

?>

</body>

</html>