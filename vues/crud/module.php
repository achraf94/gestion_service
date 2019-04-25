<?php
include '../config/db_config.php';
$idE = $_SESSION['enseignant_info'][0]['eid'];
$annee = $_SESSION["annee"];
if ($annee == "NULL") {
    $data = array("eid" => $idE);
} else {
    $data = array("eid" => $idE, "annee" => $annee);
}

$ListModule = select_with_param($data, "modules");
$role = $_SESSION['user_info'][0]['role'];
?>

<!-- Header -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Module</b></h5>
    <?php if ($role == "admin") { ?>
        <button class="w3-button  w3-blue w3-right "><i class="fa fa-user-plus"></i></button>
    <?php }
    ?>

</header>
<div class="w3-row-padding w3-margin-bottom">

    <div class="row">
        <?php
        foreach ($ListModule as $row) {
            $data = array("cid" => $row["cid"]);
            $categories_value = select_with_param($data, "categories", "nom");
            ?>
            <div style="height:270px;" class="col-xs-6 col-md-2 icard w3-white w3-margin w3-border w3-round-xlarge" data-Module="<?php echo $row["mid"]; ?>">
                <div class="card w3-center">
                    <h5 class="card-title w3-left"><?php echo $row["annee"]; ?></h5>
                    <h5 class="card-title w3-right"><?php echo $categories_value[0]["nom"]; ?></h5>

                    <img src="../lib/img/user/book.png" class="card-img-top img-2">
                    <div class=" card-body">
                        <h5 class="card-title w3-center"><?php echo $row["intitule"]; ?></h5>
                        <h5 class="card-title "> <?php echo $row["code"] ?></h5>
                    </div>
                </div>  <br>
                <?php if ($role == "admin") { ?>
                    <div class="w3-center w3-animate-zoom action ">
                        <i data-supprimer="<?php echo $row["mid"];?>" class="delete fa fa-trash-alt w3-text-red position-absolute w3-button  "></i>
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
            id=$(this).data('supprimer');
            if(confirm("voulez vous suppriemr cet module")){
                $(this).parents("div.icard").animate({bottom:'202px'}, function(){
                      $(this).detach(); });
             $.post("../controller/enseignant.php",{aram:"supprimer",id:id})
            
            }

        });
    });
</script>