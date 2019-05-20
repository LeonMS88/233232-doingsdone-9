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
    $sql = 'SELECT progect_id, progect_name FROM progect WHERE user_id = 3';
    $result = mysqli_query($link, $sql);
    if(result) {
        $progect = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

//Формирование адреса ссылки
    $progects = $_GET;

    $progects['progect_id'] = $progect['progect_id'];
    
    $query = http_build_query($progect);
    $url = '/' .  '?' . $query;

}

//Проверка на существования параметра запроса с идентификатором проекта 
if(isset($_GET['progect_id']) && !empty($_GET['progect_id'])) {
    $progect_id = mysqli_real_escape_string($link, $_GET["progect_id"]);
    $sql = "SELECT * FROM task WHERE progect_id = $progect_id";
    $result = mysqli_query($link, $sql);
    if(result) {
        $task_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

//404
    if(!in_array($progect_id, array_column($progect, "progect_id"))) {
        header("Location: templates/error.php");
    }

} else {
    $sql = "SELECT * FROM task WHERE user_id = 3";
    $result = mysqli_query($link, $sql);
    if(result) {
        $task_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

//Проверка что форма была отправленна
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $tasks = $_POST;
    $required = ['name', 'project', 'date', 'file'];
    $dict = ['name' => 'Введите название', 'project' => 'Выберете проект', 'date' => 'Введите дату в формате ГГГГ-ММ-ДД','file' => 'Выберите файл в текстовом формате'];
    $errors = [];

//Проверка что поле с названием проекта заполненно
    foreach ($required as $key) {
		if (empty($_POST[$key])) {
            $errors[$key] = 'Введите название';
		}
	}

//Проверка что выбранный проект соответствует проекту из БД
    foreach ($progect as $key => $value) {
        if ($value["progect_id"] === empty($_POST["project"])) {
            $errors["project"] = "Выберете проект";
        }
    }

//Проверка что выбранная дата соответсвует параматрам
    if (!empty($task['date'])) {
		if (!is_date_valid($task['date']) || $task['date'] < date('Y-m-d')) {
			$errors['date'] = 'Введите дату в формате ГГГГ-ММ-ДД';
		}
    }
    
//Проверка что файл загружен 
    if (isset($_FILES['file'])) {
        $tmp_name = $_FILES['file']['tmp_name'];
        $path = $_FILES['file']['name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);

        if ($file_type !== "text/plain") {
			$errors['file'] = 'Выберите файл в текстовом формате';
		} else {
            move_uploaded_file($tmp_name, __DIR__ . '/' . $path);
            $file = __DIR__ . '/' . $path;
        }
    } else {
		$errors['file'] = 'Вы не загрузили файл';
	}
}

include 'functions.php';

$form_content = include_template ('form.php', ['progect' => $progect, 'tasks' => $tasks, 'task' => $task, 'required' => $required, 'dict' => $dict, 'errors' => $errors]);

$layout_content = include_template ('layout.php', ['progect' => $progect, 'progect_id' => $progect_id,
                                                   'tasks' => $tasks, 'required' => $required,
                                                   'task_list' => $task_list, 'num_count' => $num_count, 
                                                   'main_content' => $form_content, 'title' => 'Дела в Порядке']);

print($layout_content);