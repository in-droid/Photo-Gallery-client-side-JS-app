<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="generator" content="Hugo 0.83.1">
    <title>Sign in</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      .important {
        color: red;
      }
    </style>
     <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "login.css" ?>">
  </head>
  <body class="text-center">
<main class="form-signin">
  <form action="<?= BASE_URL . "hotel/room/edit"?>" method="POST">
    <?php foreach ($errors as $error): ?>
        <p class="important"><?= $error ?></p>
    <?php endforeach ?>
    <h1 class="h3 mb-3 fw-normal">Edit room</h1>
    <input type="hidden" name="rid" value="<?= $room["rid"] ?>"  />
    <div class="form-floating">
      <input type="text" input type="text" name="name" value="<?= $room["name"] ?>" autofocus  required class="form-control" id="floatingInput">
      <label for="floatingInput">Name</label>
    </div>
    <div class="form-floating">
        <input list="types" id="rType" class="form-control" name="typeOfRoom" value="<?= $room["typeOfRoom"] ?>"  required/>
        <datalist id="types">
            <option value="Single">
            <option value="Double">
            <option value="Triple">
            <option value="Quad">
            <option value="King sized">
        </datalist>
        <label for="rType">Type</label>
    </div>
    <div class="form-floating">
        <input type="number" id="rprice" name="price" class="form-control" value="<?= $room["price"] ?>"/ required>
        <label for="rprice">Price(&euro;)</label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" style="background-color:darkcyan;" type="submit">Update record</button>
  </form>
  <form action="<?= BASE_URL . "hotel/room/delete" ?>" method="post">
    <input type="hidden" name="rid" value="<?= $room["rid"] ?>"  />
    <div class="form-floating" style="margin-top: 20px; display:flexbox;">
        <input type="checkbox" name="delete_confirmation" />
        <button type="submit" class="important">Delete record</button>
    </div>
    
</form>

</main>


  </body>
</html>
