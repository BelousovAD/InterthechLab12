<?php
    $id = $_POST['delete'];

    require ($_SERVER['DOCUMENT_ROOT'].'/includes/connect.php');

    $result = mysqli_query($connect,
        "SELECT `original`, `marked`, `marked_little` FROM `images`
        WHERE `id`='$id'");
    
    $num_rows = mysqli_num_rows($result);
    
    if ($num_rows == 0) {
        mysqli_close($connect);
        die('<p>Записи в БД отсутствуют</p>');
    }
    else {
        $row = mysqli_fetch_array($result);

        unlink($_SERVER['DOCUMENT_ROOT'].$row['original']);
        unlink($_SERVER['DOCUMENT_ROOT'].$row['marked']);
        unlink($_SERVER['DOCUMENT_ROOT'].$row['marked_little']);

        $result = mysqli_query($connect,
            "DELETE FROM `images` WHERE `id`='$id'");

        if (!$result) {
            mysqli_close($connect);
            die('<p>Записи в БД отсутствуют</p>');
        }
        else {
            mysqli_close($connect);
            $_SESSION['message'] = 'Запись успешно удалена';
            header('location: ../gallery.php');
        }
    }
?>