<?php

include 'functions.php';

//Показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

//Соединение с БД
$link = mysqli_connect('127.0.0.1', 'root', '', 'data_233232');

//Установка кодировки в utf8
mysqli_set_charset($link, "utf8");

//Проверка соединения
if (!$link) {
    print('Ошибка подключения: ' . mysqli_connect_error());
}

//Выполнение запроса на получение списка проектов и списка задач
else {
    $sql = 'SELECT t.progect_id, p.progect_name, COUNT(t.task_name)
            AS task_count
            FROM progect p
            LEFT JOIN task t
            ON t.progect_id = p.progect_id 
            WHERE p.user_id = 3
            GROUP BY p.progect_id';
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
            $errors[$key] = "Заполниет обязательное поле";
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
		$sql = 'INSERT INTO task (task_name, task_category, task_file, task_create, task_deadline, task_completed, user_id, progect_id)
                VALUE(?, ?, ?, NOW(), ?, 0, 3, 3)';
        $stmt = db_get_prepare_stmt($link, $sql, [$task['name'], $task['progect'], $task['date'], $file_url]);
        $res = mysqli_stmt_execute($stmt);
        if ($res) {
            print('QWERTY');
            header('Location: index.php');
        }   
    }
}



$form_content = include_template ('form.php', ['progect' => $progect, 'task' => $task, 'required' => $required, 'dict' => $dict, 'errors' => $errors]);

$layout_content = include_template ('layout.php', ['progect' => $progect, 'progect_id' => $progect_id,
                                                   'task_list' => $task_list, 'num_count' => $num_count, 
                                                   'main_content' => $form_content, 'title' => 'Дела в Порядке']);

print($layout_content);

