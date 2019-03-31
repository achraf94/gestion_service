    <?php
    session_start();
    require('../config/db.php');
    $db = db::getInstance();
    include '../config/fun_enseignant.php';
    include '../config/fun_etype.php';

    $Listenseignant = select_ens();
    $role = $_SESSION['user_info'][0]['role'];
    ?>
    <!-- Header -->
    <header class="w3-container" style="padding-top:22px">
        <h5><b><i class="fa fa-dashboard"></i> Enseignant </b> </h5>
        <?php if ($role == "admin") { ?>
        <button class="w3-button  w3-blue w3-right "><i class="fa fa-user-plus"></i></button>
        <?php 
    } ?>
    </header>
    <div class="w3-row-padding w3-margin-bottom">

        <div class="row">
            <?php

            foreach ($Listenseignant as $row) {
                $data = array("etid" => $row["etid"]);
                $etyp_value = select_with_param($data, "nbh");
                $pic = !empty(trim($row["pic"])) ? $row["pic"] : "default.png";
                ?>
            <div style="height:270px;" class="col-xs-6 col-md-2 icard w3-white w3-margin w3-border w3-round-xlarge" data-idEnseignant="<?php echo $row["eid"]; ?>">
                <div class="card w3-center">
                    <h5 class="card-title w3-left"><?php echo  $row["annee"]; ?></h5>
                    <h5 class="card-title w3-right"><?php echo  $etyp_value[0]["nbh"]; ?>H</h5>

                    <img src="../lib/img/user/<?php echo $pic; ?>" class="card-img-top img-2">
                    <div class=" card-body">
                        <h5 class="card-title w3-center"><?php echo $row["nom"] . " " . $row["prenom"]; ?></h5>
                        <h5 class="card-title  link_ka"><i class='fa fa-mobile-alt w3-text-black'></i> <?php echo $row["tel"]; ?></h5>
                        <h5 class="card-title "> <i class='fa fa-at w3-text-black'></i> <?php echo $row["email"] ?></h5>
                    </div>
                </div>
                <?php if ($role == "admin") { ?>
                <div class="w3-center w3-animate-zoom action ">
                    <i class="delete fa fa-trash-alt w3-text-red position-absolute w3-button  w3-circle"></i>
                    <i class="edit fa fa-pencil-alt w3-text-green position-absolute w3-button  w3-circle"></i>
                </div>
                <?php 
            } ?>
            </div>

            <?php 
        }
        ?>
        </div>


    </div>

    <script>
        $(function() {
            var id = "";
            $(".delete").click(function() {
                id = $(this).parents("div.icard").data('idenseignant');

            });
        });
    </script> 