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
        if ($item['progect_id'] === $progect_name){     
            $number_tasks++;                          
        }
    }
    return $number_tasks;                           
}  

//Подсчитывает сколько осталось часов до каждой из имеющихся дат
//Если кол-во часов до выполнения задачи меньше или равно 24, то добавляет строке с задачей класс task--important
function dead_line ($value) {
    date_default_timezone_set("Europe/Moscow");

    //Переводит дату выполнения задачи в формат timestamp
    $completed_date = strtotime($value);

    //Получает текущий timestamp
    $current_ts = time();
        
    //Вычетает из даты выполнения задачи текущий timestamp и получает оставшееся время
    $time_left = $completed_date - $current_ts;
        
    //Переводим оставшееся время из секунд в часы
    $hours_left = floor($time_left / 3600);

    if ($value === 'Нет') {
        return 999;
    }

    return $hours_left;
}


/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}
