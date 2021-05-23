<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "login.css" ?>">
<body class="text-center">
<main class="form-signin">
<?php foreach($errors as $error): ?>
    <p><?= $error ?></p>
<?php endforeach ?>
<h1 class="h3 mb-3 fw-normal">Enter your date of staying</h1>
<form action="<?= BASE_URL . "room/period" ?>" method="POST">
<div class="form-floating">
      <input type="date" name="start" class="form-control" id="start" min="2021-01-01" max="2021-12-31" required>
      <label for="start">From</label>
    </div>
    <div class="form-floating">
      <input type="date" name="end" class="form-control" id="end"  min="2021-01-01" max="2021-12-31" required>
      <label for="end">To</label>
    </div>
    <button type="submit" class="w-100 btn btn-lg btn-primary">Show rooms</button>
</form>
</main>
</body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
    "use strict"
   // const url = "<#?= BASE_URL . "/api/room/check_reservation"?>";

    function setMinMaxDate() {
        let today = new Date();
        let dd = today.getDate();
        let mm = today.getMonth()+1; //January is 0!
        let yyyy = today.getFullYear();
        if(dd < 10) {
            dd='0'+dd;
        }
        if(mm < 10) {
            mm='0'+mm;
        }
        today = yyyy +'-'+ mm +'-'+ dd;
        let max = yyyy + '-12-31';
        dd += 1;
        let tommorow = yyyy +'-'+ mm +'-'+ dd;
        document.getElementById("start").setAttribute("min", today);
        document.getElementById("end").setAttribute("min", tommorow);
        document.getElementById("end").setAttribute('max', max);
    }
    /*
    function checkReservation() {
        const endDate = document.getElementById("end");
        const startDate = document.getElementById("start");
        let searchParams = new URLSearchParams(window.location.search);

        if (startDate.value != "" && endDate.value != "" && searchParams.has("rid")) {
            $.post(url,
                {rid : searchParams.get("rid"),
                start : startDate.value,
                end : endDate.value},
                function (data) {
                    $("#notification").html(data);
                });
        }
    }
    */

    $(document).ready(() => {
        setMinMaxDate();
        //$("#end").change(checkReservation);
      //  $("#start").change(checkReservation);
    });
</script>