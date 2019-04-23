<?php
//показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

//массив проектов
$progect = ["Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];

$num_count = count($progect);

//массив задач
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

include 'functions.php';

$page_content = include_template ('index.php', ['progect' => $progect, 'task_list' => $task_list, 'show_complete_tasks' => $show_complete_tasks]);

$layout_content = include_template ('layout.php', ['progect' => $progect, 'task_list' => $task_list, 'num_count' => $num_count, 'main_content' => $page_content, 'title' => 'Дела в Порядке']);

print($layout_content);