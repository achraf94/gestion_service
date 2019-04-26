<!DOCTYPE html>
<html>
    <title>Apps</title>
    <meta charset="UTF-8">
    <link rel="icon" href="../lib/img/upec2.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../lib/projet_css/header.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.0.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <?php
    session_start();
    include '../config/db_config.php';
    if (!isset($_SESSION["statu"])) {
        header("location:connexion.php");
    }
//selectionner le ID de user 
    $param = array("uid" => $_SESSION['user_info'][0]['uid']);
    //selectionner les donnees de cet utilisateur 
    //select * from user where uid=$param
    $enseignant = select_with_param($param, "enseignants");
    if (empty($enseignant)) {
        ?>
        <header class="w3-container w3-center" style="padding-top:22px">
            <span class="w3-bar-item  disco">
                <i class="fas fa-power-off w3-button w3-text-red w3-large"></i>
            </span>
            <h5><b><i class="fa fa-dashboard"></i> vous etes pas un enseignant <br> vous pouvez crrer un compte dans la page connexion </b> </h5>

        </header>
        <?php
    } else {

        $_SESSION["enseignant_info"] = select_with_param($param, "enseignants");
        $role = $_SESSION['user_info'][0]['role'];
        $name = $enseignant[0]['nom'] . " " . $enseignant[0]['prenom'];
        ?>

        <body class="w3-light-grey">
            <!-- Top container -->
            <div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
                <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
                <span class="w3-bar-item w3-right w3-text-red">
                    <select style="margin-top: 3px;" id="changeAnnee">
                        <option value="2015">2015</option>
                        <option  value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option  value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option  value="2020">2020</option>

                    </select>
                </span>
                <span class="w3-bar-item w3-right">
                    <img src="../lib/img/upec.png" class="w3-image img-1">
                </span>
                <span class="w3-bar-item w3-left disco">
                    <i class="fas fa-power-off w3-button w3-text-red w3-large"></i>
                </span>
            </div>
            <!-- Sidebar/menu -->
            <nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
                <div class="w3-container w3-row">
                    <div class="w3-col s4">
                        <img src="../lib/img/user/default.png" class="w3-circle w3-margin-right" style="width:46px">
                    </div>
                    <div class="w3-col s8 w3-bar">
                        <span>Bonjour, <strong><?php echo $name; ?></strong></span><br>

                        <a href="#" class="w3-bar-item w3-button" title="Statistique "><i class="fa fa-chart-line w3-text-orange"></i></a>
                        <a href="#" class="w3-bar-item w3-button" data-target="#modifiermotpass" data-toggle="modal" title="mdpupdate"><i class="fas fa-key"></i></a>
                        <?php if ($role == "admin") { ?>
                            <a href="#" data-page="gestion_user" class="xmenuleft navigate_link w3-bar-item w3-button" title="Configuration Utilisateur"><i class="fas fa-user-cog w3-text-brown"></i></i></a>
                        <?php } ?>
                    </div>
                </div>

                <div class="w3-container w3-teal w3-center">
                    <header class="w3-container">
                        <h5><b><i class="fa fa-dashboard"></i> TABLEAU DE BORD</b></h5>
                    </header>



                </div>
                <div class="w3-bar-block">
                    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>

                    <a href="#" data-page="index_statistique" class="navigate_link w3-blue w3-bar-item w3-button w3-padding xmenuleft">
                        <i class="fas fa-clipboard fa-fw w3-text-dark-grey"></i>
                        SERVICE NON-COMPLET
                    </a>

                    <a href="#" data-page="enseignant" class="navigate_link w3-bar-item w3-button w3-padding xmenuleft"><i class="fa fa-users fa-fw w3-text-green"></i> ENSEIGNANTS</a>
                    <a href="#" data-page="groupe" class="navigate_link w3-bar-item w3-button w3-padding xmenuleft"><i class="fa fa-school fa-fw w3-text-purple"></i> GROUPES</a>
                    <a href="#" data-page="module" class="navigate_link w3-bar-item w3-button w3-padding xmenuleft"><i class="fa fa-book-open fa-fw w3-text-yellow"></i> MODULES</a>

                    <?php
                    if ($role == "admin") {
                        ?>
                        <a href="#" data-page="gtype" class="navigate_link w3-bar-item w3-button w3-padding xmenuleft"><i class="fas fa-swatchbook  fa-fw w3-text-red"></i> GTYPES</a>
                        <a href="#" data-page="affectation" class="navigate_link w3-bar-item w3-button w3-padding xmenuleft"><i class="fas fa-dice-d20 fa-fw w3-text-aqua"></i> AFFECTATION</a>

                    <?php } ?>


                </div>

            </nav>
            <?php
        }
        ?>


        <div class="modal fade" id="modifiermotpass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content ">
                    <div class="modal-header" style="text-align:center;">
                        <h2 class="modal-title">
                            Modifier Mot de passe
                        </h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="pass">Ancien mot de passe</label>
                            <input type="password" class="form-control" id="amotdepass" placeholder="Votre ancien mot de passe" require>
                        </div>
                        <div class="form-group">
                            <label for="pass">Nouveau mot de passe</label>
                            <input type="password" class="form-control" id="nmotdepass" placeholder="Votre nouveau mot de passe" require>
                        </div>
                        <div class="form-group">
                            <label for="pass">  Confirm nouveau  mot de passe</label>
                            <input type="password" class="form-control" id="cmotdepass" placeholder="Confirm nouveau mot de passe" require>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"  class="btn btn-primary" id= "applyModification_motpass" >enregistrer</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(function () {
                var page = "", annee = "", amotdepass = "", nmotdepass = "", cmotdepass = "";
                // By default je charge la page service non complet
                post({
                    param: "index_statistique"
                });
                //_________quand je clique sur boutton logout on revient a la page de connexion___________________
                $(".disco").click(function () {
                    $.ajax({
                        url: "../controller/user.php",
                        type: 'POST',
                        data: {
                            param: 'deconnexion'
                        },
                    }).done(function () {
                        window.location.href = "connexion.php";
                    });
                });
                //____________________________________________________
                $(".xmenuleft").click(function () {
                    clear_blue();
                    $(this).addClass("w3-blue");
                });


                //____________________________________________________


                //post cest une fonciton qui appel $.post ajax (ajax permet de faire des aller retour cote serveur sans charger notre page) 
                // afin de charger la bonne page dans notre child_template () cest lespace gris
                // kifach katkhdam ?
                // declenche un event click sur la class navigate_link
                // je recup le variable dans data-page 
                // avec ce vairable je l'utulise dans controller dashboard
                // pour determiner quelle page je doit afficher ou charger
                $(".navigate_link").click(function () {
                    page = $(this).data("page"); // determine la page inclut dans data
                    post({
                        param: page
                    });
                });


                $("#changeAnnee").change(function () {
                    annee = $(this).val();
                    // chaque class navigate_link kina fi code 
                    // kider liha test ?
                    // le test cest wach fik w3-blue
                    // si oui  3amar page 

                    $(".navigate_link").each(function () {
                        if ($(this).hasClass("w3-blue")) {
                            page = $(this).data("page");
                        }
                    });
                    post({
                        param: page,
                        annee: annee
                    });

                });
                $("#applyModification_motpass").click(function () {
                    amotdepass = $("#amotdepass").val();
                    nmotdepass = $("#nmotdepass").val();
                    cmotdepass = $("#cmotdepass").val();

                    if (nmotdepass === cmotdepass) {
                        var arg = {param: "modifier_motdepass", ancien: amotdepass, nouveau: nmotdepass};
                        $.post("../controller/user.php", arg, function (data) {
                            if (JSON.parse(data).motdepass === "null") {
                                alert(" un problème est survenu ! Vérifier votre ancien mot de passe.");
                            }
                            else {
                                $('#modifiermotpass').modal('toggle');
                            }
                        });

                    } else {
                        alert("Mot de passe sont incorrect");
                    }

                });



                function post(param) {
                    $.post("../controller/dashboard.php", param, function (data) {
                        $("#child_template").html(data);
                    });
                }
                function clear_blue() {
                    // set value -1 pour la select anneee -- 
                    $("#changeAnnee").val("2015");
                    $(".xmenuleft").removeClass("w3-blue");
                }
            });



        </script>

