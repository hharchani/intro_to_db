<!DOCTYPE html>
<html>
<head>
    <title>Purchase</title>
    <link href='//fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <meta charset="utf-8" />

    <script src="/jquery.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <style>
body {
    font-family: "Raleway", sans-serif;
}

::-webkit-input-placeholder { font-family: "Raleway", sans-serif; }
::-moz-placeholder { font-family: "Raleway", sans-serif; } /* firefox 19+ */
:-ms-input-placeholder { font-family: "Raleway", sans-serif; } /* ie */
input:-moz-placeholder { font-family: "Raleway", sans-serif; }

.item.form-group input.form-control[disabled] {
    background-color: #fff;
}
    </style>
</head>
<body>
    <?php

    include("config.php");

    if (isset($_POST["formSubmitted"])) {

    }

    ?>
    <div class="container">
        <h2>Add a purchase</h2>
        <form action="purchase.php" class="form-horizontal" method="POST">
            <div id="wholesaler-wrapper">
                <select type="text" id="wholesaler_name" class="form-control" placeholder="Wholesaler's Name">
                    <?php
                        $rows = $DB->fetchDataFromTable("wholesalers", ["id", "name"], "1");
                        foreach ($rows as $row) {
                            echo "<option value='$row[id]'>$row[name]</option>";
                        }
                    ?>
                </select>
                <div id="wholesaler_suggestion"></div>
                <input type="hidden" value="" name="wholesaler_id">
            </div>
            <br>
            <div id="item-group">
                <div class="item form-group">
                    <div class="col-sm-4">
                        <select  class="form-control" type="text" placeholder="Item name" onchange="itemchange(this)">
                            <?php
                                $rows = $DB->fetchDataFromTable("items", ["id", "name", "unit"], "1");
                                foreach ($rows as $row) {
                                    echo "<option value='$row[id]' data-unit='$row[unit]'>$row[name]</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-2"><input  class="quantity form-control" type="number" placeholder="Quantity" onchange="total(this)"></div>
                    <div class="col-sm-1"><input  class="unit form-control" type="text"   placeholder="unit" disabled></div>
                    <div class="col-sm-2"><input  class="price form-control" type="number" placeholder="Rate" name="price" min=1 step=0 onchange="total(this)"></div>
                    <div class="col-sm-2"><input  class="total form-control" type="number" placeholder="Total" disabled></div>
                    <div class="col-sm-1 btn-wrapper">
                        <button class="btn btn-danger" type="button"><span class="glyphicon glyphicon-minus"></span></button>
                    </div>
                </div>
            </div>
            <button id="add-more-items" class="btn btn-success" type="button"><span class="glyphicon glyphicon-plus"></span></button>
        </form>
    </div>
    <script>
$(function(){
    var ItemTemplate = $('.item').clone();
    var addItems = function() {
        ItemTemplate.hide().clone().appendTo('#item-group').slideDown(200);
    }
    $('#add-more-items').click(addItems);
    $('#wholesaler_name').on('keydown', function(){
        $.post("get_suggestions.php", {"suggest_wholesaler":$(this).val()}, function(r){
            console.log(r);
        });
    });
});

function itemchange(sel) {
    sel = $(sel);
    console.log(sel.find(":selected").data('unit'));
    sel.closest(".item").find(".unit").val(sel.find(":selected").data('unit'));
}

function total(sel) {
    sel = $(sel);
    item = sel.closest(".item");
    item.find(".total").val(parseFloat(parseFloat(item.find('.quantity').val()) * parseFloat(item.find('.price').val())));
}
    </script>
</body>
</html>
