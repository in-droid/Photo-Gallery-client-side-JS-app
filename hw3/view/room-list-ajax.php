<h1>AJAX Book search</h1>

<?php include("view/menu.php"); ?>

<label>Search: <input id="search-field" type="text" name="query" autocomplete="off" autofocus /></label>
<ul id="book-hits"></ul>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
        const url = "<?= BASE_URL . "/api/book/search" ?>";
        $.get(url,
            {
                query : $(this).val()
            },
            function(data) {
                $("#book-hits").empty();
                //for some reason the data was already in recognised as json Objects and parsing caused errors
                try {
                        data = JSON.parse(data);
                    }
                    catch (ignored) {

                    }
                for(book of data) {
                    let item = `<li><a href= <?= BASE_URL?>book?id=${book.id}> ${book.author} ${book.title} (${book.year})</a></li>`;
                    $("#book-hits").append(item);
                }
            }
        );

});
</script>