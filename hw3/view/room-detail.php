
<link rel="stylesheet" href="style.css">

<link href="<?= CSS_URL . "room-detail.css"?>" rel="stylesheet" />
<link href="<?= CSS_URL . "room-list.css"?>" rel="stylesheet" />
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<!------ Include the above in your HEAD tag ---------->
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
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
<div class="container-fluid">
    <div class="content-wrapper">	
		<div class="item-container">	
			<div class="container">	
				<div class="col-md-12">
					<div class="product col-md-3 service-image-left">
					<div class="container service1-items col-sm-2 col-md-2 pull-left">
							<a id="item-1" class="service1-item">
								<img src="http://www.corsair.com/Media/catalog/product/g/s/gs600_psu_sideview_blue_2.png" alt=""></img>
							</a>
					</div>
				</div>
				<div class="col-md-7">
					<div class="product-title"><b><?= $room["name"] ?></b></div>
					<div class="product-desc">Type : <?= $room["typeOfRoom"] ?></div>
					<hr>
					<div class="product-price"><?= $room["price"]?> &euro; / day</div>
                    <?php if(isset($totalPrice) && !empty($totalPrice)): ?>
                        <div class="total-price">Total price:  <?= $totalPrice ?> &euro;</div>
                    <?php endif ?>
					<hr>
                    <?php if(User::isLoggedIn()): ?>
					    <div class="btn-group cart">
						    <button type="button" class="btn btn-success reserve">
							Reserve
						    </button>
					    </div>
                    <?php else: ?>
                        <div class="btn-group cart">
						    <button type="button" disabled class="btn btn-success reserve">
							Login to reserve a room
						    </button>
					    </div>
                    <?php endif ?>
				</div>
			</div> 
		</div>
		<div class="container-fluid">
			<div class="col-md-12 product-info">
					<ul id="myTab" class="nav nav-tabs nav_tabs">
						
						<li class="active"><a href="#service-one" data-toggle="tab">DESCRIPTION</a>
				<div id="myTabContent" class="tab-content">
						<div class="tab-pane fade in active" id="service-one">
						 
							<section class="container product-info">
								<h3>Hotel info</h3>
								<li><b>Name:</b> <?= $hotel["name"] ?></li>
								<li><b>Address:</b><?= $hotel["streetName"] . " " . $hotel["streetNumber"] ?> <?= $hotel["postalCode"] ?> <?= $hotel["city"] ?></li>
						</div>
				</div>
				<hr>
			</div>
		</div>
	</div>
</div>
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
