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
        $type = !empty($_POST["Type"]) ? $_POST["Type"] : "null";
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
            $lastid = insert($data_user, "users", "login,mdp,role", "uid");
            $data_enseignant["uid"] = $lastid;
            insert($data_enseignant, "enseignants", "uid,nom,prenom,email,tel,etid,annee", "eid");
            header("location:../vues/connexion.php?msg=done&login=" . $login);
        } else {
            header("location:../vues/connexion.php?msg=error2");
        }


        break;
    case 'deconnexion':
        session_destroy();
        break;
}
