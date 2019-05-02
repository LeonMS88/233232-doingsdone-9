<?php
//показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

//массив проектов
//$progect = ["Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];

//Соединение с БД
$link = mysqli_connect('127.0.0.1', 'root', '', 'db_233232');

//Установка кодировки в utf8
mysqli_set_charset($link, "utf8");

//Проверка соединения
if (!$link) {
    print('Ошибка подключения: ' . mysqli_connect_error());
}

//Выполнение запроса на получение списка проектов
else {
    $sql = 'SELECT progect_name FROM progect WHERE user_id = 55';
    $result = mysqli_query($link, $sql);
    if ($result) {
        $progect = mysqli_fetch_assoc($result);
        $num_count = count($progect);
    }
    $sql = 'SELECT * FROM task WHERE user_id = 55';
    if ($result) {
        $task_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
} 

//массив проектов



/*
//Выполнение запроса на получение списка задач
$sql = 'SELECT * FROM task WHERE user_id = 55';
$result = mysqli_query($link, $sql);

//массив задач
$task_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
*/





/*
$task_list = [
    [
        'task' => 'Собеседование в IT компанию',
        'date' => '26.04.2019',
        'category' => 'Работа',
        'completed' => false
    ],

    [
        'task' => 'Выполнить тестовое задание',
        'date' => '25.04.2019',
        'category' => 'Работа',
        'completed' => false
    ],

    [
        'task' => 'Сделать задание первого раздела',
        'date' => '1.05.2018',
        'category' => 'Учеба',
        'completed' => true
    ],

    [
        'task' => 'Встреча с другом',
        'date' => '22.12.2018',
        'category' => 'Входящие',
        'completed' => false
    ],

    [
        'task' => 'Купить корм для кота',
        'date' => 'Нет',
        'category' => 'Домашние дела',
        'completed' => false
    ],

    [
        'task' => 'Заказать пиццу',
        'date' => 'Нет',
        'category' => 'Домашние дела',
        'completed' => false
    ],
];
*/

include 'functions.php';

$page_content = include_template ('index.php', ['progect' => $progect, 'task_list' => $task_list, 'show_complete_tasks' => $show_complete_tasks]);

$layout_content = include_template ('layout.php', ['progect' => $progect, 'task_list' => $task_list, 'num_count' => $num_count, 'main_content' => $page_content, 'title' => 'Дела в Порядке']);

print($layout_content);