<!DOCTYPE html>

<meta charset="UTF-8" />
<title>Hotel Rooms</title>

<h1><?= $hotelName . " rooms"?></h1>

<p>[ <a href="<?= BASE_URL . "hotel/search" ?>">Search </a> |
<a href="<?= BASE_URL . "hotel/room/add" ?>">Add new</a>
<ul>
    <?php foreach ($rooms as $room): ?>
        <li><a href="<?= BASE_URL . "hotel/room?rid=" . $room["rid"] ?>"> <?= $room["name"] ?>:<?= $room["price"] ?></a></li>
    <?php endforeach; ?>
</ul>