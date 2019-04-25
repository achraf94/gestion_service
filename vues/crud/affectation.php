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
$Listenseignant = array();
$allEnsg = "select * from enseignants ";
$i = 0;
$j = 0;
$ListGTYPE = select("gtypes");


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
                    <div class="w3-center" title="action">
                        <button data-idenseignant="<?php echo $row["eid"]; ?>" class="w3-btn show-groups w3-circle btn-primary"> <i class="fas fa-layer-group w3-text-black"></i></button>
                        <button data-idenseignant="<?php echo $row["eid"]; ?>" data-nom="<?php echo $row["nom"]; ?>" type="button" data-toggle="modal" data-target="#add_affect"class="w3-btn w3-circle  btn-primary prepareAdd"> <i class="fas fa-plus w3-text-white"></i></button>

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
<div class="w3-row-padding w3-margin-bottom" id="">
    <div class="row">
        <div id="groupes"></div>
    </div>
</div>


                    <!-- show-groups cest une class qui permet d'appliquer un EVENT : Click -->
<script>
    $(function () {
        var ide,annee,myfunction,arg;
        $(".show-groups").click(function () {
             ide = $(this).data("idenseignant");
             annee = $("#changeAnnee").val();
             myfunction = function (data) {
                $("#groupes").html(data);
            }
            arg = {ide: ide, annee: annee, param: "listGroup_affecter"};
            post(arg,myfunction);
        });
        $('.prepareAdd').click(function(){
            $("#NomAfected").text($(this).data("nom"));
            ide = $(this).data("idenseignant");
            $("#id_ens").val(ide);
             myfunction = function (data) {
                for(var i = 0 ; i< JSON.parse(data).length ;i++){
                    $("#group_af").append("<option value='"+JSON.parse(data)[i].gid+"'>"+JSON.parse(data)[i].nom+" "+JSON.parse(data)[i].intitule+"</option>");
                }
            }
             arg = {ide: ide,annee:"2015", param: "listGroup_Nonaffecter"};
            post(arg,myfunction);
        });
        
        $("#affecter").click(function(){
            nbh = $("#nbh").val();
            ide = $("#id_ens").val();
            gid = $("#group_af").val();
            arg = {nbreheur:nbh,idenseignant:ide,groupeid:gid,param:"appliquer_affectation"};
            post(arg,null);
            alert("affectation a ete enregistree");
        });

        function post(param,Myfunction) {
            $.post("../controller/affectation.php", param,Myfunction);
        }
    });
</script>





<div id="add_affect" class="modal fade" role="dialog">
                 <div class="modal-dialog">
                     <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Affecter un nouveau groupe à Monsieur : <span class="w3-badge w3-green"id="NomAfected"></span></h4>
                        </div>
                        <div class="modal-body w3-center">
                            <select  class="form-control"id="group_af">
                            </select>
                            <input type="number" id="nbh">
                         </div>   
                         <div class="modal-footer">
                         <button type="button" class="btn btn-danger" data-dismiss="modal">close</button>
                            <button type="button" class="btn btn-suceess" id="affecter">Affecter</button>
                            <input type="hidden" id="id_ens">
                           
                        </div>         
                    </div>
                  </div>
</div>






