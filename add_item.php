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
    /*
    $a = new InsertEntity();
    $a->add("name", "Pears Soap", "s");
    $a->add("price", 25.00, "d");
    $a->add("description", "Pears Soap 250g", "s");
    $a->add("unit", "pc", "s");
    insertDataIntoTable("items", $a);
    */
    $columns = array(
        "name" => "s",
        "price" => "d",
        "description" => "s",
        "unit" =>"s"
    );
    
    if (isset($_POST["formSubmitted"])) {
        $validData = true;
        foreach($columns as $key=>$value) {
            if ( ! isset($_POST[$key]) ) {
                echo "<div>Invalid Data</div>".$key;
                $validData = false;
                break;
            }
        }
        if ($validData) {
            $entity = new InsertEntity();
            foreach($columns as $key=>$value) {
                $entity->add($key, $_POST[$key], $value);
            }
            insertDataIntoTable("items", $entity);
            echo "<div>Successfully Submitted data</div>";
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
                <textarea name="description" placeholder="Description here" id="description" required></textarea>
            </label>
            <label for="unit">
                <span>Item Unit</span>
                <input type="text" name="unit" placeholder="Item unit" id="unit" required/>
            </label>
            <input type="submit" name="formSubmitted" />
        </form>
    </div>
</body>
</html>