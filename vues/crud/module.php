<?php
include '../config/db_config.php';
$idE = $_SESSION['enseignant_info'][0]['eid'];

$annee = $_SESSION["annee"];
if ($annee == "NULL") {
    $data = array("eid" => $idE);
} else {
    $data = array("eid" => $idE, "annee" => $annee);
}
$listEns = select_with_param(array("annee" => $annee), "enseignants");
$catego = select("categories");
$ListModule = select_with_param($data, "modules");
$role = $_SESSION['user_info'][0]['role'];
?>

<!-- Header -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Module</b></h5>
    <?php if ($role == "admin") { ?>
        <button class="w3-button  w3-blue w3-right add" data-toggle="modal" data-target="#registre"><i class="fa fa-plus-circle"></i></button>
    <?php }
    ?>

</header>
<div class="w3-row-padding w3-margin-bottom w3-margin">

    <div class="row">
        <?php
        foreach ($ListModule as $row) {
            $data = array("cid" => $row["cid"]);
            $categories_value = select_with_param($data, "categories", "nom");
            ?>
            <div style="height:310px;" class="col-xs-6 col-md-2 icard w3-white w3-margin w3-border w3-round-xlarge" data-Module="<?php echo $row["mid"]; ?>">
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
                        <i data-id="<?php echo $row["mid"]; ?>" class="delete fa fa-trash-alt w3-text-red position-absolute w3-button  "></i>
                        <i data-toggle="modal" data-target="#registre" data-id="<?php echo $row["mid"]; ?>"  data-intitule="<?php echo $row["intitule"]; ?>" data-code="<?php echo $row["code"]; ?>" data-eid="<?php echo $row["eid"]; ?>" data-cid="<?php echo $row["cid"]; ?>" data-annee="<?php echo $row["annee"]; ?>" class="edit fa fa-pencil-alt w3-text-green position-absolute w3-button "></i>
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
        var id = "", intitule, code, eid, cid, annee, arg;
        $(".delete").click(function () {
            id = $(this).data('id');
            if (confirm("voulez vous suppriemr cet module")) {
                $(this).parents("div.icard").animate({bottom: '202px'}, function () {
                    $(this).detach();
                });
                $.post("../controller/enseignant.php", {aram: "supprimer", id: id})
            }

        });

        $("#ajouter").click(function () {
            intitule = $("#intitule").val();
            code = $("#code").val();
            eid = $("#eid").val();
            cid = $("#cid").val();
            annee = $("#annee").val();
            //1 mes arguments
            arg = {param: "ajouter", intitule: intitule, code: code, eid: eid, cid: cid, annee: annee};
            // ma fonction en cas de sucess { ya3ni mchiit serveur ou dart le traitement neccessaire ou rja3t sans mochkil }
            success = function (data) {
                if (JSON.parse(data).stat === "OK") {
                    $("#registre").modal("toggle");
                    $('#registre').on('hidden.bs.modal', function () {
                        refresh({param: "module"});
                    });
                } else {
                    alert("Veuillez remplir tous les champs ");
                }
            };
            post(arg, success);
        });

        $(".edit").click(function () {
            $("#intitule").val($(this).data("intitule"));
            $("#code").val($(this).data("code"));
            $("#eid").val($(this).data("eid"));
            $("#cid").val($(this).data("cid"));
            $("#annee").val($(this).data("annee"));
            $("#idM").val($(this).data("id"));

            $('#etat').text("Modifier");
            $(".check").removeClass("hide");
            $("#ajouter").addClass("hide");
        });
        $(".add").click(function () {
            $('#etat').text("Ajouter");
            $(".check").removeClass("hide");
            $("#modifier").addClass("hide");
            empty();
        });
        $("#modifier").click(function () {
            intitule = $("#intitule").val();
            code = $("#code").val();
            eid = $("#eid").val();
            cid = $("#cid").val();
            annee = $("#annee").val();
            id = $('#idM').val();
            //1 mes arguments
            arg = {param: "modifier", id: id, intitule: intitule, code: code, eid: eid, cid: cid, annee: annee};
            // ma fonction en cas de sucess { ya3ni mchiit serveur ou dart le traitement neccessaire ou rja3t sans mochkil }
            success = function (data) {
                if (JSON.parse(data).stat === "OK") {
                    $("#registre").modal("toggle");
                    $('#registre').on('hidden.bs.modal', function () {
                        refresh({param: "module"});
                    });
                } else {
                    alert("Veuillez remplir tous les champs ");
                }


            };
            post(arg, success);
        });


        function post(param, success) {
            $.post("../controller/module.php", param, success);
        }
        function refresh(param) {
            $.post("../controller/dashboard.php", param, function (data) {
                $("#child_template").html(data);
            });
        }
        function empty() {
            $("#intitule").val("");
            $("#code").val("");
            $("#eid").val("");
            $("#cid").val("");
            $("#annee").val("");
            $("#idM").val("");
        }
    });
</script>

<div class="modal fade" id="registre" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">

            <div class="modal-header" style="text-align:center;">
                <h2 class="modal-title">
                    <span id="etat"></span> Enseignant
                </h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="intitule">Intitule</label>
                    <input type="text" class="form-control" id="intitule" placeholder="Intitule .." >
                </div>
                <div class="form-group">
                    <label for="code">Code</label>
                    <input type="text" class="form-control" id="code" placeholder="Code .." >
                </div>
                <div class="form-group">
                    <label for="annee">Annee</label>
                    <input type="text" class="form-control" id="annee" placeholder="Annee .." >
                </div>
                <div class="form-group">
                    <label for="eid">Enseignant</label>
                    <select id="eid" class="form-control">
                        <?php
                        foreach ($listEns as $row) {
                            echo "<option value='" . $row["eid"] . "'>" . $row["nom"] . " " . $row["prenom"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cid">Categories</label>
                    <select id="cid" class="form-control">
                        <?php
                        foreach ($catego as $row) {
                            echo "<option value='" . $row["cid"] . "'>" . $row["nom"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button"  id="ajouter" class=" hide btn btn-primary check">Ajouter</button>
                <button type="button"  id="modifier" class=" hide btn btn-primary check">Modifier</button>
                <input type="hidden" id="idM" >
            </div>

        </div>
    </div>
</div>