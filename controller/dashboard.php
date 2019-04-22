<?php

session_start();
$param = $_POST["param"];
$annee = isset($_POST["annee"]) && !empty($_POST["param"]) && !empty($_POST["annee"]) ? $_POST["annee"] : "NULL";
$_SESSION["annee"] = $annee;
switch ($param) {
    case 'enseignant':
        include("../vues/crud/enseignant.php");
        break;
    case 'groupe':
        include("../vues/crud/groupe.php");
        break;
    case 'module':
        include("../vues/crud/module.php");
        break;
    case 'gestion_user' :
        include("../vues/crud/gestion_user.php");
        break;
    case 'index_statistique' :
        include '../vues/statistique/index.php';
        break;
    case 'affectation' :
        include '../vues/crud/affectation.php';
        break;
}
