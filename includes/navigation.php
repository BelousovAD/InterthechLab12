<nav class = "navigation">
    <?php
        require ($_SERVER['DOCUMENT_ROOT'].'/includes/connect.php');

        $login = $_SESSION['user']['login'];

        $result = mysqli_query($connect,
            "SELECT * FROM `menu`
            WHERE `owner`='$login'
            ORDER BY `pos`");
        mysqli_close($connect);

        if (mysqli_num_rows($result) > 0)
            while ($row = mysqli_fetch_array($result)) {
                echo '<a href="'.$row['url'].'" class="nav_buttons">'.$row['name'].'</a>';
            }
        else
            echo '<p>Ошибка загрузки</p>';
    ?>
    <a href="menu.php" class="nav_buttons">Настройка меню</a>
</nav>
