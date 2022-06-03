<?php
    session_start();

    function add_watermark($img, $text, $font, $r = 255, $g = 255, $b = 255, $alpha = 70) {
        //получаем ширину и высоту исходного изображения
        $width = imagesx($img);
        $height = imagesy($img);
        //угол поворота текста
        $angle =  -rad2deg(atan2((-$height),($width))); 
        
        //добавляем пробелы к строке
        $text = " ".$text." ";
        
        $c = imagecolorallocatealpha($img, $r, $g, $b, $alpha);
        $size = (($width+$height)/2)*2/strlen($text);
        $box  = imagettfbbox ( $size, $angle, $font, $text );
        $x = $width/2 - abs($box[4] - $box[0])/2;
        $y = $height/2 + abs($box[5] - $box[1])/2;
        
        //записываем строку на изображение
        imagettftext($img, $size ,$angle, $x, $y, $c, $font, $text);
        return $img;
    }

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
        // объявим массив допустимых расширений
        $types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');
        
        // если расширение не входит в список допустимых - return
        if(!in_array($mime, $types)) {
            $_SESSION['message'] = 'Недопустимый тип файла';
            return '';
        }
        return $mime;
    }

    if (!empty($_POST['name']) and !empty($_POST['description'])) {

        $type = can_upload($_FILES['file']);

        if ($type == '') {
            header('location: ../upload.php');
        }

        $name_orig = $_FILES['file']['name'];
        $path_orig = '/img/'.time().$name_orig;
        move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$path_orig);
        
        switch ($type) {
            case 'jpg':
                $img = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'].$path_orig);
                break;
            case 'png':
                $img = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].$path_orig);
                break;
            case 'gif':
                $img = imagecreatefromgif($_SERVER['DOCUMENT_ROOT'].$path_orig);
                break;
            case 'bmp':
                $img = imagecreatefrombmp($_SERVER['DOCUMENT_ROOT'].$path_orig);
                break;
            case 'jpeg':
                $img = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'].$path_orig);
                break;
        }

        $image_marked = add_watermark($img, $_SESSION['user']['name'], $_SERVER['DOCUMENT_ROOT'].'/includes/arial.ttf');
        $path_marked = '/img/'.time().'marked_'.$name_orig;
        imagejpeg($image_marked, $_SERVER['DOCUMENT_ROOT'].$path_marked);

        $image_marked_little = imagescale($image_marked, imagesx($image_marked) * 0.25);
        $path_marked_little = '/img/'.time().'marked_little_'.$name_orig;
        imagejpeg($image_marked_little, $_SERVER['DOCUMENT_ROOT'].$path_marked_little);

        require ($_SERVER['DOCUMENT_ROOT'].'/includes/connect.php');

        $owner = $_SESSION['user']['login'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $result = mysqli_query($connect,
            "INSERT INTO `images` (`owner`, `name`, `description`, `original`, `marked`, `marked_little`)
            VALUES ('$owner', '$name', '$description', '$path_orig', '$path_marked', '$path_marked_little')");
        mysqli_close($connect);

        if (!$result) {
            $_SESSION['message'] = 'Произошла ошибка загрузки';
            header('location: ../upload.php');
        }
        else {
            $_SESSION['message'] = 'Картинка успешно загружена';
            header('location: ../upload.php');
        }
    }
    else {
        $_SESSION['message'] = 'Заполнены не все поля';
        header('location: ../register.php');
    }
?>