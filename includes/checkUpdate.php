<?php
    session_start();

    require ($_SERVER['DOCUMENT_ROOT'].'/includes/connect.php');

    if(isset($_POST['update'])) {
        $owner = $_SESSION['user']['login'];
        $post_pos = $_POST['pos'];
        $post_name = $_POST['name'];
        $post_url = $_POST['url'];
        $row_id = $_POST['update'];
        $row_pos = $_POST['row_pos'];

        if($post_pos > $_POST['num_rows']) {
            $post_pos = $_POST['num_rows'];
        }

        if($post_pos < $row_pos) {
            mysqli_query($connect,
                "UPDATE `menu` SET `pos`=`pos` + 1
                WHERE `owner`='$owner' AND
                `pos` BETWEEN '$post_pos' AND '$row_pos'");
        }
        else {
            if ($post_pos > $row_pos) {
                mysqli_query($connect,
                "UPDATE `menu` SET `pos`=`pos` - 1
                WHERE `owner`='$owner' AND
                `pos` BETWEEN '$row_pos' AND '$post_pos'");
            }
        }
        $result = mysqli_query($connect,
                "UPDATE `menu` SET `name`='$post_name', `url`='$post_url', `pos`='$post_pos'
                WHERE `owner`='$owner' AND
                `id`='$row_id'");

        if (!$result) {
            mysqli_close($connect);
            die('<p>Произошла ошибка обновления таблицы</p>');
        }
        else {
            mysqli_close($connect);
            $_SESSION['message'] = 'Запись успешно обновлена';
            header('location: ../menu.php');
        }
    }

    if(isset($_POST['add'])) {
        $owner = $_SESSION['user']['login'];
        $name = $_POST['name'];
        $url = $_POST['url'];
        $pos = $_POST['add'];

        $result = mysqli_query($connect,
            "INSERT INTO `menu` (`owner`, `name`, `url`, `pos`)
            VALUES ('$owner', '$name', '$url', '$pos')");
        
        if (!$result) {
            mysqli_close($connect);
            die('<p>Произошла ошибка обновления таблицы</p>');
        }
        else {
            mysqli_close($connect);
            $_SESSION['message'] = 'Запись успешно добавлена';
            header('location: ../menu.php');
        }
    }
?>