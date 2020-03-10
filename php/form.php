<?php
//include "init.php";
try {
    $pdo = new PDO('mysql:host=localhost;dbname=db', 'root', 'root');
} catch (PDOException $e) {
    echo $e->getMessage();
    die;
}

if (!empty($_POST)) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $street = $_POST['street'];
    $house = $_POST['home'];
    $block = $_POST['part'];
    $appt = $_POST['appt'];
    $floor = $_POST['floor'];
    $comment = $_POST['comment'];
    $payment = $_POST['payment'];
    $call = $_POST['callback'];

    $user = authUserByEmail($email, $pdo);


    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    ini_set('ignore_repeated_errors', 0);

    if (!$user) {
        $insertToUsers = "INSERT INTO users (email, `name`, tel) VALUES ('$email', '$name', '$phone')";
        $insertToOrders = "INSERT INTO orders (street, house, `block`, appt, floor, `comment`, payment, `call`) VALUES ('$street' . '$house' . '$block' . '$appt' . '$floor' . '$comment' . '$payment' . '$call')";
        $retUsers = $pdo->query($insertToUsers);
        $retOrders = $pdo->query($insertToOrders);
    } else {
        $userId = $user['id'];
//        echo $userId;
        $insertToOrders = "INSERT INTO orders (id_user, street, house, `block`, appt, floor, `comment`, payment, `call`) VALUES ('$userId' . '$street' . '$house' . '$block' . '$appt' . '$floor' . '$comment' . '$payment' . '$call')";
        $retOrders = $pdo->query($insertToOrders);
    }

}

function authUserByEmail(string $email, $pdo)
{
    $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $ret = $pdo->query($query);
    $users = $ret->fetchAll();
//    print_r($users[0]);
    return $users[0] ?? [];
}

function getLastOrderByUserId(string $userId, $pdo)
{
    $query = "SELECT * FROM orders WHERE id_user = '$userId' ORDER BY id DESC LIMIT 1";
    $ret = $pdo->query($query);
    $orders = $ret->fetchAll();
    return $orders[0] ?? [];
}


