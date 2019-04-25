<?php
include '../config/db_config.php';
$idE = $_SESSION['enseignant_info'][0]['eid'];
$annee = $_SESSION["annee"];
if ($annee == "NULL") {
    $sql = "select * from groupes p where p.mid in (select mid from modules where eid = $idE) order by nom ";
} else {
    $sql = "select * from groupes p where p.mid in (select mid from modules where eid = $idE)  and annee = '$annee' order by nom ";
}

$Listgroupes = select_with_sql($sql);
$role = $_SESSION['user_info'][0]['role'];
?>

<!-- Header -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Groupe</b></h5>
    <?php if ($role == "admin") { ?>
        <button class="w3-button  w3-blue w3-right "><i class="fa fa-user-plus"></i></button>
    <?php }
    ?>
</header>
<div class="w3-row-padding w3-margin-bottom">

    <div class="row">
        <?php
        foreach ($Listgroupes as $row) {
            $data = array("gtid" => $row["gtid"]);
            $gtyp_value = select_with_param($data, "gtypes", "nbh,nom");
            $data = array("mid" => $row["mid"]);
            $module = select_with_param($data, "modules", "intitule");
            ?>
            <div style="height:270px;" class="col-xs-5 col-md-2 icard w3-white w3-margin w3-border w3-round-xlarge">
                <div class="card w3-center">
                    <h5 class="card-title w3-left"><?php echo $row["annee"]; ?></h5>
                    <h5 class="card-title w3-right"><?php echo $gtyp_value[0]["nbh"]; ?>H</h5>
                    <h5 class="card-title w3-center w3-text-blue "><?php echo $row["nom"]; ?></h5>
                    <img src="https://chemdoc.com/wp-content/uploads/2018/08/employee.png" class="card-img-top img-2">
                    <div class=" card-body">
                        <h5 class="card-title w3-center">  <?php echo $module[0]["intitule"] ?></h5>
                    </div>

                </div>
                <?php if ($role == "admin") { ?>
                    <div class="w3-center w3-animate-zoom action"> 
                        <i data-supprimer="<?php echo $row["gid"]; ?>" class="delete fa fa-trash-alt w3-text-red position-absolute w3-button "></i>
                        <i data-modifier="<?php echo $row["gid"]; ?>" data-mid="<?php echo $row["mid"]; ?>" data-nom="<?php echo $row["nom"]; ?>" class="edit fa fa-pencil-alt w3-text-green position-absolute w3-button " data-toggle="modal" data-target="#ModfidierGroup"></i>
                    </div>
                <?php }
                ?>
            </div>

            <?php
        }
        ?>
    </div>


</div>
<div id="ModfidierGroup" class="modal fade" role="dialog">
                 <div class="modal-dialog">
                     <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"> Modifier group</h4>
                        </div>

                        <div class="modal-body">
                            formulaire | module | nom | annee | gtid
                            <input type="text" id="nom">
                            <select id="module_modifier">
                            <?php foreach(select("modules") as $row){?>
                                <option value="<?php echo $row["mid"];?>"><?php echo $row["intitule"];?></option>
                            <?php }?>
                            </select>
                            </div>

                        <div class="modal-footer">
                        <button type="button" class="btn btn-default">Modifier</button>
                        <input type="hidden" id="IdGroupAmodifier">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
</div>
<script>
    $(function () {
        var id = "";
        // fonction delete
        $(".delete").click(function () {
            id = $(this).data('supprimer');
            // utiliser post pour declencher un aller au serveur 
            // utiliser un controller groupes 
            // envoyé des params au controller
            // parmis les parametre le id a supprimer
            // switch param
            // case supprimer
            // delete id => la requete qui supprimer
            // cets mieux de visualiser la requete avant lexeccute

            // delete(array("gid"=> $id),"table"); => delete from table where 
            if(confirm("voulez vous suppriemr se groupe")){
                $(this).parents("div.icard").animate({bottom:'202px'}, function(){
                      $(this).detach(); });
            //AJAX envois juste le id afin de supprimer le group 
             $.post("../controller/groupe.php",{param:"supprimer",id:id});

            }
 
         
        });
        // fonction modifier
        // Etape 1 preserver un ID group dans un input hidden
        $(".edit").click(function(){
            var id = $(this).data("modifier");
            $("#IdGroupAmodifier").val(id);
            $("#nom").val($(this).data("nom"));
            $("#module_modifier").val($(this).data("mid"));
            // remplir les imput
        });
    });
</script>