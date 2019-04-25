<!DOCTYPE html>
<html>
    <title>Apps</title>
    <meta charset="UTF-8">
    <link rel="icon" href="../lib/img/upec2.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../lib/node_modules_extern/w3/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="../lib/node_modules/@fortawesome/fontawesome-free/css/all.css">
    <link rel="stylesheet" href="../lib/node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="../lib/projet_css/header.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <script src="../lib/node_modules/jquery/dist/jquery.js"></script>
    <script src="../lib/node_modules/bootstrap/dist/js/bootstrap.js"></script>
    <script src="../lib/node_modules/sweetalert/dist/sweetalert.min.js"></script>

    <?php
    session_start();
    include '../config/db_config.php';
    $enseignant = array();
    if (!isset($_SESSION["statu"])) {
    header("location:connexion.php");
    }
//selectionner le ID de user 
    $param = array("uid" => $_SESSION['user_info'][0]['uid']);
    //selectionner les donnees de cet utilisateur 
    //select * from user where uid=$param
    $enseignant = select_with_param($param, "enseignants");
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
                    <option value="-1">--</option>
                   
                    <option>2016</option>
                    <option>2015</option>

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
                    <a href="#" class="w3-bar-item w3-button" title="mdpupdate "><i class="fas fa-key"></i></a>
                    <?php
                       if($role=="admin"){?>
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
                <a href="#" data-page="index_statistique" class="navigate_link w3-blue w3-bar-item w3-button w3-padding xmenuleft">
                    <i class="fas fa-clipboard fa-fw w3-text-dark-grey"></i>
                    SERVICE NON-COMPLET
                </a>

                <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
                <a href="#" data-page="enseignant" class="navigate_link w3-bar-item w3-button w3-padding xmenuleft"><i class="fa fa-users fa-fw w3-text-green"></i> ENSEIGNANTS</a>
                <a href="#" data-page="groupe" class="navigate_link w3-bar-item w3-button w3-padding xmenuleft"><i class="fa fa-layer-group fa-fw w3-text-purple"></i> GROUPES</a>
                <a href="#" data-page="module" class="navigate_link w3-bar-item w3-button w3-padding xmenuleft"><i class="fa fa-book-open fa-fw w3-text-yellow"></i> MODULES</a>

                <?php
                if($role=="admin"){
                ?>
                 <a href="#" data-page="gtype" class="navigate_link w3-bar-item w3-button w3-padding xmenuleft"><i class="fas fa-swatchbook"></i>GTYPES</a>
                <a href="#" data-page="affectation" class="navigate_link w3-bar-item w3-button w3-padding xmenuleft"><i class="fas fa-dice-d20 fa-fw w3-text-aqua"></i> AFFECTATION</a>
                <?php } ?>
            </div>

        </nav>

        <script>
            $(function () {
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
                var page = "";
                var annee = "";
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
            });


            function post(param) {
                $.post("../controller/dashboard.php", param, function (data) {
                    $("#child_template").html(data);
                });
            }
            function clear_blue() {
                    // set value -1 pour la select anneee -- 
                    $("#changeAnnee").val(-1);
                    $(".xmenuleft").removeClass("w3-blue");
                }
        </script>