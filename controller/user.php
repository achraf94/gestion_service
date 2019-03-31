<?php
session_start();
require('../config/db.php');
$db = db::getInstance();
include '../config/fun_user.php';
include '../config/fun_enseignant.php';
$param = $_POST["param"];
$uploaddir = '../lib/img/user/';
switch ($param) {
    case 'connexion':
        $login = $_POST["login"];
        $pass = $_POST["pass"];
        $data = array(
            "login" => $login,
            "mdp" => md5($pass),
        );
        if (select_with_param_user($data)) {
            header("location:../vues/index.php");
        } else {
            header("location:../vues/connexion.php?msg=error1");
        }

        break;
    case 'enregistrer':
        $uploadfile = $uploaddir . basename($_FILES['photo']['name']);
        $nom = !empty($_POST["nom"]) ? $_POST["nom"] : "null";
        $prenom = !empty($_POST["prenom"]) ? $_POST["prenom"] : "null";
        $tel = !empty($_POST["tel"]) ? $_POST["tel"] : "null";
        $mail = !empty($_POST["mail"]) ? $_POST["mail"] : "null";
        $passe = !empty($_POST["passe"]) ? $_POST["passe"] : "null";
        $annee = !empty($_POST["annee"]) ? $_POST["annee"] : "null";
        $type = !empty($_POST["Type"]) ? $_POST["Type"] : "null";
        $photo = !empty($_FILES['photo']['name']) ? $_FILES['photo']['name'] : "null";
        $data_enseignant = array(
            "uid" => "",
            "nom" => $nom,
            "prenom" => $prenom,
            "email" => $mail,
            "tel" => $tel,
            "etid" => $type,
            "annee" => $annee,
            "pic" => $photo

        );
        if (in_array("null", array_values($data_enseignant)) && !empty($passe)) {

            header("location:../vues/connexion.php?msg=error2");
        } else {

            $login = $prenom[0] . "" . $nom;
            $data_user = array();
            array_push($data_user, $login);
            array_push($data_user, md5($passe));
            array_push($data_user, "user");
            $lastid = insert_user($data_user);
            $data_enseignant["uid"] = $lastid;
            insert_ens($data_enseignant);
            move_uploaded_file($_FILES["photo"]["tmp_name"], $uploadfile);
            header("location:../vues/connexion.php?msg=done&login=" . $login);
        }


        break;
    case 'deconnexion':

        session_destroy();

        break;
}
