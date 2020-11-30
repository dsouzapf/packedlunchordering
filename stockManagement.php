<?php
include_once("session_init.php");
include_once("connection.php");
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Stock Management - Packed Lunch Ordering</title>
        <link rel="stylesheet" href="stylesheet.css">
    </head>

    <body>

        <button onclick="window.location.href='index.php'">Home</button><br>

        <form action="editStockRun.php" method="POST" class="inline-block">

            <fieldset>

                <legend>Edit Stock</legend>

                Item: <select name="itemId">
                    <?php

                    $getItemsStmt = $connection->prepare("SELECT id,name FROM itemstock");
                    $getItemsStmt->execute();

                    while ($row = $getItemsStmt->fetch(PDO::FETCH_ASSOC)) {

                        print("<option value=\"" . $row["id"] . "\">" . $row["name"] . "</option>");

                    }

                    ?>
                </select><br>

                Amount to add:<input type="number" name="stockModifier"> (use negative for removal)<br>

                <input type="submit">

            </fieldset>

        </form><br>

        <form action="addStockItemRun.php" method="POST" class="inline-block">

                <fieldset>

                    <legend>Add Stock Item</legend>

                    Item Name: <input type="text" name="name"><br>
                    Initial Stock: <input type="number" name="initialStock"><br>
                    <!--/*TAG: change here for new item types*/-->
                    Item Type: <select name="type">
                        <option value="0">Main</option>
                        <option value="1">Side</option>
                        <option value="2">Drink</option>
                    </select>

                    <input type="submit">

                </fieldset>

        </form>

        <!--TODO: allow item Removal-->
        <table class="sideListDisplay">

                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Stock</th>
                </tr>
                
                <?php

                $getStockStmt = $connection->prepare("SELECT id,name,stock,itemType FROM itemstock");

                $getStockStmt->execute();

                while ($row = $getStockStmt->fetch(PDO::FETCH_ASSOC)) {

                    $itemId = $row["id"];
                    $itemName = $row["name"];
                    $itemStock = $row["stock"];

                    $itemType = "Invalid";
                    /*TAG: change here for new item types*/
                    switch ($row["itemType"]) {

                        case 0:
                            $itemType = "Main";
                            break;

                        case 1:
                            $itemType = "Side";
                            break;

                        case 2:
                            $itemType = "Drink";
                            break;

                    }

                    print("<tr>");
                    print("<td>($itemId)</td>");
                    print("<td>$itemName</td>");
                    print("<td>$itemType</td>");
                    print("<td>$itemStock</td>");
                    print("</tr>");

                }

                $getStockStmt->closeCursor();

                ?>

        </table>

    </body>

</html>