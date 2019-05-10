<?php
//показывать или нет выполненные задачи
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
    //массив проектов
    $sql = 'SELECT progect_id, progect_name FROM progect WHERE user_id = 3';
    $result = mysqli_query($link, $sql);
    if(result) {
        $progect = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $num_count = count($progect);
    }
    //массив задач
    $sql = 'SELECT * FROM task WHERE user_id = 3';
    $result = mysqli_query($link, $sql);
    if(result) {
        $task_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    $progect = $_GET;

    $progect['progect_id'] = $progect['progect_id'];
    
    $query = http_build_query($progect);
    $url = '/' .  '?' . $query;

}

include 'functions.php';

$page_content = include_template ('index.php', ['progect' => $progect, 'task_list' => $task_list, 'show_complete_tasks' => $show_complete_tasks]);

$layout_content = include_template ('layout.php', ['progect' => $progect, 'task_list' => $task_list, 'num_count' => $num_count, 'main_content' => $page_content, 'title' => 'Дела в Порядке']);

print($layout_content);