<?php
include '../config/db_config.php';

$ListUser = select("users");
$role = $_SESSION['user_info'][0]['role'];
$uid = $_SESSION['user_info'][0]['uid'];
$etype = select("etypes");
?>

<!-- Header -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Gestion Utilisateur</b></h5>
    <button class="w3-button  w3-blue w3-right " data-toggle="modal" data-target="#registre"><i class="fa fa-user-plus"></i></button>
</header>
<div class="w3-margin">

    <table class="table w3-white">
        <thead class="w3-black">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Login</th>
                <th scope="col">Role</th>
                <th scope="col"></th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($ListUser as $user) { ?>
                <tr class="w3-small">
                    <th scope="row"><?php echo $user["uid"]; ?></th>
                    <td><?php echo $user["login"]; ?></td>
                    <td><?php echo $user["role"]; ?></td>
                    <td style="width: 100px;">
                        <div class="w3-small">
                            <button data-id="<?php echo $user["uid"]; ?>" class=" w3-white"><i class="fas fa-user-edit w3-text-green"></i></button>
                            <button data-id="<?php echo $user["uid"]; ?>"class="delete w3-white"><i class="fas fa-trash-alt w3-text-red"></i></button>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>





<div class="modal fade" id="registre" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">

            <div class="modal-header" style="text-align:center;">
                <h2 class="modal-title">
                    Nouveau Enseignant
                </h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="Nom">Nom</label>
                    <input type="text" class="form-control" id="nom" placeholder="Votre Nom .." >
                </div>
                <div class="form-group">
                    <label for="Prenom">Prenom</label>
                    <input type="text" class="form-control" id="prenom" placeholder="Votre Prenom .." >
                </div>

                <div class="form-group">
                    <label for="mail">Email</label>
                    <input type="mail" class="form-control" id="mail" placeholder="Votre Email .." >
                </div>
                <div class="form-group">
                    <label for="tel">Tel</label>
                    <input type="tel" class="form-control" id="tel" placeholder="Votre Tel .." >

                </div>
                <div class="form-group">
                    <label for="tel">mot de passe</label>
                    <input type="password" class="form-control" id="passe" placeholder="Votre mot de passe .." >

                </div>
                <div class="form-group">
                    <label for="annee">Annee</label>
                    <select id="annee" class="form-control">
                        <option>2019</option>
                        <option>2020</option>
                        <option>2021</option>
                        <option>2022</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Type">Type</label>
                    <select id="Type" class="form-control">
                        <?php
                        foreach ($etype as $row) {
                            echo "<option value='" . $row["etid"] . "'>" . $row["nom"] . "</option>";
                        }
                        ?>
                    </select>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button"  id="enregistrer" class="btn btn-primary">Save changes</button>
            </div>

        </div>
    </div>
</div>


<script>
    $(function () {
        var id = "", nom = "", prenom = "", email = "", tel = "", mdp = "", type = "", annee = "", arg = "";
        $("#enregistrer").click(function () {
            nom = $("#nom").val();
            prenom = $("#prenom").val();
            email = $("#mail").val();
            tel = $("#tel").val();
            mdp = $("#passe").val();
            type = $("#Type").val();
            annee = $("#annee").val();
            //1 mes arguments
            arg = {param: "enregistrer", nom: nom, prenom: prenom, mail: email, tel: tel, mdp: mdp, type: type, annee: annee};
            // ma fonction en cas de sucess { ya3ni mchiit serveur ou dart le traitement neccessaire ou rja3t sans mochkil }
            success = function (data) {
                if (JSON.parse(data).stat == "OK") {
                    alert("Enseignant a ete creer. \n Le login est " + JSON.parse(data).login);
                    $("#registre").modal("toggle");
                } else {
                    alert("veuillez remplir tous les champs.");
                }

            };
            post(arg, success);
        });
        $(".delete").click(function () {
            id = $(this).data("id");
            if (confirm("voulez vous suppriemr l'utilisateur ?")) {
                if (confirm("voulez vous aussi suppriemr l'enseignant ?")) {
                    //AJAX envois juste le id afin de supprimer le group 
                    $.post("../controller/user.php", {param: "supprimer", id: id, ens: "OK"});
                } else {
                    $.post("../controller/user.php", {param: "supprimer", id: id, ens: "NOK"});
                }
                
                $(this).parents("tr").animate({left: '202px'}, function () {
                    $(this).detach();
                });
            }
        });
        function post(param, success) {
            $.post("../controller/user.php", param, success);
        }
    });

</script>