<?php
include '../config/db_config.php';
$param = $_POST["param"];
switch ($param) {
    case 'supprimer':
            $id=  $_POST["id"];
          print_r(exec_crud("delete from modules where mid=$id"));
        break;
    case 'modifier':
 
        break;

    case 'ajouter':
 
    break;
}