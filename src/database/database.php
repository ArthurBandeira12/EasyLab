<?php

$host = 'localhost';
$db = 'easylab';
$user = 'root';
$pass = 'root';

try {

    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo 'Falha na conexão: ' . $e->getMessage();
}
?>