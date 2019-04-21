<?php


/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = []) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

// Функция подсчета задач
function count_task ($task_list, $progect_name) {                                                                                                  
    $number_tasks = 0;                              
    foreach($task_list as $item) {                  
        if ($item['category'] === $progect_name){     
            $number_tasks++;                          
        }
    }
    return $number_tasks;                           
}  