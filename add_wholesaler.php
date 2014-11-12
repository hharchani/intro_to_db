<!DOCTYPE html>
<html>
<head>
    <title> Add Wholesaler </title>
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
    if (isset($_POST["delete"])) {
        $DB->query("DELETE FROM `wholesalers` WHERE `id` = $_POST[delete]");
    }
    if (isset($_POST["update"])) {
        $DB->query("UPDATE `wholesalers` SET `name` = '$_POST[name]', `address` = '$_POST[address]', `contact_no` = '$_POST[contact_no]' WHERE `id` = $_POST[update]");
    }
    if (isset($_POST["formSubmitted"])) {
        $validData = true;
        foreach($columns as $key) {
            if ( ! isset($_POST[$key]) ) {
                echo "<div>Invalid Data</div>".$key;
                $validData = false;
                break;
            }
        }
        if ($validData) {
            $entity = new InsertSingleEntity($columns);
            foreach($columns as $columnName) {
                $entity->add($columnName, $_POST[$columnName]);
            }
            if ($DB->insertDataIntoTable("wholesalers", $entity)) {
                echo "<div>Successfully Submitted data</div>";
            }
            else {
                echo "<div>Some error occured</div>";
            }
        }
    }

    ?>
    <div class="container">
        <form action="add_wholesaler.php" method="POST">
            <label for="name">
                <span>Wholesaler Name</span>
                <input type="text" name="name" placeholder="Name" id="name" required/>
            </label>

            <label for="address">
                <span>Wholesaler's address</span>
                <textarea name="address" placeholder="Address here" id="address"></textarea>
            </label>
            <label for="contact_no">
                <span>Wholesaler contact number</span>
                <input type="number" name="contact_no" placeholder="Contact number" id="contact_no" />
            </label>
            <input type="submit" name="formSubmitted" />
        </form>

            <table>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact No</th>
                </tr>
                <?php
                    $rows = $DB->fetchDataFromTable("wholesalers", ["id", "name", "address", "contact_no"], "1");
                    foreach ($rows as $row) {
                ?>
                    <tr>
                        <form action='' method='post'>
                        <td><input name='name' size=25 value='<?php echo $row["name"]; ?>' /></td>
                        <td><input name='address' size=25 value='<?php echo $row["address"]; ?>' /></td>
                        <td><input type='number' name='contact_no' value='<?php echo $row["contact_no"]; ?>' /></td>
                        <td><button type='submit' name='delete' value='<?php echo $row["id"]; ?>'>Delete</button></td>
                        <td><button type='submit' name='update' value='<?php echo $row["id"]; ?>'>Update</button></td>
                        </form>
                    </tr>
                <?php
                    }
                ?>
            </table>
    </div>
</body>
</html>
