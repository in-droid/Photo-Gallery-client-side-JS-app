<!DOCTYPE html>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<meta charset="UTF-8" />
<title>Edit room</title>

<h1>Edit room</h1>
<?php foreach($errors as $error): ?>
    <p><?= $error ?></p>
<?php endforeach ?>
<form action="<?= BASE_URL . "hotel/room/edit" ?>" method="POST">
    <input type="hidden" name="rid" value="<?= $room["rid"] ?>"  />
    <p><label>Name: <input type="text" name="name" value="<?= $room["name"] ?>" autofocus  required/></label></p>
    <p><label>Type: <input list="types" name="typeOfRoom" value="<?= $room["typeOfRoom"] ?>"  required/></label></p>
    <datalist id="types">
        <option value="Single">
        <option value="Double">
        <option value="Triple">
        <option value="Quad">
        <option value="King sized">
    </datalist>
    <p><label>Price: <input type="number" name="price" value="<?= $room["price"] ?>"/ required></label></p>
    <p><button>Update record</button></p>
</form>

<form action="<?= BASE_URL . "hotel/room/delete" ?>" method="post">
    <input type="hidden" name="rid" value="<?= $room["rid"] ?>"  />
    <label>Delete? <input type="checkbox" name="delete_confirmation" /></label>
    <button type="submit" class="important">Delete record</button>
</form>