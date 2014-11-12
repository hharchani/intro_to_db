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
    </div>
</body>
</html>