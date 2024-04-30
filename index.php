<?php
    include("src/functions.php");

    $db = dbConnect();
    $itemTable = getTables($db);
    $itemColumns = getColumnName($db,"tea");
    $itemColumns = array_slice($itemColumns, 1);
    //echo '<pre>' . var_export($itemColumns, true) . '</pre>';

    $conAll = getAllItemNames($db, "concentrate");
    $conItems = array();
    foreach ($conAll as $tableItems) {
        $item = $tableItems["name"];
        array_push($conItems, $item);
    }

    $nonAll = getAllItemNames($db, "non_ingd");
    $nonItems = array();
    foreach ($nonAll as $tableItems) {
        $item = $tableItems["name"];
        array_push($nonItems, $item);
    }

    $powAll = getAllItemNames($db, "powder");
    $powItems = array();
    foreach ($powAll as $tableItems) {
        $item = $tableItems["name"];
        array_push($powItems, $item);
    }

    $teaAll = getAllItemNames($db, "tea");
    $teaItems = array();
    foreach ($teaAll as $tableItems) {
        $item = $tableItems["name"];
        array_push($teaItems, $item);
    }

    $topAll = getAllItemNames($db, "topping");
    $topItems = array();
    foreach ($topAll as $tableItems) {
        $item = $tableItems["name"];
        array_push($topItems, $item);
    }

    //echo '<pre>' . var_export($conItems, true) . '</pre>';


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="Xavier Huang" />
        <title>RRT Database</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/rrt_logo.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">Database Home</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">

                            <a class="nav-link active" aria-current="page" href="https://www.rabbitrabbitteahi.com/" target="_BLANK">RRT Website</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page content-->
        <div class="container">
            <div class="text-center mt-5">
                <h1>Rabbit Rabbit Tea Hawaii Database</h1>
            </div>

            <div class="text-center mt-5">
                <h2>View Database Items</h2>
            </div>
            <form action="results.php" method="GET" style="margin-top: 30px">
                <div class="mg-3 row">
                    <div class="col"> <!--Inventory Dropdown-->
                        <label for="item" class="form-label">Inventory</label>
                        <select name="item" class="form-select">
                            <option value="all" selected>All Items</option>
                            <?php
                                foreach ($itemTable as $item) {
                                    $cat = $item['TABLE_NAME'];
                                    if ($cat == "non_ingd") {
                                        echo "<option value='$cat'>Non Ingredients</option>";
                                    } else {
                                        echo "<option value='$cat'>". ucfirst($cat). "</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div> <!--Inventory Dropdown End-->

                    <div class="col"> <!--Order Dropdown-->
                        <label for="itemOrder" class="form-label">Sort By</label>
                        <select name="itemOrder" class="form-select">
                            <?php
                                foreach ($itemColumns as $column) {
                                    $col = $column['COLUMN_NAME'];
                                    if ($col == "exp_date") {
                                        echo "<option value='$col'>Experation Date</option>";
                                    } else {
                                        echo "<option value='$col'>". ucfirst($col). "</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div> <!--Order Dropdown End-->

                    <div class="col"> <!--ASC or DEC Dropdown-->
                        <label for="orderLogic" class="form-label">Sort Type</label>
                        <select name="orderLogic" class="form-select">
                            <option value="asc">Ascending</option>
                            <option value="desc">Descending</option>
                        </select>
                    </div> <!--Order Dropdown End-->
                    <button type="submit" class="btn btn-primary btn-lg" style="margin-top:15px;margin-bottom:15px">View Item</button>
                </div>
            </form>

<!-- UPDATE DATABASE SHITS-->
            <div class="text-center mt-5">
                <h2>Update Database</h2>
            </div>
            <form action="update.php" method="POST" style="margin-top: 30px">
                <div class="mg-3 row">
                    <div class="col"> <!--Table-->
                        <label for="table" class="form-label">Inventory</label>
                        <select name="table" class="form-select" id="tableDropdown" onchange="dynamicdropdown(this.options[this.selectedIndex].value);" required>
                            <option selected>Choose Table...</option>
                            <?php
                                foreach ($itemTable as $item) {
                                    $cat = $item['TABLE_NAME'];
                                    if ($cat == "non_ingd") {
                                        echo "<option value='$cat'>Non Ingredients</option>";
                                    } else {
                                        echo "<option value='$cat'>". ucfirst($cat). "</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div> <!--Table Dropdown End-->
                    
                    <div class="col"> <!--Item Dropdown-->
                        <label for="item" class="form-label">Table Items</label>
                        <select name="item" class="form-select" id="updateItem">
                            <option selected>Choose item...</option>
                        </select>
                    </div> <!--Item Dropdown End-->

                    <div class="col"> <!--Catagory Dropdown-->
                        <label for="column" class="form-label">Catagory</label>
                        <select name="column" class="form-select">
                            <?php
                                foreach ($itemColumns as $column) {
                                    $col = $column['COLUMN_NAME'];
                                    if ($col == "exp_date") {
                                        echo "<option value='$col'>Experation Date</option>";
                                    } else {
                                        echo "<option value='$col'>". ucfirst($col). "</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div> <!--Catagory Dropdown End-->

                    <div class="col"> <!--Text Field-->
                        <label for="data" class="form-label">Change Value</label>
                        <input type="text" name="data" class="form-control" id="updateValue" placeholder="Change item value here">
                    </div> <!--Text Field End-->
                <button type="submit" class="btn btn-primary btn-lg" style="margin-top:15px;margin-bottom:15px">Update Inventory</button>
            </form>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script>


            function validateForm() {
                let x = document.forms["myForm"]["fname"].value;
                if (x == "") {
                alert("Field must be filled out");
                return false;
                }
            }

            function doHTML(list){
                console.log("In doHTML");

                let string ="";
                list.forEach(element => {
                string += `<option value="${element}">${element}</option>`;
                
                });
                console.log(string);
                return string;
            }

            function dynamicdropdown(tableDropdown){
                console.log("In dynamicdropdown");
                
                let conItems = <?php echo json_encode($conItems); ?>;
                let nonItems = <?php echo json_encode($nonItems); ?>;
                let powItems = <?php echo json_encode($powItems); ?>;
                let teaItems = <?php echo json_encode($teaItems); ?>;
                let topItems = <?php echo json_encode($topItems); ?>;

                let genDropdown = document.getElementById("itemUpdate");
                if(tableDropdown=="concentrate"){
                    updateItem.innerHTML = doHTML(conItems);
                }
                if(tableDropdown=="non_ingd"){
                    updateItem.innerHTML = doHTML(nonItems);
                }
                if(tableDropdown=="powder"){
                    updateItem.innerHTML = doHTML(powItems);
                }
                if(tableDropdown=="tea"){
                    updateItem.innerHTML = doHTML(teaItems);
                }
                if(tableDropdown=="topping"){
                    updateItem.innerHTML = doHTML(topItems);
                }
            }
        </script>
    </body>
</html>
