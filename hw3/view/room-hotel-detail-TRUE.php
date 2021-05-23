<meta charset="UTF-8" />
<title><?= $room["name"] ?></title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<h1>Details about: <?= $room["name"] ?></h1>
<h2> Hotel : <b> <?= $hotel ?> </b> </h2>

<?php if (User::isLoggedIn()): ?>
    <a href="<?= BASE_URL . "user/logout" ?>">Logout (<?= User::getUsername() ?>)</a>
<?php else:?>
    <a href="<?= BASE_URL . "user/login" ?>">Login</a>
<?php endif ?>
<ul>
    <li>Type: <b><?= $room["typeOfRoom"] ?></b></li>
    <li>Price/Night: <b><?= $room["price"] ?> EUR</b></li>
</ul>
<?php if(User::isLoggedIn()): ?>
    <a href="<?= BASE_URL . "hotel" ?>">Show all rooms</a>
    <p><a href="<?= BASE_URL . "hotel/room/edit?rid=" . $_GET["rid"] ?>">Edit room</a></p>
<?php endif ?>
<?php foreach($reservations as $reservation): ?>
    <p><?= $reservation["username"] ?>&nbsp;&nbsp;&nbsp;&nbsp; <span><b><?= $reservation["fromDate"] ?> - <?= $reservation["toDate"] ?></b></span></p>
<?php endforeach ?>
