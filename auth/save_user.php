<?php
session_start();

if ($_POST['log'] == "" || $_POST['pass'] == "") {
    
        include 'reg.html';
        echo "Введите логин/пароль!";
        exit();
}

if (!preg_match(@"/^[a-zA-Z][a-zA-Z\d_]{2,20}/", $_POST['log'])) {
        include 'reg.html';
        echo "Выберите корректный логин!";
        exit();
}

if (!preg_match(@"/[a-zA-Z\d_()@#%$]{4,30}/", $_POST['pass'])) {
        include 'reg.html';
        echo "Выберите корректный пароль!";
        exit();
}

$link = mysqli_connect("localhost", "root", "", "dbhosting");
if (mysqli_connect_errno()) {
    include 'reg.html';
    echo "Ошибка соединения. Попробуйте познее.";
    exit();
}
mysqli_set_charset($link, 'utf8');

$login = mysqli_real_escape_string($link, filter_input(INPUT_POST, 'log', FILTER_SANITIZE_STRING));
$pass = md5(mysqli_real_escape_string($link, filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_SPECIAL_CHARS)));

$sql = "SELECT COUNT(*) as Count FROM users WHERE login = '$login'";
$result = mysqli_fetch_array (mysqli_query($link, $sql))['Count'];
if ($result != 0){
	include 'reg.html';
	echo 'Пользователь с данным логином уже зарегистрирован!';
	exit();
}

$sql = "INSERT INTO `users`(`login`, `password`) VALUES ('$login','$pass')";
$result = mysqli_query($link, $sql);

if (!$result){
	include 'reg.html';
	echo 'Ошибка регистрации. Попробуйте позже.';
	exit();
}

$sql = "SELECT id FROM users WHERE login = '$login'";
$_SESSION['u_id'] = intval(mysqli_fetch_array(mysqli_query($link, $sql))['id']);

$_SESSION['loggedin'] = 1;
$_SESSION['login'] = $login;

include 'logged_in.php';
?>