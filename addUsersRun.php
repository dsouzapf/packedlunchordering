<?php include_once("session_init.php"); ?>
<!DOCTYPE html>
<html>

<head>
</head>

<body>

<?php

array_map("htmlspecialchars", $_POST);
include_once("connection.php");

$getUsernamesStmt = $connection->prepare("SELECT username FROM users WHERE username=:username");
$getUsernamesStmt->bindParam(":username", $_POST["username"]);
$getUsernamesStmt->execute();

if ($_ = $getUsernamesStmt->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION["addUserFailed"] = true;
        header("Location: addUser.php");
}

$getUsernamesStmt->closeCursor();

//TODO: Find roleId by allowed permissions

$addUserStmt = $connection->prepare(
"INSERT INTO users(userId,roleId,username,passwordHash,houseId)
VALUES (NULL,:roleId,:username,SHA1(:password),:houseId)"
);

$addUserStmt->bindParam(":username", $_POST["username"]);

//TODO: bind roleId once found

$generatedPassword = generatePasswordFromSeed($_POST["passwordSeed"]);
$addUserStmt->bindParam(":passwordHash", $generatedPassword);

$addUserStmt->bindParam(":houseId", $_POST["houseId"]);

$addUserStmt->execute();

$connection=null;

$_SESSION["lastUserUsername"] = $_POST["username"];
$_SESSION["lastUserPassword"] = $generatedPassword;

header("Location: addUser.php");

?>

</body>

</html>