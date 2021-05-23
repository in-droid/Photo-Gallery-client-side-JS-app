
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
                                <a class="nav-link" href="<?= BASE_URL . "hotel" ?>">
                            <?php endif ?>
                                Home
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <?php if (User::isLoggedIn()): ?>
                            <li class="nav-item"><a class="nav-link" href= "<?= BASE_URL . "hotel/room/edit?rid=" . $_GET["rid"] ?>">Edit room</a></li>
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
				</div>
			</div> 
		</div>
		<div class="container-fluid">
			<div class="col-md-12 product-info">
					<ul id="myTab" class="nav nav-tabs nav_tabs">

						<li class="active"><a href="#!" data-toggle="tab">Reservations</a>
				<div id="myTabContent" class="tab-content">
						<div class="tab-pane fade in active" id="service-one">

							<section class="container product-info">
								<h3>Reservations</h3>
                                <ul>
                                <?php foreach($reservations as $reservation): ?>
                                    <li><?= $reservation["username"] ?>&nbsp;&nbsp;&nbsp;&nbsp; <span><b><?= $reservation["fromDate"] ?> - <?= $reservation["toDate"] ?></b></span></li>
                                    <?php endforeach ?>
                                </ul>
						</div>
				</div>
				<hr>
			</div>
		</div>
	</div>
</div>