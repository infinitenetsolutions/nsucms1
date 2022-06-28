<?php 

if ($_POST["action"] == "delete_prospectus") {
    $delete_id = $_POST["delete_id"];
    if (!empty($delete_id)) {
        $sql = "UPDATE `tbl_prospectus` 
                    SET 
                    `status` = '$trash' 
                    WHERE `status` = '$visible' && `id` = '$delete_id';
                    ";
        if ($con->query($sql))
            echo 'success';
        else
            echo 'error';
    } else
        echo 'empty';
}