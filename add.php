<?php
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

//Массив проектов
    $sql = 'SELECT progect_id, progect_name, COUNT(t.task_name) 
            FROM progect 
            JOIN task 
            ON task.project_id = p.project_id 
            WHERE user_id = 3 
            GROUP BY p.project_id';
    $result = mysqli_query($link, $sql);
    if($result) {
        $progect = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

//Проверка что форма была отправленна
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $tasks = $_POST;
    $required = ['name', 'project', 'date', 'file'];
    $dict = ['name' => 'Название', 'project' => 'Проект', 'date' => 'Дата','file' => 'Файл'];
    $errors = [];

//Проверка что поле с названием проекта заполненно
    foreach ($required as $key) {
		if (empty($_POST[$key])) {
            $errors[$key] = "Введите название";
		}
	}

//Проверка что выбранный проект соответствует проекту из БД
    foreach ($progect as $value) {
        if ($value["progect_id"] === empty($_POST["project"])) {
            $errors["project"] = "Выберете проект";
        }
    }

//Проверка что выбранная дата соответсвует параматрам
    if (!empty($task['date'])) {
		if (!is_date_valid($task['date']) || $task['date'] < date('Y-m-d')) {
			$errors['date'] = "Выберете дату";
		}
    }
    
//Проверка что файл загружен 
    if (isset($_FILES['file']['name'])) {
        $tmp_name = $_FILES['file']['tmp_name'];
        $path = $_FILES['file']['name'];
        move_uploaded_file($tmp_name, __DIR__ . '/' . $path);
        $file = __DIR__ . '/' . $path;
    } 
}

include 'functions.php';

$form_content = include_template ('form.php', ['progect' => $progect, 'tasks' => $tasks, 'task' => $task, 'required' => $required, 'dict' => $dict, 'errors' => $errors]);

$layout_content = include_template ('layout.php', ['progect' => $progect, 'progect_id' => $progect_id,
                                                   'task_list' => $task_list, 'num_count' => $num_count, 
                                                   'main_content' => $form_content, 'title' => 'Дела в Порядке']);

print($layout_content);