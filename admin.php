<?php
include "php/functions.php";

try {
    $pdo = new PDO('mysql:host=localhost;dbname=db', 'root', 'root');
} catch (PDOException $e) {
    echo $e->getMessage();
    die;
}

echo "<div>Административная панель</div><div>Cписок всех зарегистрированных пользователей:</div>";

getAllUsers($pdo);

echo "<div>Cписок всех заказов:</div>";

getAllOrders($pdo);