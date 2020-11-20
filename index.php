<?php include_once("session_init.php"); ?>
<!DOCTYPE html>
<html>

    <head>
        <title>Packed Lunch Ordering</title>
        <link rel="stylesheet" href="stylesheet.css">
    </head>

    <body>

        <!--Display current user-->
        <div id="currentUserDisplay" display="<?php print(isset($_SESSION["userId"])  ? "default" : "none") ?>">
        <p>Logged in as: 
        <?php print($_SESSION["username"]) ?>
        </p>
        </div>

        <!--Links to pages if availible to user-->

    </body>

</html>