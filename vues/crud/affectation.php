<style>
    /* The heart of the matter */
    .testimonial-group > .row {
        overflow-x: auto;
        white-space: nowrap;
    }
    .testimonial-group > .row > .col-xs-4 {
        display: inline-block;
        float: none;
    }

    .carre{
        width:30px;
        height:30px;
        padding-top: 2px;
    }

</style>
<?php
include '../config/db_config.php';
$annee = $_SESSION["annee"];
$Listenseignant = "";
$allEnsg = "select * from enseignants ";
$i = 0;
$j = 0;
if ($annee == "NULL") {
    $Listenseignant = select_with_sql($allEnsg);
} else {
    $Listenseignant = select_with_sql($allEnsg . " where annee = " . $annee);
}

$role = $_SESSION['user_info'][0]['role'];
?>
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Affectation </b> </h5>
</header>
<h3 class="w3-padding">Enseignants 
    <div class="w3-right w3-row ">
        <div class="carre w3-center w3-green countOfgreen"></div>
        <div class="carre w3-center w3-red countOfred"></div>
    </div>
</h3>
<div class="container testimonial-group ">
    <div class="row text-center w3-light-gray" style="margin-right:100px;">
        <?php
        foreach ($Listenseignant as $row) {
            
            $countOfAffectation = getOneColumn("select count(*) as SiAffecter from affectations where eid = " . $row["eid"], "SiAffecter");
            $color = "w3-green";
            if ($countOfAffectation > 0) {
                $color = "w3-red";
                $i++;
            } else {
                $j++;
            }
            ?>
            <div style="height:250px;" class="col-xs-4 col-md-2  <?php echo $color; ?> w3-margin w3-border w3-round-xlarge">
                <div class=" w3-center w3-padding">
                    <img src="../lib/img/user/default.png" class="card-img-top img-2">
                    <div class=" card-body">
                        <h5 class="card-title w3-center"><?php echo $row["nom"] . " " . $row["prenom"]; ?></h5>
                        <h5 class="card-title "><?php echo $row["annee"]; ?></h5>

                    </div>
                    <div class="w3-center">
                        <button data-idenseignant="<?php echo $row["eid"]; ?>" class="w3-btn show-groups w3-circle btn-primary"> <i class="fas fa-layer-group w3-text-black"></i></button>
                        <button class="w3-btn w3-circle  btn-primary"> <i class="fas fa-plus w3-text-white"></i></button>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="hide">
            <script>
                $(function () {
                    $(".countOfred").text(<?php echo $i; ?>);
                    $(".countOfgreen").text(<?php echo $j; ?>);
                });
            </script>
        </div>

    </div>
</div>
<h3 class="w3-padding">Groupes</h3>
<div class="container testimonial-group">
    <div class="row " style="margin-right:100px;margin-left:5px;">
        <div class="row" id="groupes"></div>
    </div>
</div>



<script>
    $(function () {
        $(".show-groups").click(function () {
            var ide = $(this).data("idenseignant");
            var annee = $("#changeAnnee").val();
            post({ide: ide, annee: annee, param: "listGroup"});


        });
        function post(param) {
            $.post("../controller/affectation.php", param, function (data) {
                $("#groupes").html(data);
            });
        }
    });
</script>