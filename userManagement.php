<?php include_once("session_init.php"); ?>
<?php include_once("connection.php"); ?>
<!DOCTYPE html>
<html>

    <head>
        <title>Add Users - Packed Lunch Ordering</title>
        <link rel="stylesheet" href="stylesheet.css">
    </head>

    <body>

    <div id="addUserLastUser" class="lastUserAddedSign">

        <?php
        if (isset($_SESSION["lastUserUsername"])
        && isset($_SESSION["lastUserPassword"])) {

            echo("<p>Last User:</p>");
            echo("<p>Username: " . $_SESSION["lastUserUsername"] . "</p>");
            echo("<p>Password: " . $_SESSION["lastUserPassword"] . "</p>");

        }
        ?>

    </div>

    <div class="failedSign">

        <?php
        if (isset($_SESSION["addUserFailed"])
        && $_SESSION["addUserFailed"]) {

            echo("<p>Failed to add user</p>");

        }
        ?>

    </div>

        <?php

        $userCanAddUsers = false;

        array_map("htmlspecialchars", $_SESSION);

        if (isset($_SESSION["userRole"])) {

            $canAddStmt = $connection->prepare("SELECT permAddUsers FROM roles WHERE roleId=:roleId");
            $canAddStmt->bindParam(":roleId", $_SESSION["userRole"]);

            $canAddStmt->execute();

            $userCanAddUsers = $canAddStmt->fetch(PDO::FETCH_ASSOC)["permAddUsers"];

        }
        
        if (!$userCanAddUsers || !isset($_SESSION["userRole"])) {
            
            header("Location: index.php");

        }
        
        ?>

        <form action="addUsersRun.php" method="POST">

            Username: <input type="text" name="username"><br>
            Password Seed: <input type="number" name="passwordSeed"><br>

            <!--Have dropdown menu for houses-->
            House:
            <select name="houseId">
            <?php
            
            $getHousesStmt = $connection->prepare("SELECT houseId,fullName FROM houses");

            $getHousesStmt->execute();

            while ($row = $getHousesStmt->fetch(PDO::FETCH_ASSOC)) {

                print("<option value=\"" . $row["houseId"] . "\">" . $row["fullName"] . "</option>");

            }

            ?>
            </select><br>

            <!--/*TAG: Change here for new permissions*/-->
            Can Add Users: <input type="checkbox" name="permAddUsers"><br>
            Can Submit Orders: <input type="checkbox" name="permSubmitOrders"><br>

            <input type="submit">

        </form>

    </body>

</html>