<?php

$localhost = "localhost";
$user = "root";
$password = "";
$bank = "dbw3bcalc";

global $pdo;

try {
    $pdo = new PDO("mysql:host=$localhost;dbname=$bank", $user, $password);
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
    exit();
}

?>
