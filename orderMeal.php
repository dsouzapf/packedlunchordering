<?php
include_once("session_init.php");
include_once("connection.php");
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Order Meal - Packed Lunch Ordering</title>
        <link rel="stylesheet" href="stylesheet.css">
    </head>

    <body>

        <button onclick="window.location.href='index.php'">Home</button>

        <form action="orderMealRun.php" method="POST">

            <fieldset>

                <legend>Order Meal</legend>

                <!--TODO: mainItem, sideItem, drinkItem, notes-->

                <?php

                class Item {

                    public $id;
                    public $name;

                    function __construct($id, $name) {

                        $this->name = $name;
                        $this->id = $id;

                    }

                }

                /*TAG: change here for new item types*/
                $mainItems = array();
                $sideItems = array();
                $drinkItems = array();

                $getItemsStmt = $connection->prepare("SELECT id,name,stock,itemType FROM itemstock");
                $getItemsStmt->execute();

                while ($row = $getItemsStmt->fetch(PDO::FETCH_ASSOC)) {

                    if ($row["stock"] <= 0) continue;

                    /*TAG: change here for new item types*/
                    switch ($row["itemType"]) {

                        case 0:
                            array_push($mainItems, new Item($row["id"],$row["name"]));
                            break;

                        case 1:
                            array_push($sideItems, new Item($row["id"],$row["name"]));
                            break;

                        case 2:
                            array_push($drinkItems, new Item($row["id"],$row["name"]));
                            break;

                    }

                }
                $getItemsStmt->closeCursor();
                
                ?>

                <!--/*TAG: change here for new item types*/-->

                Main Item: <select name="mainItem">
                <?php
                foreach ($mainItems as $item) {
                    print("<option value=\"" . $item->id . "\">" . $item->name . "</option>");
                }
                ?>
                </select><br>

                Side Item: <select name="sideItem">
                <?php
                foreach ($sideItems as $item) {
                    print("<option value=\"" . $item->id . "\">" . $item->name . "</option>");
                }
                ?>
                </select><br>

                Drink Item: <select name="drinkItem">
                <?php
                foreach ($drinkItems as $item) {
                    print("<option value=\"" . $item->id . "\">" . $item->name . "</option>");
                }
                ?>
                </select><br>

                Notes: <input type="text" name="notes"><br>

                <input type="submit">

            </fieldset>

        </form>

    </body>

</html>