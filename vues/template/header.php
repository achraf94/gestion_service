<!DOCTYPE html>
<html>
<title>Apps</title>
<meta charset="UTF-8">
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

$param = array("uid" => $_SESSION['user_info'][0]['uid']);
$enseignant = select_with_param($param, "enseignants");
$role = $_SESSION['user_info'][0]['role'];
$name = $enseignant[0]['nom'] . " " . $enseignant[0]['prenom'];
?>

<body class="w3-light-grey">
    <!-- Top container -->
    <div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
        <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
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
                <span>Bonjour, <strong><?php echo  $name; ?></strong></span><br>
                <a href="#" class="w3-bar-item w3-button"><i class="fa fa-chart-line w3-text-orange"></i></a>
                <?php if ($role == "admin") { ?>
                <a href="#" class="w3-bar-item w3-button"><i class="fa fa-cog w3-text-red"></i></a>
                <?php 
            } ?>
            </div>
        </div>
        <hr>
        <div class="w3-container w3-teal w3-center">
            <header class="w3-container">
                <h5><b><i class="fa fa-dashboard"></i> TABLEAU DE BORD</b></h5>
            </header>

        </div>
        <div class="w3-bar-block">
            <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
            <a href="#" data-page="enseignant" class="navigate_link w3-bar-item w3-button w3-padding xmenuleft"><i class="fa fa-users fa-fw w3-text-green"></i> ENSEIGNANTS</a>
            <a href="#" data-page="groupe" class="navigate_link w3-bar-item w3-button w3-padding xmenuleft"><i class="fa fa-layer-group fa-fw w3-text-purple"></i> GROUPES</a>
            <a href="#" data-page="module" class="navigate_link w3-bar-item w3-button w3-padding xmenuleft"><i class="fa fa-book-open fa-fw w3-text-yellow"></i> MODULES</a>
        </div>

    </nav>

    <script>
        $(function() {
            //____________________________________________________
            $(".disco").click(function() {
                $.ajax({
                    url: "../controller/user.php",
                    type: 'POST',
                    data: {
                        param: 'deconnexion'
                    },
                }).done(function() {
                    window.location.href = "connexion.php";
                });
            });
            //____________________________________________________
            $(".xmenuleft").click(function() {
                clear_blue();
                $(this).addClass("w3-blue");
            });

            function clear_blue() {
                $(".xmenuleft").removeClass("w3-blue");
            }
            //____________________________________________________
            var page = "";
            $(".navigate_link").click(function() {
                page = $(this).data("page"); // determine la page inclut dans data
                $.post("../controller/dashboard.php", {
                    param: page
                }, function(data) {
                    $("#child_template").html(data);
                });
            });

        });
    </script> 