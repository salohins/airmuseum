<?php

require "config.php";

$filename = __DIR__ . "/db/nvm2.sqlite";
$dsn = "sqlite:$filename";

try {
    $db = new PDO($dsn);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOEXCEPTION $e) {
    echo "Failed to connect to the database using DSN:<br>$dsn<br>";
    throw $e;
}

