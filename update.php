<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include("src/functions.php");

    $db = dbConnect();

    $table = $_POST["table"];
    $item = $_POST["item"];
    $column = $_POST["column"];
    $data = $_POST["data"];

    $oldItemInfo = getSingleItemInfo($db, $table, $item);

    updateItem($db, $table, $column, $data, $item);
    $newItemInfo = getSingleItemInfo($db, $table, $item);

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
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="https://www.rabbitrabbitteahi.com/" target="_BLANK">RRT Website</a></li>
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
                <?php
                    $oldItemValue = $oldItemInfo[0]["$column"];
                    $newItemValue = $newItemInfo[0]["$column"];
                    echo "<h2><strong>Update Database Success</strong><br>"
                    ."Affected Table: <strong>$table</strong><br>"
                    ."Affected Column: <strong>$column</strong><br>"
                    ."Updated Item: <strong>$item</strong><br>"
                    ."Updated Value: from <strong>$oldItemValue</strong> to <strong>$newItemValue</strong><br>";
                ?>
                <a href="index.php"><button type="button" class="btn btn-primary btn-lg" style="padding-left:60px;padding-right:60px;margin-bottom:15px;margin-top:35px">Back to Home Page</button></a>
            </div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
