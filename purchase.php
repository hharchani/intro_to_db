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
                <input type="text" id="wholesaler_name" class="form-control" placeholder="Wholesaler's Name">
                <div id="wholesaler_suggestion"></div>
                <input type="hidden" value="" name="wholesaler_id">
            </div>
            <br>
            <div id="item-group">
                <div class="item form-group">
                    <div class="col-sm-4"><input  class="form-control" type="text"   placeholder="Item name"></div>
                    <div class="col-sm-2"><input  class="form-control" type="number" placeholder="Quantity"></div>
                    <div class="col-sm-1"><input  class="form-control" type="text"   placeholder="unit" disabled></div>
                    <div class="col-sm-2"><input  class="form-control" type="number" placeholder="Rate" name="price" min=1 step=0></div>
                    <div class="col-sm-2"><input  class="form-control" type="number" placeholder="Total" disabled></div>
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
    </script>
</body>
</html>