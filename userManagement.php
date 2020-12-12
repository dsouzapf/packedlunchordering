<?php
include_once("session_init.php");
include_once("connection.php");
include_once("checkUserPermissions.php");
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Add Users - Packed Lunch Ordering</title>
        <link rel="stylesheet" href="stylesheet.css">
    </head>

    <body>

        <button onclick="window.location.href='index.php'">Home</button>

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

        $userCanAddUsers = false;

        if (isset($_SESSION["userRole"])) {

            $userCanAddUsers = checkUserPermission($connection, "permAddUsers");

        }
        
        if (!$userCanAddUsers || !isset($_SESSION["userRole"])) {
            
            header("Location: index.php");

        }
        
        ?>

        <form action="addUsersRun.php" method="POST" id="addUsersForm" class="inline-block">

            <fieldset>
            <legend>Add User</legend>

            Username: <input type="text" name="username"><br>
            Password Seed: <input type="number" name="passwordSeed"><br>

            <!--Dropdown menu for houses-->
            House:
            <select name="houseId">
            <?php
            
            $getHousesStmt = $connection->prepare("SELECT houseId,fullName FROM houses");

            $getHousesStmt->execute();

            while ($row = $getHousesStmt->fetch(PDO::FETCH_ASSOC)) {

                print("<option value=\"" . $row["houseId"] . "\">" . $row["fullName"] . "</option>");

            }

            $getHousesStmt->closeCursor();

            ?>
            </select><br>

            Surname: <input type="text" name="surname"><br>
            Forename: <input type="text" name="forename"><br>

            <!--/*TAG: Change here for new permissions*/-->
            Can Add Users: <input type="checkbox" name="permAddUsers"><br>
            Can Submit Orders: <input type="checkbox" name="permSubmitOrders"><br>
            Can Edit Stock: <input type="checkbox" name="permEditStock"><br>

            <input type="submit">

            </fieldset>

        </form><br>

        <div id="userManagementLists" class="sideListDisplay">

            <table>

                <tr>
                    <th>(User Id)</th>
                    <th>Role Id</th>
                    <th>Username</th>
                    <th>House</th>
                    <th>Name</th>
                </tr>
            
                <?php
                
                $getUsersStmt = $connection->prepare("SELECT userId,roleId,username,houses.shortName as houseInitials,surname,forename FROM users LEFT OUTER JOIN houses ON users.houseId=houses.houseId");

                $getUsersStmt->execute();
                
                while ($row = $getUsersStmt->fetch(PDO::FETCH_ASSOC)) {

                    $userId = $row["userId"];
                    $roleId = $row["roleId"];
                    $username = $row["username"];
                    $shortName = $row["houseInitials"] != null ? $row["houseInitials"] : "n/a";
                    $surname = $row["surname"];
                    $forename = $row["forename"];
                    $name = $row["forename"] != null ? "$surname, $forename" : $surname;

                    print("<tr>");
                    print("<td>($userId)</td>");
                    print("<td>$roleId</td>");
                    print("<td>$username</td>");
                    print("<td>$shortName</td>");
                    print("<td>$name</td>");
                    print("</tr>");

                }
                
                ?>
            
            </table>

            <table id="userManagementRoleTable">

                <tr>
                    <th>Role Id</th>
                    <!--/*TAG: Change here for new permissions*/-->
                    <th>Add Users</th>
                    <th>Submit Orders</th>
                    <th>Edit Stock</th>
                    <th>View Orders</th>
                </tr>

                <?php
                
                $getRolesStmt = $connection->prepare("SELECT roleId,permAddUsers,permSubmitOrders,permEditStock,permViewOrders FROM roles");

                $getRolesStmt->execute();

                while ($row = $getRolesStmt->fetch(PDO::FETCH_ASSOC)) {

                    $id = $row["roleId"];
                    $addUsers = $row["permAddUsers"] ? "Y" : "N";
                    $submitOrders = $row["permSubmitOrders"] ? "Y" : "N";
                    $editStock = $row["permEditStock"] ? "Y" : "N";
                    $viewOrders = $row["permViewOrders"] ? "Y" : "N";

                    print("<tr>");
                    print("<td>$id</td>");
                    print("<td>$addUsers</td>");
                    print("<td>$submitOrders</td>");
                    print("<td>$editStock</td>");
                    print("<td>$viewOrders</td>");
                    print("</tr>");

                }
                
                ?>

            </table>

        </div>

    </body>

</html>