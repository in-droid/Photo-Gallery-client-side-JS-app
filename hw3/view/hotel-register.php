<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="generator" content="Hugo 0.83.1">
    <title>Sign up</title>

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

      #floatingPassword {
          margin-bottom: 0px;
      }

      #submit {
        margin-top: 5px;
        background-color: teal;
      }
      .form-register {
        width: 100%;
        max-height:fit-content;
        max-width: 330px;
        padding: 10px;
        margin: auto;
        margin-top: 5px;
      }
      #hotelName {
        margin-top: 10px;
      }

    </style>
     <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "login.css" ?>">
  </head>
  <body class="text-center">
<main class="form-register">
  <form id="hotelRegister" name="register" action="<?= BASE_URL . "hotel/register"?>" method="POST">
    <?php if (isset($errors) && !empty($errors)): ?>
      <?php foreach($errors as $error): ?>
        <p class="important"><?= $error ?></p>
      <?php endforeach ?>
    <?php endif; ?>
    <a href=<?= BASE_URL . "room" ?>><img src="<?= IMAGES_URL . "home_black_24dp.svg" ?>" alt="Home button"></a>
    <h1 class="h3 mb-3 fw-normal">Register your hotel</h1>
    <p id="p-sign-up">Fast and easy</p>
    <div class="form-floating">
      <input type="text" name="username" class="form-control" id="floatingInput" placeholder="name@example.com" required pattern="[a-zA-Z0-9]+">
      <label for="floatingInput">Username</label>
    </div>
    <div class="form-floating">
      <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
      <label for="floatingPassword">Password</label>
    </div>
    <div class="form-floating">
      <input type="password" name="passwordRepeat" class="form-control" id="floatingPasswordRepeat" placeholder="Password" required>
      <label for="floatingPassword">Repeat Password</label>
    </div>
    <div class="form-floating">
      <input type="text" name="hotel-name" class="form-control" id="hotelName" placeholder="Hotel Name" required pattern="[a-zA-Z ]+">
      <label for="hotelName">Hotel Name</label>
    </div>
    <div class="form-floating">
     <textarea form="hotelRegister" name="hotel-address" id="hotelAddress" placeholder="Hotel Addresss" class="form-control" rows="3" required></textarea>
     <label for="hotelAddress">Hotel Address</label>
    </div>
    <button id="submit" class="w-100 btn btn-lg btn-primary" type="submit">Register</button>
    <p class="mt-5 mb-3 text-muted">&copy;ST 2021</p>
  </form>
</main>
  <script>
      "use strict";
      function checkPasswords() {
        let password = document.forms["register"]["password"].value;
        let passwordRepeat = document.forms["register"]["passwordRepeat"].value;
        if (password != passwordRepeat) {
            document.forms["register"]["password"].setCustomValidity("Passwords must match");
        }
        else {
            document.forms["register"]["password"].setCustomValidity("");
        }
      }

      function checkAddress() {
        let address = document.getElementById("hotelAddress").value;
        address = address.split("\n");
        console.log(address);
        const ta = document.getElementById("hotelAddress");
        let street = address[0];
        console.log(street);
        if (address.length != 3 || isNaN(+address[1])) {
          ta.setCustomValidity("Invalid addresss");
        }
        else {
          ta.setCustomValidity("");
        }

      }

      window.addEventListener("load", () => {
        document.forms["register"]["password"].addEventListener("change", checkPasswords);
        document.forms["register"]["passwordRepeat"].addEventListener("change", checkPasswords);
        document.getElementById("hotelAddress").addEventListener("change", checkAddress);
      });

  </script>
  </body>
</html>