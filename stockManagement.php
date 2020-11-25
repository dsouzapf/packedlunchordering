<?php
include_once("session_init.php");
include_once("connection.php");
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Edit Stock - Packed Lunch Ordering</title>
        <link rel="stylesheet" href="stylesheet.css">
    </head>

    <body>

        <!--TODO: display current stock levels-->

        <form action="editStockRun.php" method="POST">

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

        </form>

        <form action="addStockItemRun.php" method="POST">

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

    </body>

</html>