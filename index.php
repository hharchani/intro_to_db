<!DOCTYPE html>
<html>
<head>
    <title> Home Page </title>
    <link href='//fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <meta charset="utf-8" />
    <style>
* {
    margin:0;
    padding:0;
    box-sizing:border-box;
}
body {
    background-color:#e9e9e9;
    color:#057cb8;
    font-family: "Raleway", sans-serif;
    text-align:center;
    font-size:1.3em;
    font-weight: 200;
}
h1 { padding: 0.5em; }
h2 { padding: 0.3em; }
.container {
    width:1024px;
    margin:auto;
}
.tile {
    width:50%;
    float:left;
    padding:0.5em;
}
.tile-content {
    background-color:white;
    cursor:pointer;
    padding:2em 3em;
}
@media (max-width: 1024px) {
    .container {
        width:90%;
        margin:auto;
    }
    .tile {
        width:100%;
    }
}
a, a:active, a:link, a:visited {
    outline: none !important;
    text-decoration: none;
    color: inherit;
}
    </style>
</head>
<body>
    <h1>Welcome</h1>
    <h2>What do you want to do?</h2>
    <div class="container">
        <div>
            <?php
                $cat = array(
                    "add_item" => "Add an item",
                    "add_wholesaler" => "Add a Wholesaler",
                    "add_customer" => "Add a Customer",
                    "purchase" => "Purchase",
                    "sale" => "Sale",
                    "purchase_payment" => "Purchase payment",
                );
            
            foreach($cat as $file=>$title)
            echo    '<div class="tile">
                        <a href="'.$file.'.php">
                            <div class="tile-content">
                                '.$title.'
                            </div>
                        </a>
                    </div>';
            ?>
        </div>
    </div>
</body>
</html>