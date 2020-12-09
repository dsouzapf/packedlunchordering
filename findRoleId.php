<?php

/*TAG: Change here for new permissions*/
function getOrMakeRoleIdByPermissions($connection,
$permAddUsers,
$permSubmitOrders,
$permEditStock,
$permResetDatabase) {

    /*TAG: Change here for new permissions*/
    $findStmt = findRoleIdByPermissions($connection, $permAddUsers, $permSubmitOrders, $permEditStock, $permResetDatabase);

    if ($row = $findStmt->fetch(PDO::FETCH_ASSOC)) { /*Use found matching role*/

        return $row["roleId"];

    } else { /*Create new role*/

        /*TAG: Change here for new permissions*/
        $createRoleStmt = $connection->prepare("INSERT INTO roles
        (roleId,permAddUsers,permSubmitOrders,permEditStock,permResetDatabase)
        VALUES (NULL,:permAddUsers,:permSubmitOrders,:permEditStock,:permResetDatabase)");

        /*TAG: Change here for new permissions*/
        $createRoleStmt->bindParam(":permAddUsers", $permAddUsers);
        $createRoleStmt->bindParam(":permSubmitOrders", $permSubmitOrders);
        $createRoleStmt->bindParam(":permEditStock", $permEditStock);
        $createRoleStmt->bindParam(":permResetDatabase", $permResetDatabase);

        $createRoleStmt->execute();

        /*TAG: Change here for new permissions*/
        $findStmt = findRoleIdByPermissions($connection, $permAddUsers, $permSubmitOrders, $permEditStock, $permResetDatabase);

        $row = $findStmt->fetch(PDO::FETCH_ASSOC);

        return $row["roleId"];

    }

    $connection = null;

}

/*TAG: Change here for new permissions*/
function findRoleIdByPermissions($connection,
$permAddUsers,
$permSubmitOrders,
$permEditStock,
$permResetDatabase) {

    /*TAG: Change here for new permissions*/
    $findStmt = $connection->prepare("SELECT roleId FROM ROLES WHERE
    permAddUsers=:permAddUsers AND
    permSubmitOrders=:permSubmitOrders AND
    permEditStock=:permEditStock AND
    permResetDatabase=:permResetDatabase");

    /*TAG: Change here for new permissions*/
    $findStmt->bindParam(":permAddUsers",$permAddUsers);
    $findStmt->bindParam(":permSubmitOrders",$permSubmitOrders);
    $findStmt->bindParam(":permEditStock",$permEditStock);
    $findStmt->bindParam(":permResetDatabase",$permResetDatabase);

    $findStmt->execute();

    return $findStmt;

}

?>