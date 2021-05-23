<!DOCTYPE html>
<?= require_once("controller/UserController.php") ?>
<meta charset="UTF-8" />
<title>Add entry</title>
<style type="text/css">
    .important {
        color: red;
    }
</style>

<h1>Add new room</h1>
<a href="<?= BASE_URL . "user/logout" ?>">Log out</a>
<?php if (isset($errors) && !empty($errors)): ?>
    <?php foreach($errors as $error): ?>
      <p class="important"><?= $error ?></p>
    <?php endforeach ?>
<?php endif; ?>
<form action="<?= BASE_URL . "hotel/room/add" ?>" method="post">
    <label for="type">Type of room</label>
    <input list="types" name="type" id="type" value="<?= $type ?>">
    <datalist id="types">
        <option value="Single">
        <option value="Double">
        <option value="Triple">
        <option value="Quad">
        <option value="King sized">
    </datalist>
    <p><label>Room name: <input type="text" name="name" value="<?= $name ?>" /></label></p>
    <p><label>Price: <input type="number" name="price" value="<?= $price ?>" /></label></p>
    <p><button>Add</button></p>
</form>