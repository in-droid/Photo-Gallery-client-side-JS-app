<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Rooms</title>
</head>
<body>
    <p>Book rooms</p>
    <?php if (User::isLoggedIn()): ?>
	    <a href="<?= BASE_URL . "user/logout" ?>">Logout (<?= User::getUsername() ?>)</a>
        <a href=<?= BASE_URL . "user/reservations" ?>> My reservations</a>
        <a href="<?= BASE_URL . "room/period" ?>">Avilable Rooms</a>
    <?php else:?>
      <a href="<?= BASE_URL . "user/login" ?>">Login</a>
    <?php endif; ?>
    <?php foreach ($rooms as $room): ?>
        <li><a href="<?= BASE_URL . "room?rid=" . $room["rid"] ?>"> <?= $room["name"] ?>:<?= $room["price"] ?></a></li>
    <?php endforeach; ?>
</body>
</html>



















<?php foreach($rooms as $room): ?>
                    <?php if ($i % 3 == 0): ?>
                        <div class="row" id="top-row">
                    <?php endif ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100">
                                <a href="<?= BASE_URL . "room?rid=" . $room["rid"] ?>"><img class="card-img-top" src="https://via.placeholder.com/700x400" alt="..." /></a>
                                <div class="card-body">
                                    <h4 class="card-title"><a href="<?= BASE_URL . "room?rid=" . $room["rid"] ?>"><?= $room["name"] ?></a></h4>
                                    <h5><?= $room["price"] ?> EUR</h5>
                                    <p class="card-text"><?= $room["typeOfRoom"] ?></p>
                                </div>
                            </div>
                        </div>
                        <?php if ($i % 3 == 0 && $i != 0): ?>
                        </div>
                        <?php endif ?>
                        <?php $i+= 1 ?>
                <?php endforeach ?>