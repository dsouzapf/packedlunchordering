<?php

/*TAG: Change here for new permissions*/
function getOrMakeRoleIdByPermissions($connection,
$permAddUsers,
$permSubmitOrders) {

    /*TAG: Change here for new permissions*/
    $findStmt = findRoleIdByPermissions($connection, $permAddUsers, $permSubmitOrders);

    if ($row = $findStmt->fetch(PDO::FETCH_ASSOC)) { /*Use found matching role*/

        return $row["roleId"];

    } else { /*Create new role*/

        /*TAG: Change here for new permissions*/
        $createRoleStmt = $connection->prepare("INSERT INTO roles
        (roleId,permAddUsers,permSubmitOrders)
        VALUES (NULL,:permAddUsers,:permSubmitOrders)");

        /*TAG: Change here for new permissions*/
        $createRoleStmt->bindParam(":permAddUsers", $permAddUsers);
        $createRoleStmt->bindParam(":permSubmitOrders", $permSubmitOrders);

        $createRoleStmt->execute();

        /*TAG: Change here for new permissions*/
        $findStmt = findRoleIdByPermissions($connection, $permAddUsers, $permSubmitOrders);

        $row = $findStmt->fetch(PDO::FETCH_ASSOC);

        return $row["roleId"];

    }

    $connection = null;

}

/*TAG: Change here for new permissions*/
function findRoleIdByPermissions($connection,
$permAddUsers,
$permSubmitOrders) {

    /*TAG: Change here for new permissions*/
    $findStmt = $connection->prepare("SELECT roleId FROM ROLES WHERE
    permAddUsers=:permAddUsers AND
    permSubmitOrders=:permSubmitOrders");

    /*TAG: Change here for new permissions*/
    $findStmt->bindParam(":permAddUsers",$permAddUsers);
    $findStmt->bindParam(":permSubmitOrders",$permSubmitOrders);

    $findStmt->execute();

    return $findStmt;

}

?>