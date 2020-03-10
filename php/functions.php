<?php
function authUserByEmail(string $email, $pdo)
{
    $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $ret = $pdo->query($query);
    $users = $ret->fetchAll();
    return $users[0] ?? [];
}

function getLastOrderByUserId(string $userId, $pdo)
{
    $query = "SELECT * FROM orders WHERE id_user = '$userId' ORDER BY id DESC LIMIT 1";
    $ret = $pdo->query($query);
    $orders = $ret->fetchAll();
    return $orders[0] ?? [];
}

function getOrdersByUserId(string $userId, $pdo)
{
    $query = "SELECT * FROM orders WHERE id_user = '$userId' LIMIT 1000";
    $ret = $pdo->query($query);
    $orders = $ret->fetchAll();
    return count($orders);
}

function getAllUsers($pdo)
{
    $query = "SELECT * FROM users LIMIT 1000";
    $ret = $pdo->query($query);
    $users = $ret->fetchAll();
    echo "<table><tr>";
    foreach ($users as $item) {
        echo "<td>" . $item['id'] . "</td><td>" . $item['email'] . "</td><td>" . $item['name'] . "</td><td>" . $item['tel'] . "</td></tr>";
    }
    echo "</table>";
}

function getAllOrders($pdo)
{
    $query = "SELECT * FROM orders LIMIT 1000";
    $ret = $pdo->query($query);
    $orders = $ret->fetchAll();
    echo "<table><tr>";
    foreach ($orders as $item) {
        echo "<td>" . $item['id'] . "</td><td>" . $item['street'] . "</td><td>" . $item['house'] . "</td><td>" . $item['block'] . "</td><td>" . $item['appt'] . "</td><td>" . $item['floor'] . "</td><td>" . $item['comment'] . "</td></tr>";
    }
    echo "</table>";
}