<!DOCTYPE html>
<html>
<head>
    <title>Purchase</title>
    <link href='//fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <meta charset="utf-8" />

    <script src="/jquery.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <style>
body {
    font-family: "Raleway", sans-serif;
    padding-bottom:2em;
}

::-webkit-input-placeholder { font-family: "Raleway", sans-serif; }
::-moz-placeholder { font-family: "Raleway", sans-serif; } /* firefox 19+ */
:-ms-input-placeholder { font-family: "Raleway", sans-serif; } /* ie */
input:-moz-placeholder { font-family: "Raleway", sans-serif; }

.item.form-group input.form-control[disabled], .total-quantity.form-control[disabled] {
    background-color: #fff;
}
.flash {
    position: fixed;
    top:2em;
    right: 0;
    padding: 2em;
    font-size:1.2em;
    color:#fff;
    z-index:1000;
    opacity: 1;
    transition: opacity 0.4s ease 0.1s;
    background: black;
    box-shadow: 7px 7px 0 3px #666;
    animation: fadeAndGo 5s linear 1;
    transform-origin: 100% 0;
    opacity:0;
    transform:rotate(180deg);
}
.flash:hover {
    opacity: 0.3;
    transition: opacity 0.3s;
}
@keyframes fadeAndGo {
    0%   {opacity:0; transform:rotate(0deg); right:2em}
    40%  {opacity:1; transform:rotate(0deg);right:0;}
    80%  {opacity:1; right:0;}
    100% {opacity:0; transform:rotate(180deg);right:0;}
}
#add-more-items:focus, .remove.btn:focus {
    transform: scale(1.3);
    outline: none;
}

    </style>
</head>
<body>
    <?php

    include("config.php");

    if ( isset($_POST["formSubmitted"]) ) {
        if ( isset($_POST["wholesaler_id"]) && isset($_POST["items"]) ) {
            $lastId =
            $DB->insertDataIntoTable("purchase",
                (new InsertSingleEntity())
                ->add("wholesaler_id", $_POST["wholesaler_id"])
                ->add("discount", (float)($_POST["discount"]) )
                ->add("taxrate", (float)$_POST["taxrate"])
            )->insert_id;

            $items = $_POST["items"];
            $quantity = $_POST["quantity"];
            $price = $_POST["price"];
            $entity = new InsertMultiEntity("purchase_id", "item_id", "quantity", "price");
            $c = count($items);
            for($i=0; $i < $c; $i++) {
                $entity->add($lastId, $items[$i], $quantity[$i], $price[$i]);
                $DB->query("UPDATE `items` SET `stock`=`stock`+".$quantity[$i]." WHERE `id`=".$items[$i]);
            }
            $DB->insertDataIntoTable("purchase_entity", $entity);
            
            echo "<div class='flash'>Successfully submitted data</div>";
        }
        else {
            die("Invalid data.");
        }
    }

    ?>
    <div class="container">
        <h2>Add a purchase</h2>
        <form action="purchase.php" class="form-horizontal" method="POST">
            <div id="wholesaler-wrapper">
                <select type="text" id="wholesaler_name" class="form-control" placeholder="Wholesaler's Name" name="wholesaler_id" required>
                    <?php
                        $rows = $DB->fetchDataFromTable("wholesalers", ["id", "name"], "1");
                        foreach ($rows as $row) {
                            echo "<option value='$row[id]'>$row[name]</option>";
                        }
                    ?>
                </select>
            </div>
            <br>
            <div id="item-group">
                <div class="item form-group">
                    <div class="col-sm-4">
                        <select  class="form-control" name='items[]' type="text" placeholder="Item name" onchange="itemchange(this)" required>
                            <?php
                                $rows = $DB->fetchDataFromTable("items", ["id", "name", "unit", "price"], "1");
                                foreach ($rows as $row) {
                                    echo "<option value='$row[id]' data-unit='$row[unit]'>$row[name] (MRP: $row[price])</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-2"><input class="quantity form-control" type="number" placeholder="Quantity" onchange="total(this);" name="quantity[]" required></div>
                    <div class="col-sm-1"><input class="unit form-control"  type="text"   placeholder="unit" disabled></div>
                    <div class="col-sm-2"><input class="price form-control" type="number" placeholder="Rate" name="price[]" min=1 step=0 onchange="total(this)" required></div>
                    <div class="col-sm-2"><input class="total form-control" type="number" placeholder="Total" disabled></div>
                    <div class="col-sm-1 btn-wrapper">
                        <button class="btn btn-danger remove" type="button"><span class="glyphicon glyphicon-minus"></span></button>
                    </div>
                </div>
            </div>
            <button id="add-more-items" class="btn btn-success" type="button"><span class="glyphicon glyphicon-plus"></span></button>
            <div class="form-group">
                <div class="col-sm-7"></div>
                <div class="col-sm-2 control-label"><label>Discount %</label></div>
                <div class="col-sm-2">
                    <input name="discount" class="total-quantity form-control" type="number" placeholder="Discount %" value="0" step="0.01" min="0" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-7"></div>
                <div class="col-sm-2 control-label"><label>Tax %</label></div>
                <div class="col-sm-2">
                    <input name="taxrate" class="total-quantity form-control" value="0" type="number" placeholder="Tax %" step="0.01" min="0" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-7"></div>
                <div class="col-sm-2 control-label"><label>Grand Total</label></div>
                <div class="col-sm-2">
                    <input class="total-quantity form-control" type="number" placeholder="Grand Total" disabled>
                </div>
            </div>
            <button name="formSubmitted" value="" type="submit" class="btn btn-lg btn-block btn-primary">Done</button>
        </form>
    </div>
    <script>
$(function(){
    $('.btn.remove').click(removeThisRow);
    var ItemTemplate = $('.item').clone();
    var addItems = function() {
        ItemTemplate.hide().clone().appendTo('#item-group').slideDown(200);
    }
    $('#add-more-items').click(addItems);

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
function removeThisRow() {
    $(this).closest(".item").slideUp(200, function(){
        $(this).remove();
    });
}

    </script>
</body>
</html>
