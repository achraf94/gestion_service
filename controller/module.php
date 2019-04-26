<?php

include '../config/db_config.php';
$param = $_POST["param"];

$id = isset($_POST["id"]) && !empty($_POST["id"]) ? $_POST["id"] : "null";
$intitule = isset($_POST["intitule"]) && !empty($_POST["intitule"]) ? $_POST["intitule"] : "null";
$code = isset($_POST["code"]) && !empty($_POST["code"]) ? $_POST["code"] : "null";
$eid = isset($_POST["eid"]) && !empty($_POST["eid"]) ? $_POST["eid"] : "null";
$cid = isset($_POST["cid"]) && !empty($_POST["cid"]) ? $_POST["cid"] : "null";
$annee = isset($_POST["annee"]) && !empty($_POST["annee"]) ? $_POST["annee"] : "null";

switch ($param) {
    case 'supprimer':
        $id = $_POST["id"];
        exec_crud("delete from modules where mid=$id");
        break;
    case 'modifier':
        $output = array();
        $data_module = array(
            "intitule" => $intitule,
            "code" => $code,
            "eid" => $eid,
            "cid" => $cid,
            "annee" => $annee
        );
        if (!in_array("null", array_values($data_module))) {
            update($data_module, "modules", "mid", $id);
            $output["stat"] = "OK";
        } else {
            $output["stat"] = "ERROR2";
        }
        echo json_encode($output);
        break;

    case 'ajouter':
        $output = array();
        $data_module = array(
            "intitule" => $intitule,
            "code" => $code,
            "eid" => $eid,
            "cid" => $cid,
            "annee" => $annee
        );

        if (!in_array("null", array_values($data_module))) {
            insert($data_module, "modules", "intitule,code,eid,cid,annee", "mid");
            $output["stat"] = "OK";
        } else {
            $output["stat"] = "ERROR2";
        }
        echo json_encode($output);
        break;
}