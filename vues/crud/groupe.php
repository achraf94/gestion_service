<?php
include '../config/db_config.php';
$idE = $_SESSION['enseignant_info'][0]['eid'];
$annee = $_SESSION["annee"];
if ($annee == "NULL") {
    $sql = "select * from groupes p where p.mid in (select mid from modules where eid = $idE) order by nom ";
} else {
    $sql = "select * from groupes p where p.mid in (select mid from modules where eid = $idE)  and annee = '$annee' order by nom ";
}

$Listgroupes = select_with_sql($sql);
$role = $_SESSION['user_info'][0]['role'];
?>

<!-- Header -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Groupe</b></h5>
    <?php if ($role == "admin") { ?>
        <button class="w3-button  w3-blue w3-right "><i class="fa fa-user-plus"></i></button>
    <?php }
    ?>
</header>
<div class="w3-row-padding w3-margin-bottom">

    <div class="row">
        <?php
        foreach ($Listgroupes as $row) {
            $data = array("gtid" => $row["gtid"]);
            $gtyp_value = select_with_param($data, "gtypes", "nbh,nom");
            $data = array("mid" => $row["mid"]);
            $module = select_with_param($data, "modules", "intitule");
            ?>
            <div style="height:270px;" class="col-xs-5 col-md-2 icard w3-white w3-margin w3-border w3-round-xlarge" data-idEnseignant="<?php echo $row["eid"]; ?>">
                <div class="card w3-center">
                    <h5 class="card-title w3-left"><?php echo $row["annee"]; ?></h5>
                    <h5 class="card-title w3-right"><?php echo $gtyp_value[0]["nbh"]; ?>H</h5>
                    <h5 class="card-title w3-center w3-text-blue "><?php echo $row["nom"]; ?></h5>
                    <img src="https://chemdoc.com/wp-content/uploads/2018/08/employee.png" class="card-img-top img-2">
                    <div class=" card-body">
                        <h5 class="card-title w3-center">  <?php echo $module[0]["intitule"] ?></h5>
                    </div>

                </div>
                <?php if ($role == "admin") { ?>
                    <div class="w3-center w3-animate-zoom action"> 
                        <i class="delete fa fa-trash-alt w3-text-red position-absolute w3-button "></i>
                        <i class="edit fa fa-pencil-alt w3-text-green position-absolute w3-button "></i>
                    </div>
                <?php }
                ?>
            </div>

            <?php
        }
        ?>
    </div>


</div>

<script>
    $(function () {
        var id = "";
        $(".delete").click(function () {
            id = $(this).parents("div.icard").data('idenseignant');

        });
    });
</script>