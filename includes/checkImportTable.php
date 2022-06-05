<?php
    session_start();

    function can_upload($file) {
        // если имя пустое, значит файл не выбран
        if($file['name'] == '') {
            $_SESSION['message'] = 'Файл не выбран';
            return '';
        }
        
        /* если размер файла 0, значит его не пропустили настройки 
        сервера из-за того, что он слишком большой */
        if($file['size'] == 0) {
            $_SESSION['message'] = 'Файл слишком большой';
            return '';
        }
        
        // разбиваем имя файла по точке и получаем массив
        $getMime = explode('.', $file['name']);
        // нас интересует последний элемент массива - расширение
        $mime = strtolower(end($getMime));
        // объявим допустимые расширения
        $type = 'xml';
        
        if($mime != $type) {
            $_SESSION['message'] = 'Недопустимый тип файла';
            return '';
        }
        return $mime;
    }

    function insert($array, $table) {
        $rows = array(
            'users' => '(`login`, `password`, `name`, `email`)',
            'images' => '(`owner`, `name`, `description`, `original`, `marked`, `marked_little`)',
            'menu' => '(`owner`, `name`, `url`, `pos`)',
        );

        $row = $rows[$table];

        $query = "INSERT INTO `$table` $row VALUES ";

        $count = count($array);
        for ($i = 0; $i < $count; $i++) { 
            if ($i > 0) $query .= ', ';
            $query .= "('".implode("', '", $array[$i])."')";
        }

        require ($_SERVER['DOCUMENT_ROOT'].'/includes/connect.php');

        $result = mysqli_query($connect, $query);

        mysqli_close($connect);
        return $result;
    }

    $type = can_upload($_FILES['file']);
    
    if ($type == '') {
        header('location: ../index.php');
    }

    $name_orig = $_FILES['file']['name'];
    $path_orig = '/xml/'.time().$name_orig;
    move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$path_orig);

    $xmlData = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].$path_orig);
    $xmlData = $xmlData -> database;

    $users = array();
    $images = array();
    $menu = array();
    $i = 0;
    $j = 0;
    $k = 0;
    foreach ($xmlData->table as $table) {
        if ($table['name'] == 'users') {
            $users[$i]['login'] = $table->column[0];
            $users[$i]['password'] = $table->column[1];
            $users[$i]['name'] = $table->column[2];
            $users[$i]['email'] = $table->column[3];
            $i++;
        }
        if ($table['name'] == 'images') {
            $images[$j]['owner'] = $table->column[1];
            $images[$j]['name'] = $table->column[2];
            $images[$j]['description'] = $table->column[3];
            $images[$j]['original'] = $table->column[4];
            $images[$j]['marked'] = $table->column[5];
            $images[$j]['marked_little'] = $table->column[6];
            $j++;
        }
        if ($table['name'] == 'menu') {
            $menu[$k]['owner'] = $table->column[1];
            $menu[$k]['name'] = $table->column[2];
            $menu[$k]['url'] = $table->column[3];
            $menu[$k]['pos'] = $table->column[4];
            $k++;
        }
    }

    $result = insert($users, 'users');

    if (!$result) {
        $_SESSION['message'] = 'Не удалось вставить таблицу users';
        header('location: ../index.php');
        die;
    }

    $result = insert($images, 'images');

    if (!$result) {
        $_SESSION['message'] = 'Не удалось вставить таблицу images';
        header('location: ../index.php');
        die;
    }

    $result = insert($menu, 'menu');

    if (!$result) {
        $_SESSION['message'] = 'Не удалось вставить таблицу menu';
        header('location: ../index.php');
        die;
    }

    $_SESSION['message'] = 'Таблицы успешно импортированы';
    header('location: ../index.php');
?>