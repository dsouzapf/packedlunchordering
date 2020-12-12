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

$getUserPasswordHashStmt = $connection->prepare("SELECT passwordHash FROM users WHERE userId=:userId");
$getUserPasswordHashStmt->bindParam(":userId", $_SESSION["userId"]);

$getUserPasswordHashStmt->execute();

$currentPasswordHash = $getUserPasswordHashStmt->fetch(PDO::FETCH_ASSOC)["passwordHash"];
$newHash = sha1($_POST["newPassword"]);

if ($currentPasswordHash != $newHash) {

    $_SESSION["changePasswordFailedReason"] = "Incorrect current password inputted";
    header("Location: changePassword.php");

}

$setNewPasswordStmt = $connection->prepare("UPDATE users SET passwordHash=:newHash WHERE userId=:userId");
$setNewPasswordStmt->bindParam(":newHash", $newHash);
$setNewPasswordStmt->bindParam(":userId", $_SESSION["userId"]);

$setNewPasswordStmt->execute();

$_SESSION["changePasswordSuccess"] = true;
header("Location: index.php");

?>

</body>

</html>