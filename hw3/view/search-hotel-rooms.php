<!DOCTYPE html>

<meta charset="UTF-8" />
<title>Hotel room search</title>

<h1></h1>



<label>Search: <input id="search-field" type="text" name="query" autocomplete="off" autofocus /></label>
<ul id="room-hits"></ul>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $("#search-field").keyup(function () {
        const url = "<?= BASE_URL . "/hotel/room/search" ?>";
        $.get(url,
            {
                query : $(this).val()
            },
            function(data) {
                $("#room-hits").empty();
                //for some reason the data was already in recognised as json Objects and parsing caused errors
                try {
                        //data = JSON.parse(data);
                    }
                    catch (ignored) {
                    }
                for(const room of data) {
                    console.log(room);
                    let item = `<li><a href= <?= BASE_URL?>/hotel/room?rid=${room.rid}> ${room.name} ${room.price} )</a></li>`;
                    $("#room-hits").append(item);
                }
            }
        );
    });

});
</script>