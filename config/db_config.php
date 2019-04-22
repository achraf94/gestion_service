<?php

$DEFAULT_SQL_USER = 'root';
$DEFAULT_SQL_HOST = 'localhost';
$DEFAULT_SQL_PASS = '';
$DEFAULT_SQL_DBNAME = '2019_projet5_services';

$dbh = new PDO('mysql:host=' . $DEFAULT_SQL_HOST . ';dbname=' . $DEFAULT_SQL_DBNAME, $DEFAULT_SQL_USER, $DEFAULT_SQL_PASS);

// permet d'avoir un tableau d'objet stdclass
function loadObjectList($sql) {
    $req = $GLOBALS['dbh']->prepare($sql);
    $array = array();
    try {
        $req->execute();
        $array = $req->fetchAll(PDO::FETCH_OBJ);
        $req->closeCursor();
    } catch (PDOException $e) {
        return $e->getMessage();
    }
    return $array;
}

// permet d'avoir un tableau normal KEY VALUE
function loadArrayList($sql) {
    $req = $GLOBALS['dbh']->prepare($sql);
    $array = array();
    try {
        $req->execute();
        $array = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();
    } catch (PDOException $e) {
        return $e->getMessage();
    }
    return $array;
}

// permet d'avoir nombre de ligne
function getListCount($sql) {
    return count(loadArrayList($sql));
}

function exec_crud($sql = "") {
    $req = $GLOBALS['dbh']->prepare($sql);
    return $req->execute();
}

function db_insert($sql, $table, $primary) {
    exec_crud($sql);
    return lastId($table, $primary);
}

function lastId($table, $primary) {
    $sql = "select max( $primary ) as lastid from $table";
    return loadArrayList($sql)[0]["lastid"];
}

function getOneColumn($sql = "", $column = "") {
    return loadArrayList($sql)[0][$column];
}

function update() {
    
}

function delete() {
    
}

function insert($data = array(), $table = "", $columns = "", $primary = "") {
    $sql = "insert into  $table( $columns) values(";
    foreach ($data as $columns => $value) {
        $sql .= "'" . $value . "',";
    }
    $sql = substr($sql, 0, -1) . ")";
    return db_insert($sql, $table, $primary);
}

function select($table = "null") {
    $sql = "select * from   $table";
    return loadArrayList($sql);
}

function select_with_param($data = array(), $table = "", $columns = "*") {
    $sql = "select  $columns from  $table where ";
    foreach ($data as $column => $value) {
        $sql .= $column . "='" . $value . "' and ";
    }
    $sql = substr($sql, 0, -4);
    return loadArrayList($sql);
}

function select_with_sql($sql) {
    return loadArrayList($sql);
}
