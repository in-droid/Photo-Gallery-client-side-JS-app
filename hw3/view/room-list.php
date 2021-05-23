<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Book rooms</title>
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="<?= CSS_URL . "room-list.css"?>" rel="stylesheet" />
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#!">Hotel room booker</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <?php if (User::isLoggedIn()): ?>
                                <a class="nav-link" href="<?= BASE_URL . "room/period" ?>">
                            <?php else: ?>
                                <a class="nav-link" href="<?= BASE_URL . "room" ?>">
                            <?php endif ?>
                                Home
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <?php if (User::isLoggedIn()): ?>
                            <li class="nav-item"><a class="nav-link" href= "<?= BASE_URL . "user/logout"?>">Logout <?= User::getUsername() ?> </a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href= "<?= BASE_URL . "user/login"?>">Login</a></li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page Content-->
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <h1 class="my-4">Book rooms</h1>
                    <?php if(User::isLoggedIn()): ?>
                        <div class="list-group">
                            <a class="list-group-item" href="<?= BASE_URL . "user/reservations" ?>">My reservations</a>
                            <a class="list-group-item" href="<?= BASE_URL . "room/period" ?>">Avilable rooms</a>
                        </div>
                    <?php endif ?>
                </div>
                <div class="col-lg-9">
                    <div class="row" style="margin-top: 15px;">
                    <?php foreach($rooms as $room): ?>
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
                    <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">&copy; ST2021</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
    </body>
</html>
