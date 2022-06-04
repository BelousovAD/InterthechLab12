<?php
    session_start();

    require ($_SERVER['DOCUMENT_ROOT'].'/includes/connect.php');

    $owner = $_SESSION['user']['login'];
    $row_id = $_POST['delete'];
    $row_pos = $_POST['row_pos'];
    $num_rows = $_POST['num_rows'];

    mysqli_query($connect,
        "UPDATE `menu` SET `pos`=`pos` - 1
        WHERE `owner`='$owner' AND
        `pos` BETWEEN '$row_pos' AND '$num_rows'");
    
    $result = mysqli_query($connect,
        "DELETE FROM `menu`
        WHERE `id`='$row_id'");

    if (!$result) {
        mysqli_close($connect);
        die('<p>Записи в БД отсутствуют</p>');
    }
    else {
        mysqli_close($connect);
        $_SESSION['message'] = 'Запись успешно удалена';
        header('location: ../menu.php');
    }
?>