<!DOCTYPE html>
<html>
<head>
    <title>Manage payments</title>
    <link href='//fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <meta charset="utf-8" />
    <style>
body {
    font-family: "Raleway", sans-serif;
}

::-webkit-input-placeholder { font-family: "Raleway", sans-serif; }
::-moz-placeholder { font-family: "Raleway", sans-serif; } /* firefox 19+ */
:-ms-input-placeholder { font-family: "Raleway", sans-serif; } /* ie */
input:-moz-placeholder { font-family: "Raleway", sans-serif; }

.container {
    display: inline-block;
}
label, input[type="submit"] {
    display: block;
    margin: 1em;
}
span, textarea {
    vertical-align: top;
}
span {
    display: inline-block;
    width: 150px;
}

input[type="text"], input[type="number"], textarea {
    border: 1px solid #aaa;
    border-radius: 0;
    background: white;
    width: 300px;
    font-size:20px;
}
input[type="text"]:focus, input[type="number"]:focus, textarea:focus {
    border: 1px solid #66AFE9;
    box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset, 0px 0px 8px rgba(102, 175, 233, 0.6);
}
    </style>
</head>
<body>
    <?php

    include("config.php");
    $columns = array(
        "name",
        "address",
        "contact_no"
    );
    if (isset($_POST["done"])) {
        $DB->query("INSERT INTO `payments` (purchase_id) VALUES ($_POST[done])");
    }

function getwholename($id) {
	global $DB;
	$rows = $DB->fetchDataFromTable("wholesalers", ["name"], "id = $id");
	return $rows[0]['name'];
}

    ?>
    <div class="container">

            <table>
                <tr>
                    <th>Name</th>
                    <th>Total</th>
                </tr>
                <?php
                    //$rows = $DB->fetchDataFromTable("purchase p JOIN `wholesalers` ON `wholesalers`.`id` = p.`id`", ["p.id", "name", "( SELECT SUM(e.quantity * e.price) as subtotal FROM purchase_entity as e WHERE e.purchase_id = p.id GROUP BY e.purchase_id ) as total"], "p.id not in (SELECT `id` FROM `payments`)");
                    $rows = $DB->fetchDataFromTable("purchase p", ["id", "wholesaler_id", "( SELECT SUM(e.quantity * e.price) as subtotal FROM purchase_entity as e WHERE e.purchase_id = p.id GROUP BY e.purchase_id ) as total"], "p.id not in (SELECT `purchase_id` FROM `payments`)");
                    foreach ($rows as $row) {
                ?>
                    <tr>
                        <form action='' method='post'>
                        <td><?php echo getwholename($row["wholesaler_id"]); ?></td>
                        <td><?php echo $row["total"]; ?></td>
                        <td><button type='submit' name='done' value='<?php echo $row["id"]; ?>'>Done payment</button></td>
                        </form>
                    </tr>
                <?php
                    }
                ?>
            </table>
    </div>
</body>
</html>
