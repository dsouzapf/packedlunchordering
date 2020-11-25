<?php include_once("session_init.php"); ?>
<!DOCTYPE html>
<html>

<head>
</head>

<body>

<?php

session_destroy();

header("Location: login.php");

?>

</body>

</html>