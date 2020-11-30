<?php
include_once("session_init.php");
include_once("connection.php");
include_once("checkUserPermissions.php");
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Packed Lunch Ordering</title>
        <link rel="stylesheet" href="stylesheet.css">
    </head>

    <body>
        
        <div class="currentUserDisplay" style="display:<?php print(isset($_SESSION["userId"])  ? "inline-block" : "none") ?>;">

            <p>Logged in as: 
            <?php print($_SESSION["username"]) ?>
            </p>

            <button onclick="window.location.href='logoutRun.php'">Log Out</button>

        </div>

        <div class="notLoggedInDisplay" style="display:<?php print(isset($_SESSION["userId"])  ? "none" : "inline-block") ?>;">

            <p>Not logged in</p>
            <button onclick="window.location.href='login.php'">Log In</button>

        </div>

        <?php

        $canAddUsers = checkUserPermission($connection, "permAddUsers") == 1;

        if ($canAddUsers) {
        
            print("
        <div id=\"indexAddUsersDiv\">
            <button onclick=\"window.location.href='userManagement.php'\">User Management</button>
        </div>
        ");

        }

        ?>

        <!--TODO: button to stock editing-->
        <!--TODO: button to meal ordering-->

        <!--TODO: display ordered meals for user-->

    </body>

</html>