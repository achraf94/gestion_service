<select id="annee_g">
<option value="2015">2015</option>
<option value="2016">2016</option>
</select>
<select  id="modules_g">

</select>

<select  id="gtypes_g">

</select>

<script src="../../lib/node_modules/jquery/dist/jquery.js"></script>
<script>
$(function(){
    $("#annee_g").change(function(){
        var annee = $(this).val();
        $.post("../../controller/affectation.php",{param:"bghitmodule",annee:annee},function(data){
            
            for(var i = 0;i<JSON.parse(data).length ; i++){
               // console.log(JSON.parse(data)[i].intitule); 
            }
        });
    });
    $("#modules_g").change(function(){
        console.log($(this).val());
    });

});
</script>
<div>


</div>
