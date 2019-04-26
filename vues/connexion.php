<link rel="icon" href="../lib/img/upec2.png" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="../lib/projet_css/connexion.css">
<script src="https://code.jquery.com/jquery-3.4.0.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


<div class="login">
    <h1><img src="../lib/img/upec.png"> </h1>
    <form method="post" action="../controller/user.php">
        <input type="text" name="login" placeholder="login" required="required" />
        <input type="password" name="pass" placeholder="mot de passe" required="required" />
        <button type="submit" name='param' value="connexion" class="btn btn-primary btn-block btn-large">se connecter.</button>
 

    </form>
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