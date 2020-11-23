<?php include_once("session_init.php"); ?>
<!DOCTYPE html>
<html>

<head>
</head>

<body>

<?php

/*TAG: Change here for session user variables*/
$_SESSION["userId"] = null;
$_SESSION["username"] = null;
$_SESSION["userRole"] = null;

header("Location: login.php");

?>

</body>

</html>