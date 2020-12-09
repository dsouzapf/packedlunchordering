<?php
include_once("session_init.php");
include_once("connection.php");
include_once("checkUserPermissions.php");
include_once("getItemById.php");
?>
<!DOCTYPE html>
<html>

    <head>
        <title>View Orders - Packed Lunch Ordering</title>
        <link rel="stylesheet" href="stylesheet.css">
    </head>

    <body>

        <button onclick="window.location.href='index.php'">Home</button>

        <?php

        if (isset($_SESSION["userRole"])) {

            $userCanViewOrders = checkUserPermission($connection, "permViewOrders");

        }

        if (!$userCanViewOrders || !isset($_SESSION["userRole"])) {
            
            header("Location: index.php");

        }

        ?>

        <!--/*TAG: change here for filter options*/-->

        <!--All filter options should have a default option with value "null"-->

        <div id="viewOrdersFilters">

            House: <select id="selectOrdersFilterByHouse" class="viewOrdersFilterParameter">
                <option value="null" selected>-</option>
            </select>

            Prepared?: <select id="selectOrdersFilterByPrepared" class="viewOrdersFilterParameter">
                <option value="null" selected>-</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>

        </div>

        <script>

        class Order {

            /*TAG: change here for new viewOrder columns*/
            constructor(orderId,
            mainItem,
            sideItem,
            drinkItem,
            userSurname,
            userForename,
            userHouse,
            prepared,
            notes) {
                this.orderId = orderId;
                this.mainItem = mainItem;
                this.sideItem = sideItem;
                this.drinkItem = drinkItem;
                this.userSurname = userSurname;
                this.userForename = userForename;
                this.userHouse = userHouse;
                this.prepared = prepared;
                this.notes = notes;
            }

        }

        var orders = [

        <?php

        /*TAG: change here for new item types*/
        $getOrdersStmt = $connection->prepare("SELECT orders.orderId,orders.mainItemId,orders.sideItemId,orders.drinkItemId,users.surname,users.forename,houses.shortName AS houseShortName,orders.prepared,orders.notes
        FROM orders
            INNER JOIN users
                ON orders.userId=users.userId
            INNER JOIN houses
                ON users.houseId=houses.houseId
        ORDER BY orders.orderId ASC");
        $getOrdersStmt->execute();

        while ($row = $getOrdersStmt->fetch(PDO::FETCH_ASSOC)) {

            /*TAG: change here for new viewOrder columns*/
            
            $orderId = $row["orderId"];
            /*TAG: change here for new item types*/
            $mainItem = getItemById($connection, $row["mainItemId"]);
            $sideItem = getItemById($connection, $row["sideItemId"]);
            $drinkItem = getItemById($connection, $row["drinkItemId"]);
            $userSurname = $row["surname"];
            $userForename = $row["forename"];
            $userHouse = $row["houseShortName"];
            $prepared = $row["prepared"];
            $notes = $row["notes"];
            print("new Order($orderId,\"$mainItem\",\"$sideItem\",\"$drinkItem\",\"$userSurname\",\"$userForename\",\"$userHouse\",$prepared,\"$notes\"),");

        }
        
        $getOrdersStmt->closeCursor();

        ?>
        null
        ];

        orders.pop(); /*Because used comma after every order element so null added at end*/

        </script>

        <table>

            <tr>

                <!--/*TAG: change here for new viewOrder columns*/-->

                <th>Order Id</th>
                <!--/*TAG: change here for new item types*/-->
                <th>Main Item</th>
                <th>Side Item</th>
                <th>Drink Item</th>
                <th>Requester</th>
                <th>House</th>
                <th>Prepared?</th>
                <th>Notes</th>
                <th>Set Prepared</th>
            </tr>

        </table>
        <table id="viewOrdersTable"> </table>

        <script src="viewOrdersScript.js"></script>

    </body>

</html>