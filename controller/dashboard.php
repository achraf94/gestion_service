<?php

$param = $_POST["param"];

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
}
