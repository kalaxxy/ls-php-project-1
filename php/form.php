<?php
include "functions.php";

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

    // пользователь существует
    if (empty($user['id'])) {
        // если нет то создаём
        $insertToUsers = "INSERT INTO users (email, `name`, tel) VALUES ('$email', '$name', '$phone')";
        $retUsers = $pdo->query($insertToUsers);
        // получаем информацию о пользователе
        $user = authUserByEmail($email, $pdo);
    }
    // Добавляем заказ
    $userId = $user['id'];
    $insertToOrders = "INSERT INTO orders (id_user, street, house, `block`, appt, floor, `comment`, payment, `call`) VALUES ('$userId', '$street', '$house', '$block', '$appt', '$floor', '$comment', '$payment', '$call')";
    $retOrders = $pdo->query($insertToOrders);


    $lastOrder = getLastOrderByUserId($userId, $pdo);
    $lastOrderId = $lastOrder['id'];
    $countOrdersByUserId = getOrdersByUserId($userId, $pdo);
    $dateTimeMail = date("d-m-Y-H-i");
    echo $countOrdersByUserId;

    if ($countOrdersByUserId === 1) {
        $countOrders = "<div>Спасибо - это ваш первый заказ!</div>";
    } else {
        $countOrders = "<div>Спасибо! Это уже " . $countOrdersByUserId . " заказ!</div>";
    }

    $mailText = "<h3>Заказ №" . $lastOrderId . "</h3><div>Ваш заказ будет доставлен по адресу: ул. " . $street . "д." . $house . " корп." . $block . " кв." . $appt . " эт." . $floor . "</div><div>Вы заказали: DarkBeefBurger за 500 рублей, 1 шт</div><div>Дополнительно: " . $comment . "</div>" . $countOrders;

    file_put_contents("../mail/" . $dateTimeMail . ".html", $mailText);
}

