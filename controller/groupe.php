<?php

include '../config/db_config.php';
// khask parametre


$param = $_POST["param"];
switch ($param) {
    case 'supprimer':
        $id = $_POST["id"];
        exec_crud("delete from groupes where gid = $id");

        break;
    case 'modifier':

        break;
}
