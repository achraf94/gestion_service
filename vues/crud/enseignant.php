<?php
include '../config/db_config.php';
$annee = $_SESSION["annee"];
$Listenseignant = "";
if ($annee == "NULL") {
    $Listenseignant = select("enseignants");
} else {
    $data = array("annee" => $annee);
    $Listenseignant = select_with_param($data, "enseignants");
}

$role = $_SESSION['user_info'][0]['role'];
?>
<!-- Header -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Enseignant </b> </h5>
</header>
<div class="w3-row-padding w3-margin-bottom" id="">

    <div class="row">
        <?php
        if (empty($Listenseignant)) {
            ?>
            <div style="height:250px;" class="col-xs-4 col-md-2 w3-blue w3-margin w3-border w3-round-xlarge">
                <div class=" w3-center w3-padding">
                    <img src="../lib/img/user/default.png" class="card-img-top img-2">
                    <div class=" card-body">

                        <h5 class="card-title"> Aucun enseignant <br>pour cette annee</h5>
                    </div>

                </div>
            </div>
            <?php
        } else {
            foreach ($Listenseignant as $row) {
                $data = array("etid" => $row["etid"]);
                $etyp_value = select_with_param($data, "etypes", "nbh");
                ?>
                <div style="height:300px;" class="col-xs-6 col-md-2 icard w3-white w3-margin w3-border w3-round-xlarge" data-idEnseignant="<?php echo $row["eid"]; ?>">
                    <div class="card w3-center">
                        <h5 class="card-title w3-left"><?php echo $row["annee"]; ?></h5>
                        <h5 class="card-title w3-right"><?php echo $etyp_value[0]["nbh"]; ?>H</h5>

                        <img src="../lib/img/user/default.png" class="card-img-top img-2">
                        <div class=" card-body">
                            <h5 class="card-title w3-center"><?php echo $row["nom"] . " " . $row["prenom"]; ?></h5>
                            <h5 class="card-title  link_ka"><i class='fa fa-mobile-alt w3-text-black'></i> <?php echo $row["tel"]; ?></h5>
                            <h5 class="card-title "> <i class='fa fa-at w3-text-black'></i> <?php echo $row["email"] ?></h5>
                        </div>
                    </div>
                    <?php if ($role == "admin") { ?>
                        <div class="w3-center w3-animate-zoom action ">
                            <i data-idens="<?php echo $row["eid"]; ?>" class="delete fa fa-trash-alt w3-text-red position-absolute w3-button "></i>
                            <button type="button" data-toggle="modal" data-target="#modifierenseignant" class="modifier fa fa-pencil-alt w3-text-green position-absolute w3-button  w3-circle" data-idens="<?php echo $row["eid"] ?>"  data-nom="<?php echo $row["nom"]; ?>" data-prenom="<?php echo $row["prenom"]; ?>"data-email="<?php echo $row["email"]; ?>"data-tel="<?php echo $row["tel"]; ?>"></button>
                            <input type="hidden" id="idEns_h">
                        </div>
                    <?php }
                    ?>
                </div>

                <?php
            }
        }
        ?>
    </div>


</div>


<script>
    $(function () {
        var id = "", nom = "", prenom = "", email = "", tel = "", arg = "";
        // fonction delete
        $(".delete").click(function () {
            id = $(this).data('idens');
            // Start IF
            if (confirm("voulez vous suppriemr cet enseignant")) {
                $(this).parents("div.icard").animate({bottom: '202px'}, function () {
                    $(this).detach();
                });
                //AJAX envois juste le id afin de supprimer le group 
                $.post("../controller/enseignant.php", {param: "supprimer", id: id});
            }
            // end IF
        });
        $(".modifier").click(function () {

            $("#idEns_h").val($(this).data("idens"));
            // id li ghadi nkhabi bach fi applymodification nsefto lserveur bach imodifier 
            // les info bi had id 
            $("#nom").val($(this).data("nom"));
            $("#prenom").val($(this).data("prenom"));
            $("#mail").val($(this).data("email"));
            $("#tel").val($(this).data("tel"));

        });
        $("#applyModification").click(function () {
            id = $("#idEns_h").val();
            nom = $("#nom").val();
            prenom = $("#prenom").val();
            email = $("#mail").val();
            tel = $("#tel").val();
            //1 mes arguments
            arg = {param: "modifier", id: id, nom: nom, prenom: prenom, email: email, tel: tel};
            // ma fonction en cas de sucess { ya3ni mchiit serveur ou dart le traitement neccessaire ou rja3t sans mochkil }
            success = function (data) {
                location.reload();
            }
            post(arg, success);
        });
        function post(param, success) {
            $.post("../controller/enseignant.php", param, success);
        }
    });


</script>


<div class="modal fade" id="modifierenseignant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content registr">

            <div class="modal-header" style="text-align:center;">
                <h2 class="modal-title">
                    modifier Enseignant
                </h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="Nom">Nom</label>
                    <input type="text" class="form-control" id="nom" placeholder="Votre Nom .." require>
                </div>
                <div class="form-group">
                    <label for="Prenom">Prenom</label>
                    <input type="text" class="form-control" id="prenom" placeholder="Votre Prenom .." require>
                </div>

                <div class="form-group">
                    <label for="mail">Email</label>
                    <input type="mail" class="form-control" id="mail" placeholder="Votre Email .." require>
                </div>
                <div class="form-group">
                    <label for="tel">Tel</label>
                    <input type="tel" class="form-control" id="tel" pattern="[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}" placeholder="Votre Tel .." require>
                    <small id="emailHelp" class="form-text text-muted">Format: 0701102040</small>
                </div>

                <div class="modal-footer">
                    <button type="button"  class="btn btn-primary" id= "applyModification" >enregistrer</button>
                </div>

            </div>

        </div>
    </div>
</div>







