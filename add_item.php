<!DOCTYPE html>
<html>
<head>
    <title> Add Item </title>
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
        "price",
        "description",
        "unit"
    );
    if (isset($_POST["delete"])) {
        $DB->query("DELETE FROM `items` WHERE `id` = $_POST[delete]");
    }
    if (isset($_POST["update"])) {
        $DB->query("UPDATE `items` SET `name` = '$_POST[name]', `price` = $_POST[price], `description` = '$_POST[description]', `unit` = '$_POST[unit]' WHERE `id` = $_POST[update]");
    }
    if (isset($_POST["formSubmitted"])) {
        $validData = true;
        foreach($columns as $key) {
            if ( ! isset($_POST[$key]) ) {
                echo "<div>Invalid Data ".$key."</div>";
                $validData = false;
                break;
            }
        }
        if ($validData) {
            $entity = new InsertSingleEntity($columns);
            foreach($columns as $columnName) {
                $entity->add($columnName, $_POST[$columnName]);
            }
            if ($DB->insertDataIntoTable("items", $entity)) {
                echo "<div>Successfully Submitted data</div>";
            }
            else {
                echo "<div>Some error occured</div>";
            }
        }
    }

    ?>

    <div class="container">
        <form action="add_item.php" method="POST">
            <label for="name">
                <span>Item Name</span>
                <input type="text" name="name" placeholder="Name" id="name" required/>
            </label>
            <label for="price">
                <span>Item Price</span>
                <input type="number" step="0.01" name="price" placeholder="Price" id="price" required/>
            </label>
            <label for="description">
                <span>Item Description</span>
                <textarea name="description" placeholder="Description here" id="description"></textarea>
            </label>
            <label for="unit">
                <span>Item Unit</span>
                <select type="text" name="unit" id="unit">
                    <option value='pc'>pc</option>
                    <option value='kg'>kg</option>
                </select>
            </label>
            <input type="submit" name="formSubmitted" />
        </form>

            <table>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Stock</th>
                    <th>Unit</th>
                </tr>
                <?php
                    $rows = $DB->fetchDataFromTable("items", ["id", "name", "price", "description", "stock", "unit"], "1");
                    foreach ($rows as $row) {
                ?>
                    <tr>
                        <form action='' method='post'>
                        <td><input name='name' size=25 value='<?php echo $row["name"]; ?>' /></td>
                        <td><input type='number' step='0.01' style='width:107px' name='price' value='<?php echo $row["price"]; ?>' /></td>
                        <td><input name='description' value='<?php echo $row["description"]; ?>' /></td>
                        <td><?php echo $row["stock"]; ?></td>
                        <td>
                            <select type="text" name="unit" id="unit">
                                <option value='pc' <?php echo ($row["unit"]=='pc')?'selected':''; ?>>pc</option>
                                <option value='kg' <?php echo ($row["unit"]=='kg')?'selected':''; ?>>kg</option>
                            </select>
                        </td>
                        <td><button type='submit' name='delete' value='<?php echo $row["id"]; ?>'>Delete</button></td>
                        <td><button type='submit' name='update' value='<?php echo $row["id"]; ?>'>Update</button></td>
                        </form>
                    </tr>
                <?php
                    }
                ?>
            </table>
        </form>
    </div>

</body>
</html>

