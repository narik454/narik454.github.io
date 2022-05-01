<?php

//session_start();

echo 'Добро пожаловать, '.$_SESSION['login'].'! <br />';
echo 'Ваш id: '.$_SESSION['u_id'].'<br />';
echo '<a href="/profile">Профиль</a> <br />';
echo '<a href="/auth/logout.php">Выход</a> <br />';
?>