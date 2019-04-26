<?php
session_start();
include '../config/db_config.php';
$param = $_POST["param"];
$annee = isset($_POST["annee"]) && $_POST["annee"] != "-1" && !empty($_POST["annee"]) ? $_POST["annee"] : "2015";


switch ($param) {
    case 'listGroup_affecter':
        ?>

        <?php
        $inbT = "";
        $inbP = "";
        $eid = isset($_POST["ide"]) && !empty($_POST["ide"]) ? $_POST["ide"] : "NULL";
        $annee = $annee == "NULL" ? "2015" : $annee;
        $sql = "select g.*,m.intitule,gt.nbh as nombreHT, sum(a.nbh) nbh , avg(a.nbh*gt.coeff) EQTD_nonComplet,avg(gt.nbh*gt.coeff) EQTD_totale from groupes g,affectations a,modules m,gtypes gt where gt.gtid = g.gtid and m.mid = g.mid and a.gid = g.gid and m.annee= '$annee'and g.annee= '$annee' and a.eid = '$eid' group by 1,2,3";

        $Listgroupes = select_with_sql($sql);
        if (empty($Listgroupes)) {
            ?>
            <header class="w3-container" style="padding-top:22px">
                <h5><b><i class="fa fa-dashboard"></i> <?php echo "Pas de resultas ! changer l'annee pour voir d'autres informations"; ?> </b> </h5>
            </header>
            <?php
        }
        foreach ($Listgroupes as $row) {

            $color = "w3-border-green";
            if ($row["nbh"] < $row["nombreHT"]) {
                $color = "w3-border-red";
            }
            ?>
            <div style="width: auto;" class="col-xs-4 col-md-2 w3-sand icard <?php echo $color; ?> w3-margin w3-border  w3-round-xlarge">
                <button type="button" class="close w3-text-red delete" data-idgroup="<?php echo $row["gid"]; ?>">&times;</button> 
                <div class="w3-container w3-center w3-padding">
                    <h5 class="card-title w3-center w3-text-blue "><?php echo $row["nom"]; ?></h5>
                    <img src="../lib/img/user/group.png" class="card-img-top img-2">
                    <div class=" card-body">
                        <h5 class="card-title w3-center"><?php echo $row["annee"]; ?></h5>
                        <table class="w3-table">
                            <tr>
                                <td>GROUPE NBH </td>
                                <td><?php echo $row["nombreHT"]; ?>H</td>
                            </tr>
                            <tr>
                                <td>AFFECTATION NBH </td>
                                <td><?php echo $row["nbh"]; ?>H</td>
                            </tr>
                            <tr>
                                <td>EQTD NON-AFFECTÉS </td>
                                <td><?php echo $row["EQTD_nonComplet"]; ?></td>
                            </tr>
                            <tr>
                                <td>EQTD AFFECTÉS</td>
                                <td><?php echo $row["EQTD_totale"]; ?></td>
                            </tr>
                        </table>
                    </div>
                    <br><br>

                    <h5 class="card-title w3-center w3-large">  <?php echo $row["intitule"] ?></h5>

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
        $sql = "INSERT into affectations values('$ide','$gid','$nbh')";
        exec_crud($sql);
        break;

    case 'supprimer_groupe':

        $gid = $_POST["gid"];
        $sql = "delete from affection where gid = '$gid'";
        echo $sql;
        //exec_crud($sql);
        break;
}
