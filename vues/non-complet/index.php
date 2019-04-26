<?php
    include '../config/db_config.php';
$annee = $_SESSION['annee'] == "NULL" ? "2015" :$_SESSION['annee'] ;
$sqlE = "select e.eid,e.nom,et.nbh,SUM(a.nbh) as nbhaeff from enseignants e,affectations a ,etypes et where e.eid  = a.eid and e.etid = et.etid and e.annee = '$annee' group by 1,2";
$enseignant = select_with_sql($sqlE );

$sqlM = "select  m.*  from modules m where m.mid not in(select mid from groupes g,affectations a where g.gid  = a.gid) and m.annee  = '$annee'";
$modules = select_with_sql($sqlM);
?>

<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Service non complet  </b> </h5>
</header>

<h3 class="w3-padding">LES ENSEIGNANTS AVEC UN SERVICE NON-COMPLET </h3>
<div class="w3-margin" >
<table class="table w3-white">
        <thead class="w3-black">
            <tr class="w3-center">
                <th scope="col" class="w3-center">#</th>
                <th scope="col" class="w3-center">NOM </th>
                <th scope="col" class="w3-center">HEURES AFFECTÉES</th>
                <th scope="col" class="w3-center">HEURES NON AFFECTÉES</th>
                <th scope="col" class="w3-center">HEURES GLOBALE</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($enseignant as $row) { 
            if($row["nbh"] > $row["nbhaeff"])
            {
            ?>
                <tr class="w3-small w3-center">
                    <th class="w3-center"><?php echo $row["eid"]; ?></th>
                    <td><?php echo $row["nom"]; ?></td>
                    <td><?php echo $row["nbhaeff"]; ?></td>
                    <td><?php echo $row["nbh"] - $row["nbhaeff"] ; ?></td>
                    <td><?php echo $row["nbh"] ; ?></td>
                </tr>
            <?php }
        
        } ?>
        </tbody>
    </table>
</div>
<h3 class="w3-padding"> MODULES AYANT DES HEURES NON-AFFECTÉS

</h3>
<div class="w3-margin" >
<table class="table w3-white">
        <thead class="w3-black">
            <tr class="w3-center">
                <th scope="col" class="w3-center">#</th>
                <th scope="col" class="w3-center">INTITULE </th>
                <th scope="col" class="w3-center">CODE</th>
                <th scope="col" class="w3-center">ENSEIGNANTS</th>
                <th scope="col" class="w3-center">CATEGORIES</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($modules as $row) { ?>
                <tr class="w3-small w3-center">
                    <th class="w3-center"><?php echo $row["mid"]; ?></th>
                    <td><?php echo $row["intitule"]; ?></td>
                    <td><?php echo $row["code"]; ?></td>
                    <td><?php echo select_with_param(array("eid"=>$row["eid"]),"enseignants","nom")[0]["nom"];?></td>
                    <td><?php echo select_with_param(array("cid"=>$row["cid"]),"categories","nom")[0]["nom"];?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>