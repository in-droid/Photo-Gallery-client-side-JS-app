<meta charset="UTF-8" />
<title><?= $room["name"] ?></title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<h1>Details about: <?= $room["name"] ?></h1>

<?php if (User::isLoggedIn()): ?>
    <a href="<?= BASE_URL . "user/logout" ?>">Logout (<?= User::getUsername() ?>)</a>
<?php else:?>
    <a href="<?= BASE_URL . "user/login" ?>">Login</a>
<?php endif ?>
<ul>
    <li>Type: <b><?= $room["typeOfRoom"] ?></b></li>
    <li>Price/Night: <b><?= $room["price"] ?> EUR</b></li>
    <li> Hotel : <b> <?= $hotel ?> </b> </li>
</ul>
<?php if(User::isLoggedIn()): ?>

    <button class="reserve">Reserve</button>
    <a href="<?= BASE_URL . "room/period" ?>">Show all rooms</a>
    <?php if(isset($totalPrice) && !empty($totalPrice)): ?>
        <p>Total price: <?= $totalPrice ?> EUR</p>
    <?php endif ?>
<?php else: ?>
    <p><a href="<?= BASE_URL . "user/login" ?>">Login</a> <span> to reserve a room</span></p>
    <a href="<?= BASE_URL . "room" ?>">Show all rooms</a>
<?php endif ?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script type="text/javascript">
$(document).ready(() => {

    const cond = <?= $cond ?>;
    function reserve() {
        $(".reserve").unbind();
        $(".reserve").click(() => {
            $.confirm({
                title: 'Confirm your booking',
                content: 'Are you sure you want to reserve this room from <?= $_SESSION["period"]["start"] ?> to <?= $_SESSION["period"]["end"] ?>',
                buttons: {
                    confirm: function () {
                        makeReservation();
                    }
                }
            });
        });
    }
    function cancel() {
        $(".reserve").html("Cancel reservation");
        $("reserve").unbind();
        $(".reserve").click(() => {
            $.confirm({
                title: 'Cancel reservation',
                content: 'Are you sure you want to cancel your reservation?',
                buttons: {
                    confirm: function () {
                        cancelReservation();
                    }
                }
            });
        });
    }
    if (cond == -10) {
        cancel();
    } else {
        reserve();
    }
    /*
    $(".reserve").click(function () {
        $.confirm({
            title: 'Confirm your booking',
            content: 'Are you sure you want to reserve this room from <#?= $_SESSION["period"]["start"] ?> to <?= $_SESSION["period"]["end"] ?>',
            buttons: {
                confirm: function () {
                    makeReservation();
                }
            }
        });

    });
    */

    function cancelReservation() {
        let searchParams = new URLSearchParams(window.location.search);
        $.post("<?= BASE_URL . "room/cancel" ?>",
            {
                rid : searchParams.get("rid"),
                start : <?= $_SESSION["period"]["start"] ?>,
                end : <?= $_SESSION["period"]["end"] ?>
            },
            function (data) {
                $.alert(data);
                $(".reserve").html("Reserve");
                $(".reserve").unbind();
                $(".reserve").click(makeReservation);

            });
    }


    function makeReservation() {
        let searchParams = new URLSearchParams(window.location.search);
        $.post("<?= BASE_URL . "room/reserve" ?>",
            {
                rid : searchParams.get("rid"),
                start : <?= $_SESSION["period"]["start"] ?>,
                end : <?= $_SESSION["period"]["end"] ?>
            },
            function(data) {
                $.alert(data);
                if(data == "Reservation succesful") {
                    $(".reserve").html("Cancel Reservation");
                    $(".reserve").unbind();
                    $(".reserve").click(cancelReservation);
                }
            });
    }
});
</script>
