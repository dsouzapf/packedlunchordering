<?php
include_once("session_init.php");
include_once("connection.php");
include_once("checkUserPermissions.php");
include_once("adminDetails.php");
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Install Page</title>
        <link rel="stylesheet" href="stylesheet.css">
    </head>

    <body>

        <button onclick="window.location.href='index.php'">Home</button>

        <script>
        if (!confirm("Are you sure you want to reset the database?")) { window.location.href="index.php" }
        </script>

        <?php

        $userCanResetDatabase = false;

        if (isset($_SESSION["userRole"])) {

            $userCanResetDatabase = checkUserPermission($connection, "permResetDatabase");

        }

        if (!$userCanResetDatabase || !isset($_SESSION["userRole"])) {
            echo "$userCanResetDatabase<br>";
            //header("Location: index.php");

        }

        ?>

        <?php

        try {

        /*Recreate Database*/
        $connection->exec("DROP DATABASE packedlunchordering");
        $connection->exec("CREATE DATABASE packedlunchordering");
        $connection->exec("USE packedlunchordering");

        /*Create houses table*/
        $connection->exec("CREATE TABLE houses (
            houseId INT(64) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            fullName VARCHAR(32) NOT NULL,
            shortName VARCHAR(32) NOT NULL
        )");

        $connection->exec("INSERT INTO houses (houseId,fullName,shortName) VALUES
        (NULL,\"School\",\"Sch\")");
        $connection->exec("INSERT INTO houses (houseId,fullName,shortName) VALUES
        (NULL,\"Laundimer\",\"Ldr\")");
        $connection->exec("INSERT INTO houses (houseId,fullName,shortName) VALUES
        (NULL,\"Bramston\",\"B\")");

        $connection->exec("INSERT INTO houses (houseId,fullName,shortName) VALUES
        (NULL,\"Sanderson\",\"Sa\")");
        $connection->exec("INSERT INTO houses (houseId,fullName,shortName) VALUES
        (NULL,\"Dryden\",\"D\")");
        $connection->exec("INSERT INTO houses (houseId,fullName,shortName) VALUES
        (NULL,\"New\",\"N\")");

        $connection->exec("INSERT INTO houses (houseId,fullName,shortName) VALUES
        (NULL,\"Scott\",\"Sco\")");
        $connection->exec("INSERT INTO houses (houseId,fullName,shortName) VALUES
        (NULL,\"Berrystead\",\"Be\")");

        $connection->exec("INSERT INTO houses (houseId,fullName,shortName) VALUES
        (NULL,\"Laxton\",\"La\")");

        /*Create itemstock table*/
        $connection->exec("CREATE TABLE itemstock (
            id INT(64) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(32),
            stock INT(64) UNSIGNED NOT NULL,
            itemType INT(2) UNSIGNED NOT NULL
        )");

        /*Create orders table*/
        $connection->exec("CREATE TABLE orders (
            orderId INT(64) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            mainItemId INT(64),
            sideItemId INT(64),
            drinkItemId INT(64),
            userId INT(64) UNSIGNED NOT NULL,
            prepared TINYINT(1) NOT NULL,
            notes TEXT
        )");

        /*Create roles table*/
        /*TAG: Change here for new permissions*/
        $connection->exec("CREATE TABLE roles (
            devToolName VARCHAR(16),
            roleId INT(64) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            permAddUsers TINYINT(1) NOT NULL,
            permSubmitOrders TINYINT(1) NOT NULL,
            permEditStock TINYINT(1) NOT NULL,
            permViewOrders TINYINT(1) NOT NULL,
            permResetDatabase TINYINT(1) NOT NULL
        )");

        /*Create users table*/
        $connection->exec("CREATE TABLE users (
            userId INT(64) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            roleId INT(64) UNSIGNED NOT NULL,
            username VARCHAR(32) NOT NULL,
            passwordHash VARCHAR(40) NOT NULL,
            houseId INT(64) UNSIGNED,
            surname VARCHAR(64) NOT NULL,
            forename VARCHAR(64)
        )");

        /*Add admin role*/
        /*TAG: Change here for new permissions*/
        $connection->exec("INSERT INTO roles
        (devToolName,roleId,permAddUsers,permSubmitOrders,permEditStock,permViewOrders,permResetDatabase)
        VALUES (\"admin\",1,1,1,1,1,1)");

        /*Add admin user*/
        $addAdminUserStmt = $connection->prepare("INSERT INTO users (userId,roleId,username,passwordHash,houseId,surname,forename)
        VALUES (0,1,:username,SHA1(:password),NULL,:surname,NULL)");
        $addAdminUserStmt->bindParam(":username", $adminUsername);
        $addAdminUserStmt->bindParam(":password", $adminPassword);
        $addAdminUserStmt->bindParam(":surname", $adminSurname);

        $addAdminUserStmt->execute();
        
        print("<h2>Database Reset</h2>");
        session_destroy();

        } catch (Exception $e) {

            print("<h2>Failed to Reset Database:</h2><br>");
            print($e->getMessage());
            
        }
        
        ?>

    </body>

</html>