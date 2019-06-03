<?php

include 'functions.php';

session_start();

if (isset($_SESSION['user'])) {

//Показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

//Соединение с БД
$link = mysqli_connect('127.0.0.1', 'root', '', 'data_233232');

//Установка кодировки в utf8
mysqli_set_charset($link, "utf8");

$user_id = $_SESSION['user']['user_id'];
$user_name = $_SESSION['user']['user_name'];

//Проверка соединения
if (!$link) {
    print('Ошибка подключения: ' . mysqli_connect_error());
}

//Выполнение запроса на получение списка проектов
else {
    $sql = "SELECT p.progect_id, p.progect_name, COUNT(t.task_name)
            AS task_count
            FROM progect p
            LEFT JOIN task t
            ON t.progect_id = p.progect_id 
            WHERE p.user_id = '$user_id'
            GROUP BY p.progect_id";
    $result = mysqli_query($link, $sql);
    if($result) {
        $progect = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

//Проверка что форма была отправленна
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $progects = $_POST;
    $required = ['name'];
    $dict = ['name' => 'Название'];
    $errors = [];

//Проверка что поле с названием проекта заполненно
    foreach ($required as $key) {
		if (empty($_POST[$key])) {
            $errors[$key] = "Заполните обязательное поле";
		}
	}

//Проверка на ошибки в форме 
    if (count($errors)) {
		$errors['error'] = "Пожалуйста, исправьте ошибки в форме";
    }

//Добавление проекта в БД    
    if (!count($errors)) {
            $sql = "INSERT INTO progect (progect_name, user_id)
                    VALUE(?, '$user_id')";
            $stmt = db_get_prepare_stmt($link, $sql, [$progect['name']]);
            $res = mysqli_stmt_execute($stmt);
            if ($res) {
                header('Location: index.php');
            }  

    }
}



$form_project= include_template ('form-project.php', ['progect' => $progect, 'progects' => $progects, 'required' => $required, 'dict' => $dict, 
                                                   'errors' => $errors, 'progect_name' => $progect_name, 'user_id' => $user_id, ]);

$layout_content = include_template ('layout.php', ['progect' => $progect, 'progect_id' => $progect_id, 'user_id' => $user_id,
                                                   'progect_name' => $progect_name, 'task_list' => $task_list, 'num_count' => $num_count, 
                                                   'main_content' => $form_project, 'title' => 'Дела в Порядке']);

print($layout_content);

} else {
    $guest_content = include_template('guest.php');
    $layout_content = include_template('layout.php', ['main_content' => $guest_content,'title' => 'Дела в Порядке']);
    print($layout_content);
}