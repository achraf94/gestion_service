<link rel="stylesheet" href="../lib/node_modules/@fortawesome/fontawesome-free/css/all.css">
<link rel="stylesheet" href="../lib/node_modules/bootstrap/dist/css/bootstrap.css">
<link rel="stylesheet" href="../lib/projet_css/connexion.css">
<script src="../lib/node_modules/jquery/dist/jquery.js"></script>
<script src="../lib/node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="../lib/node_modules/sweetalert/dist/sweetalert.min.js"></script>
<?php
require('../config/db.php');
$db = db::getInstance();
include '../config/fun_etype.php';
$etype = select_etype();

?>

<div class="login">
    <h1><img src="../lib/img/upec.png"> </h1>
    <form method="post" action="../controller/user.php">
        <input type="text" name="login" placeholder="login" required="required" />
        <input type="password" name="pass" placeholder="mot de passe" required="required" />
        <button type="submit" name='param' value="connexion" class="btn btn-primary btn-block btn-large">se connecter.</button>
        <button type="button" data-toggle="modal" data-target="#registre" class="btn btn-danger btn-block btn-large">s'enregistrer.</button>

    </form>
</div>

<div class="modal fade" id="registre" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content registr">
            <form action="../controller/user.php" method="POST" enctype="multipart/form-data">
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
                        <input type="text" class="form-control" name="nom" placeholder="Votre Nom .." require>
                    </div>
                    <div class="form-group">
                        <label for="Prenom">Prenom</label>
                        <input type="text" class="form-control" name="prenom" placeholder="Votre Prenom .." require>
                    </div>

                    <div class="form-group">
                        <label for="mail">Email</label>
                        <input type="mail" class="form-control" name="mail" placeholder="Votre Email .." require>
                    </div>
                    <div class="form-group">
                        <label for="tel">Tel</label>
                        <input type="tel" class="form-control" name="tel" pattern="[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}" placeholder="Votre Tel .." require>
                        <small id="emailHelp" class="form-text text-muted">Format: 0701102040</small>
                    </div>
                    <div class="form-group">
                        <label for="tel">mot de passe</label>
                        <input type="password" class="form-control" name="passe" placeholder="Votre mot de passe .." require>

                    </div>
                    <div class="form-group">
                        <label for="annee">Annee</label>
                        <select name="annee" class="form-control">
                            <option>2019</option>
                            <option>2020</option>
                            <option>2021</option>
                            <option>2022</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Type">Type</label>
                        <select name="Type" class="form-control">
                            <?php
                            foreach ($etype as $row) {
                                echo "<option value='" . $row["etid"] . "'>" . $row["nom"] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">

                        <label for="Type">Photo</label>
                        <div class="d-flex justify-content-center">
                            <div class="btn btn-mdb-color btn-rounded float-left">

                                <input type="file" name="photo">
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" name='param' value="enregistrer" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    <?php
    if (isset($_GET["msg"]) && $_GET["msg"] == "error1") {
        echo "swal('ERROR #1', 'login ou mot de passe incorrects', 'error');";
    } else if (isset($_GET["msg"]) && $_GET["msg"] == "error2") {
        echo "swal('ERROR #2', 'champs vide', 'error');";
    } else if (isset($_GET["msg"]) && $_GET["msg"] == "done") {
        ?>
    swal('Good job!', 'Vous pouvez se connecter avec <?php echo $_GET["login"]; ?> ', 'success');
    <?php

}
?>
</script> 