<?php

session_start();
include '../config/db_config.php';

$param = $_POST["param"];
switch ($param) {
    case 'connexion':
        $login = $_POST["login"];
        $pass = $_POST["pass"];
        $data = array(
            "login" => $login,
            "mdp" => md5($pass),
        );
        if (Count(select_with_param($data, "users")) > 0) {
            $_SESSION["statu"] = "En ligne";
            $_SESSION["user_info"] = select_with_param($data, "users");
            $_SESSION["annee"] = "NULL";
            header("location:../vues/index.php");
        } else {
            header("location:../vues/connexion.php?msg=error1");
        }

        break;
    case 'enregistrer':

        $nom = !empty($_POST["nom"]) ? $_POST["nom"] : "null";
        $prenom = !empty($_POST["prenom"]) ? $_POST["prenom"] : "null";
        $tel = !empty($_POST["tel"]) ? $_POST["tel"] : "null";
        $mail = !empty($_POST["mail"]) ? $_POST["mail"] : "null";
        $passe = !empty($_POST["passe"]) ? $_POST["passe"] : "null";
        $annee = !empty($_POST["annee"]) ? $_POST["annee"] : "null";
        $type = !empty($_POST["type"]) ? $_POST["type"] : "null";
        $output = array();
        $data_enseignant = array(
            "uid" => "",
            "nom" => $nom,
            "prenom" => $prenom,
            "email" => $mail,
            "tel" => $tel,
            "etid" => $type,
            "annee" => $annee
        );
        if (!in_array("null", array_values($data_enseignant)) && !empty($passe)) {
            $login = $prenom[0] . "" . $nom;
            $data_user = array();
            array_push($data_user, $login);
            array_push($data_user, md5($passe));
            array_push($data_user, "user");
            $lastID = insert($data_user, "users", "login,mdp,role", "uid");
            $data_enseignant["uid"] = $lastID;
            insert($data_enseignant, "enseignants", "uid,nom,prenom,email,tel,etid,annee", "eid");
            $output["login"] = $login;
            $output["stat"] = "OK";
        } else {
            $output["stat"] = "ERROR2";
        }
        echo json_encode($output);

        break;
    case 'deconnexion':
        session_destroy();
        break;
    case 'supprimer':
        $id = $_POST["id"];
        $ens = $_POST["ens"];
        if ($ens == "OK") {
            exec_crud("delete from enseignants where uid = '$id'");
        }
        exec_crud("delete from users where uid = '$id'");

        break;
    case "modifier_motdepass":
        $nouveau = !empty($_POST["nouveau"]) ? md5($_POST["nouveau"]) : "null";
        $ancien = !empty($_POST["ancien"]) ? md5($_POST["ancien"]) : "null";

        $tokenModification = select_with_param(array("mdp" => $ancien), "users");

        $output = array();
        if (empty($tokenModification)) {
            $output["motdepass"] = "null";
        } else {
            $sql = "update users set mdp = '$nouveau' where mdp ='$ancien'";
            exec_crud($sql);
            $output["motdepass"] = "OK";
        }
        echo json_encode($output);
        break;
}
