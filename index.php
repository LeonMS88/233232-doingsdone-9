<?php

include 'functions.php';

session_start();

if (isset($_SESSION['user'])) {

    //показывать или нет выполненные задачи
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
    } else {
        //Выполнение запроса на получение списка проектов и списка задач
        $sql = "SELECT t.progect_id, p.progect_name, COUNT(t.task_name)
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
        if($result) {
            $task_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

    //404
        if(!in_array($progect_id, array_column($progect, "progect_id"))) {
            header("Location: templates/error.php");
        }

    } else {
        $sql = "SELECT * FROM task WHERE user_id = $user_id";
        $result = mysqli_query($link, $sql);
        if($result) {
            $task_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    }

    $page_content = include_template ('index.php', ['progect' => $progect, 'task_list' => $task_list, 'show_complete_tasks' => $show_complete_tasks, 
                                                    'user_id' => $user_id, 'user_name' => $user_name]);

    $layout_content = include_template ('layout.php', ['progect' => $progect, 'progect_id' => $progect_id, 'user_id' => $user_id,
                                                       'user_name' => $user_name,'task_list' => $task_list, 'num_count' => $num_count, 
                                                       'main_content' => $page_content, 'title' => 'Дела в Порядке']);

    print($layout_content);

} else {
    $guest_content = include_template('guest.php');
    $layout_content = include_template('layout.php', ['main_content' => $guest_content,'title' => 'Дела в Порядке']);
    print($layout_content);
}