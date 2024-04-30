<?php
// Author - Xavier Huang
function dbConnect(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "rrt_inventory";
    $dbport = 3306;

    try {
        $db = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4;port=$dbport", $username, $password);
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $db;
}

// Building blocks
function createTable($field) {
    echo "<table class='table table-hover table-dark'>
        <thead>
            <tr>
                <th scope='col'>Name</th>
                <th scope='col'>Count</th>
                <th scope='col'>Unit</th>
                <th scope='col'>Type</th>
                <th scope='col'>Experation Date</th>
                <th scope='col'>Vendor</th>
            </tr>
        </thread>
        <tbody>";

    foreach ($field as $col) {
        $items = array(
            $col["name"],
            $col["count"],
            $col["unit"],
            $col["type"],
            $col["exp_date"],
            $col["vendor"],
        );

        echo "<tr>"; 
        foreach ($items as $item) {
            echo "<td>$item</td>";
        }
        echo "</tr>";
    }
    echo "</tbody></table>";
}


function getItemInfo($db, $table, $order, $logic) {
    try {
        $stmt = $db->prepare("SELECT name, count, unit, type, exp_date, vendor FROM $table ORDER BY $order $logic;");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
        echo $e;
    }
    return $rows;

}

function getSingleItemInfo($db, $table, $itemName) {
    try {
        $stmt = $db->prepare("SELECT * FROM $table where name = ?;");
        $args = array($itemName);
        $stmt->execute($args);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
        echo $e;
    }
    return $rows;

}


function getAllItemNames($db, $table) {
    try {
        $stmt = $db->prepare("SELECT name FROM $table ORDER BY name ASC;");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
        echo $e;
    }
    return $rows;
}

function getItemInfoAll($db, $tables, $order, $logic) {
    $results = "";
    $tableCount = count($tables);
    $x = 0;
    foreach ($tables as $item) {
        $table = $item["TABLE_NAME"];
        $query = "SELECT name, count, unit, type, exp_date, vendor FROM $table";

        if ($x == 5 or $x == 0) {   
            $results = "$results $query ";
        } else {
            $results = "$results UNION $query ";
        }
        $x++;
    }
    //echo '<pre>' . var_export($results, true) . '</pre>';


    try {
        $stmt = $db->prepare("$results ORDER BY $order $logic;");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
        echo $e;
    }
    return $rows;
}

function getColumnName($db, $table) {
    try {
        $stmt = $db->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = 'rrt_inventory' AND TABLE_NAME = ?;");
        $args = array($table);
        $stmt->execute($args);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
        echo $e;
    }
    return $rows;
}

function getTables($db) {
    try {
        $stmt = $db->prepare("SELECT TABLE_NAME 
        FROM INFORMATION_SCHEMA.TABLES
        WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='rrt_inventory';");   
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
        echo $e;
    }
    return $rows;
}

function updateItem($db, $table, $column, $data, $item) {
    try {
        $stmt = $db->prepare("UPDATE $table SET $column = ? WHERE name = ?;");
        $args = array($data, $item);
        $stmt->execute($args);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
        echo $e;
    }
    return $rows;
}

?>