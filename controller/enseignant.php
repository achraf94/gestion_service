<?php
include '../config/db_config.php';
$param = $_POST["param"];
switch ($param) {
    case 'supprimer':
            $id=  $_POST["id"];
          print_r(exec_crud("delete from enseignants where eid=$id"));
        break;
    case 'modifier':
        $id=  $_POST["id"];
            $nom =$_POST["nom"];
            $prenom = $_POST["prenom"];
            $email = $_POST["email"];
            $tel = $_POST["tel"];   
            $sql = "update  enseignants set nom='$nom',prenom='$prenom',email='$email',tel='$tel' where  eid='$id' ";
              exec_crud($sql);

        

 
        break;

    case 'ajouter':
 
    break;
}