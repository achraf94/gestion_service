<?php
session_start();
include '../config/db_config.php';
$param = $_POST["param"];
$annee = isset($_POST["annee"]) && $_POST["annee"] != "-1" && !empty($_POST["annee"]) ? $_POST["annee"] : "NULL";


switch ($param) {
    case 'listGroup_affecter':
        $eid = isset($_POST["ide"]) && !empty($_POST["ide"]) ? $_POST["ide"] : "NULL";
        $sql = "select g.* from groupes g,affectations a where g.gid = a.gid and a.eid =" . $eid;
        if ($annee != "NULL") {
            $sql .=" and annee = " . $annee;
        }
        $Listgroupes = select_with_sql($sql);
        foreach ($Listgroupes as $row) {
            $data = array("gtid" => $row["gtid"]);
            $gtyp_value = select_with_param($data, "gtypes", "nbh,nom");
            $data = array("mid" => $row["mid"]);
            $module = select_with_param($data, "modules", "intitule");
            ?>
            <div style="height:270px;width: auto;" class="col-xs-4 col-md-2 w3-sand icard w3-margin w3-border w3-round-xlarge">
            <button type="button" class="close w3-text-red delete" data-idgroup="<?php echo  $row["gid"];?>">&times;</button> 
            <div class="w3-container w3-center w3-padding">
                    <h5 class="card-title w3-center w3-text-blue "><?php echo $row["nom"]; ?></h5>
                    <img src="../lib/img/user/group.png" class="card-img-top img-2">
                    <div class=" card-body">
                        <h5 class="card-title w3-left"><?php echo $row["annee"]; ?></h5>
                        <h5 class="card-title w3-right"><?php echo $gtyp_value[0]["nbh"]; ?>H</h5>
                    </div>
                    <br><br>

                   <h5 class="card-title w3-center w3-large">  <?php echo $module[0]["intitule"] ?></h5>

                </div>
            </div>
            <?php
        }

        break;

        case "listGroup_Nonaffecter":
        $id = $_POST["ide"];
        $annee = $_POST["annee"];
        $data = select_with_sql("SELECT g.*,m.*FROM modules m,groupes g,affectations a  WHERE  g.mid = m.mid and  g.gid = a.gid AND a.eid != $id and g.annee= $annee");
        echo loadJson_Array($data);
      
        break;
        
        case "appliquer_affectation":


       $nbh = $_POST["nbreheur"];
       $ide = $_POST["idenseignant"];
       $gid = $_POST["groupeid"];
       $sql="INSERT into affectations values('$ide','$gid','$nbh')";
       exec_crud($sql);
        break;

        case 'supprimer_groupe':

        $gid = $_POST["gid"];
        $sql="delete from affection where gid = '$gid'";
        echo $sql;
        //exec_crud($sql);
        break;
}
