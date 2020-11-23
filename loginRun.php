<?php
include_once("session_init.php");
include_once("connection.php");?>
<!DOCTYPE html>
<html>

<head>
</head>

<body>

<?php

array_map("htmlspecialchars", $_POST);

$stmt = $connection->prepare("SELECT * FROM users WHERE username=:username;");
$stmt->bindParam(":username", $_POST["username"]);
$stmt->execute();

$connection = null;

$userObject = $stmt->fetch(PDO::FETCH_ASSOC);
if (strcmp($userObject["passwordHash"], sha1($_POST["password"])) == 0) {


        $_SESSION["loginSucceed"] = true;

        /*TAG: Change here for session user variables*/
        $_SESSION["userId"] = $userObject["userId"];
        $_SESSION["username"] = $userObject["username"];
        $_SESSION["userRole"] = $userObject["roleId"];
        
        header("Location: index.php");

} else {

        $_SESSION["loginSucceed"] = false;
        
        header("Location: login.php");

}

?>

</body>

</html>