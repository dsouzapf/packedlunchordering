<?php

function checkUserPermission($connection, $permName) {

    $permCheckStmt = $connection->prepare("SELECT $permName FROM roles WHERE roleId=:roleId");
    $permCheckStmt->bindParam(":roleId", $_SESSION["userRole"]);

    $permCheckStmt->execute();

    return $permCheckStmt->fetch(PDO::FETCH_ASSOC)[$permName];

}

?>