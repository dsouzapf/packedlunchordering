<?php

include_once("databaseDetails.php");

try {

    $connection = new PDO("mysql:host=$serverName;dbname=$dbname",
        $username,
        $password);

    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    echo "Connection Failed. Error: " . $e.getMessage();

}

?>