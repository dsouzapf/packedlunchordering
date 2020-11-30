<?php

function getItemById($connection, $id) {

    $requestStmt = $connection->prepare("SELECT name FROM itemStock WHERE id=:id");
    $requestStmt->bindParam(":id", $id);
    $requestStmt->execute();

    $row = $requestStmt->fetch(PDO::FETCH_ASSOC);
    $output = $row["name"];

    $requestStmt->closeCursor();

    return $output;

}

?>