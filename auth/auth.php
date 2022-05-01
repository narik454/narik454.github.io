<?php 
session_start();

if ($_POST['log'] == "" || $_POST['pass'] == "") {
    
        include 'auth.html';
        echo "Введите логин/пароль!";
        exit();
}

if (!preg_match(@"/^[a-zA-Z][a-zA-Z\d_]*$/", $_POST['log'])) {
        include 'auth.html';
        echo "Введите корректный логин/пароль!";
        exit();
}

$link = mysqli_connect("localhost", "root", "", "dbhosting");

if (mysqli_connect_errno()) {
    include 'auth.html';
    echo "Ошибка соединения. Попробуйте познее.";
    exit();
}

mysqli_set_charset($link, 'utf8');

$login = mysqli_real_escape_string($link, filter_input(INPUT_POST, 'log', FILTER_SANITIZE_STRING));
$pass = md5(mysqli_real_escape_string($link, filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_SPECIAL_CHARS)));
$spass = isset($_POST['savepass']);

$sql = " SELECT COUNT(*) as Count FROM users WHERE login = '$login'";
$result = mysqli_fetch_array(mysqli_query($link, $sql))['Count'];
if (!$result){
    include 'auth.html';
    echo "Пользователь не найден!";
    exit();
}

$sql = "SELECT password FROM users WHERE login = '$login'";
$result = mysqli_query($link, $sql);


if ($pass != mysqli_fetch_array($result)['password']) {
    include 'auth.html';
    echo "Неправильный логин/пароль!";
    exit();
}

$sql = "SELECT id FROM users WHERE login = '$login'";
$_SESSION['u_id'] = intval(mysqli_fetch_array(mysqli_query($link, $sql))['id']);

$_SESSION['loggedin'] = 1;
$_SESSION['login'] = $login;

include 'logged_in.php';
?>