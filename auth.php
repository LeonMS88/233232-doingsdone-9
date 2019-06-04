<?php

include 'functions.php';

session_start();

//Соединение с БД
$link = mysqli_connect('127.0.0.1', 'root', '', 'data_233232');

//Установка кодировки в utf8
mysqli_set_charset($link, "utf8");

//Проверка соединения
if (!$link) {
    print('Ошибка подключения: ' . mysqli_connect_error());
}

//Проверка что форма была отправленна
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $form = $_POST;
	$required = ['email', 'password'];
    $errors = [];
    
    //Проверка что поле формы заполнено
    foreach ($required as $key) {
		if (empty($form[$key])) {
            $errors[$key] = "Заполните обязательное поле";
		}
    }

    //Найдем в таблице user пользователя с переданным email
    $email = mysqli_real_escape_string($link, $form['email']);
	$sql = "SELECT * 
            FROM user
            WHERE user_email = '$email'";
	$res = mysqli_query($link, $sql);

    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

    //Проверяем, что сохраненный хеш пароля и введенный пароль из формы совпадают
    if (!count($errors) and $user) {
		if (password_verify($form['password'], $user['user_password'])) {
			$_SESSION['user'] = $user;
        } else {
			$errors['password'] = 'Вы ввели неверный e-mail/пароль';
		}
	} else {
		$errors['email'] = 'Вы ввели неверный e-mail/пароль';
	}

    //Проверка на ошибки в форме 
    if (count($errors)) {
        $errors['error'] = "Пожалуйста, исправьте ошибки в форме";
        $auth_content = include_template('auth.php', ['form' => $form, 'errors' => $errors]);
    } else {
		header("Location: /index.php");
		exit();
	}
} else {
    if (isset($_SESSION['user'])) {
        $auth_content = include_template('index.php', ['username' => $_SESSION['user']['name']]);
    } else {
        $auth_content = include_template('auth.php', []);
    }
}

$layout_content = include_template('layout.php', ['main_content' => $auth_content, 'title' => 'Дела в Порядке']);

print($layout_content);