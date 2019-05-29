<?php

include 'functions.php';

//Соединение с БД
$link = mysqli_connect('127.0.0.1', 'root', '', 'data_233232');

//Установка кодировки в utf8
mysqli_set_charset($link, "utf8");

//Проверка соединения
if (!$link) {
    print('Ошибка подключения: ' . mysqli_connect_error());
}

//Проверка что форма была отправленна
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $form = $_POST;
    $required = ['name', 'email', 'password'];
    $errors = [];

    //Проверка что поле формы заполнено
    foreach ($required as $key) {
		if (empty($form[$key])) {
            $errors[$key] = "Заполните обязательное поле";
		}
    }

    //Проверка что значение из поля «email» является валидным и есть ли пользователь с таким «email»
    if (filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
        
        $email = mysqli_real_escape_string($link, $form['email']);
        
        $sql = "SELECT user_id
                FROM user 
                WHERE user_email = '$email'";
        $res = mysqli_query($link, $sql);
        if (mysqli_num_rows($res) > 0) {
            $errors['email'] = 'Пользователь с этим e-mail уже зарегистрирован';
        } else { 
            //Преобразуем пароль в хеш и добавим нового пользователя в БД
            $password = password_hash($form['password'], PASSWORD_DEFAULT);
            $sql = 'INSERT INTO user (user_name, user_email, user_password, user_add) 
                    VALUES (?, ?, ?, NOW())';
            $stmt = db_get_prepare_stmt($link, $sql, [$form['name'], $form['email'], $password]);
            
            $res = mysqli_stmt_execute($stmt);
            if ($res && empty($errors)) {
                header("Location: index.php");
                exit();
            }
        }
    } else {
        $errors['email'] = 'Введите корректный e-mail';
    }

    //Проверка на ошибки в форме 
    if (count($errors)) {
		$errors['error'] = "Пожалуйста, исправьте ошибки в форме";
    }
}

$reg_content = include_template ('reg.php', ['form' => $form, 'errors' => $errors]);

$layout_content = include_template ('register.php', ['register_content' => $reg_content, 'title' => 'Дела в Порядке']);

print($layout_content);