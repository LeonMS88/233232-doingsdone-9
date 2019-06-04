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

//Выполнение запроса на получение списка проектов и списка задач
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
    
    $task = $_POST;
    $required = ['name', 'progect'];
    $dict = ['name' => 'Название', 'progect' => 'Проект', 'date' => 'Дата','file' => 'Файл'];
    $errors = [];

//Проверка что поле с названием проекта заполненно
    foreach ($required as $key) {
		if (empty($_POST[$key])) {
            $errors[$key] = "Заполните обязательное поле";
		}
	}

//Проверка что проект выбран
    if (empty($task['progect'])) {
        $errors['progect'] = 'Выберите проект';
    }


//Проверка что выбранная дата соответсвует параметрам
    if (!empty($task['date']) && !is_date_valid($task['date']) || $task['date'] < date('Y-m-d')) {
        $errors['date'] = "Выберете корректную дату";
    }

//Проверка что файл загружен 
    if (isset($_FILES['file'])) {
        $file_name = $_FILES['file']['name'];
        $file_path = __DIR__ . '/uploads/';
        $file_url = '/uploads/' . $file_name;
        move_uploaded_file($_FILES['file']['tmp_name'], $file_path . $file_name);
    }

//Проверка на ошибки в форме 
    if (count($errors)) {
		$errors['error'] = "Пожалуйста, исправьте ошибки в форме";
    }

//Добавление задачи в БД    
    if (!count($errors)) {
        if (!$file_name) {
            $file_url = NULL;
        }
		$sql = "INSERT INTO task (task_name, task_file, task_create, task_deadline, task_completed, user_id, progect_id)
                VALUE(?, ?, NOW(), ?, 0, '$user_id', ?)";
        $stmt = db_get_prepare_stmt($link, $sql, [$task['name'], $file_url, $task['date'], $task['progect']]);
        $res = mysqli_stmt_execute($stmt);
        if ($res) {
            header('Location: index.php');
        }   
    }
}



$form_task= include_template ('form-task.php', ['progect' => $progect, 'task' => $task, 'required' => $required, 'dict' => $dict, 
                                               'errors' => $errors, 'user_name' => $user_name, 'user_id' => $user_id, ]);

$layout_content = include_template ('layout.php', ['progect' => $progect, 'progect_id' => $progect_id, 'user_id' => $user_id,
                                                   'user_name' => $user_name, 'task_list' => $task_list, 'num_count' => $num_count, 
                                                   'main_content' => $form_task, 'title' => 'Дела в Порядке']);

print($layout_content);

} else {
    $guest_content = include_template('guest.php');
    $layout_content = include_template('layout.php', ['main_content' => $guest_content,'title' => 'Дела в Порядке']);
    print($layout_content);
}