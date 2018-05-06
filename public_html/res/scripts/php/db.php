<?php
/**
 * Created by PhpStorm.
 * User: callu
 * Date: 05/05/2018
 * Time: 17:22
 */

//Error reporting
error_reporting(-1);
ini_set('display_errors', 'On');

abstract class Database{
    public function __construct($db_host, $db_user, $db_pass, $db_name){
        $this->conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
        if($this->conn->connect_errno) echo "[Error] Failed to connect to database";
    }

    abstract function read();
}

abstract class Table{
    public function __construct($table_name, $conn){
        $this->table_name = $table_name;
        $this->conn = $conn;
    }

    abstract function insert($values);

    abstract function table();

    abstract function remove($id);

    abstract function get_by_id($id);
}

abstract class Entity{
    public function __construct($id) {
        $this->id = $id;
    }

    abstract function to_val_array();
}


function read($conn, $table_name, $column_names){
    $sql = "SELECT ";
    if($column_names == null){
        $sql .= "* ";
    }else{
        $sql .= "(";
        foreach ($column_names as $column_name){
            $sql .= $column_name . ", ";
        }
        $sql = substr($sql, 0, -2) . ") ";
    }
    $sql .= "FROM {$table_name} ORDER BY 1;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt;
}

function remove($conn, $table_name, $type_string, $column_names, $column_values){
    $sql = "DELETE FROM {$table_name} WHERE (";
    foreach ($column_names as $column_name){
        $sql .= $column_name . ", ";
    }
    $sql = substr($sql, 0, -2) . ") = (";

    foreach ($column_values as $_){
        $sql .= "?, ";
    }
    $sql = substr($sql, 0, -2) . ");";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($type_string, ...$column_values);
    $stmt->execute();
    header("Refresh:0");
}

function insert($conn, $table_name, $type_string, $column_names, $column_values){
    $sql = "INSERT INTO {$table_name} (";
    foreach ($column_names as $column_name){
        $sql .= $column_name . ", ";
    }

    $sql = substr($sql, 0, -2) . ") VALUES (";

    foreach ($column_values as $_){
        $sql .= "?, ";
    }

    $sql = substr($sql, 0, -2) . ");";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($type_string, ...$column_values);
    $stmt->execute();
    header("Refresh:0");
}

?>