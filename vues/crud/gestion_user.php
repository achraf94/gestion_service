<?php
session_start();
include '../config/db_config.php';

$ListUser = select("users");
$role = $_SESSION['user_info'][0]['role'];
$uid = $_SESSION['user_info'][0]['uid'];
?>
<!-- Header -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Gestion Utilisateur</b></h5>
    <?php if ($role == "admin") { ?>
        <button class="w3-button  w3-blue w3-right "><i class="fa fa-user-plus"></i></button>
    <?php }
    ?>
</header>
<div class="w3-margin">

    <table class="table w3-white">
        <thead class="w3-black">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Login</th>
                <th scope="col">Role</th>
                <th scope="col"></th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($ListUser as $user) { ?>
                <tr class="w3-small">
                    <th scope="row"><?php echo $user["uid"]; ?></th>
                    <td><?php echo $user["login"]; ?></td>
                    <td><?php echo $user["role"]; ?></td>
                    <td style="width: 100px;">
                        <div class="w3-small">
                            <?php if ($uid == $user['uid'] || $role == "admin") { ?>
                                <button class="w3-white"><i class="fas fa-user-edit w3-text-green"></i></button>
                            <?php } ?>

                            <?php if ($role == "admin") { ?>
                                <button class="w3-white"><i class="fas fa-trash-alt w3-text-red"></i></button>
                                <?php } ?>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</div>
