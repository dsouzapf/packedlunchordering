<?php
include_once("session_init.php");
include_once("connection.php");
include_once("checkUserPermissions.php");
include_once("getItemById.php");
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

        <?php

        $canEditStock = checkUserPermission($connection, "permEditStock") == 1;

        if ($canEditStock) {

            print("
        <div id=\"indexEditStockDiv\">
            <button onclick=\"window.location.href='stockManagement.php'\">Stock Management</button>
        </div>
        ");

        }

        ?>

        <?php

        $canSubmitOrders = checkUserPermission($connection, "permSubmitOrders") == 1;

        if ($canSubmitOrders) {
        
            print("
        <div id=\"indexSubmitOrdersDiv\">
            <button onclick=\"window.location.href='orderMeal.php'\">Order Meal</button>
        </div>
        ");

        }

        ?>

        <?php

        $canSubmitOrders = checkUserPermission($connection, "permViewOrders") == 1;

        if ($canSubmitOrders) {

            print("
        <div id=\"indexViewOrdersDiv\">
            <button onclick=\"window.location.href='viewOrders.php'\">View Orders</button>
        </div>
        ");

        }

        ?>

        <table id="orderedMealsTable" class="sideListDisplay">

            <tr>
                <th>Main</th>
                <th>Side</th>
                <th>Drink</th>
                <th>Notes</th>
                <th>Ready?</th>
            </tr>

            <?php
            
            /*TAG: change here for new item types*/
            $getOrderStmt = $connection->prepare("SELECT mainItemId,sideItemId,drinkItemId,prepared,notes FROM orders WHERE userId=:userId");
            $getOrderStmt->bindParam(":userId",$_SESSION["userId"]);
            $getOrderStmt->execute();

            while ($row = $getOrderStmt->fetch(PDO::FETCH_ASSOC)) {

                /*TAG: change here for new item types*/
                $mainName = getItemById($connection, $row["mainItemId"]);
                $sideName = getItemById($connection, $row["sideItemId"]);
                $drinkName = getItemById($connection, $row["drinkItemId"]);

                print("<tr>");

                print("<td>" . $mainName . "</td>");
                print("<td>" . $sideName . "</td>");
                print("<td>" . $drinkName . "</td>");
                print("<td>" . $row["notes"] . "</td>");
                print("<td>" . ($row["prepared"] ? "Ready" : "Not Ready") . "</td>");

                print("</tr>");

            }

            $getOrderStmt->closeCursor();
            
            ?>

        </table>

    </body>

</html>