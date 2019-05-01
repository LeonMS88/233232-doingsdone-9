INSERT INTO user (user_add, user_email, user_name, user_password)
VALUES (NOW(), 'john@gmail.com', 'John', 'qwerty12345'),
		 (NOW(), 'logan@gmail.com', 'Logan', 'qwerty23456'),
		 (NOW(), 'michael@gmail.com', 'Michael', 'qwerty34567');
		 
INSERT INTO progect (progect_name, user_id)
VALUES ('Входящие', 57), ('Учеба', 56), ('Работа', 55), ('Домашние дела', 64), ('Авто', 65), ('Отпуск', 60);

INSERT INTO task (task_create, task_name, task_file, task_completed, task_category, user_id, progect_id) 
VALUES (NOW(), 'Собеседование в IT компанию', 'task.txt', FALSE, 'Работа', 55, 52), 
		 (NOW(), 'Выполнить тестовое задание', 'task.txt', FALSE, 'Работа', 79, 64),
		 (NOW(), 'Сделать задание первого раздела', 'task.txt', TRUE, 'Учеба', 84, 75),
		 (NOW(), 'Встреча с другом', 'task.txt', FALSE, 'Входящие', 74, 84),
		 (NOW(), 'Купить корм для кота', 'task.txt', FALSE, 'Домашние дела', 68, 70),
		 (NOW(), 'Заказать пиццу', 'task.txt', FALSE, 'Домашние дела', 91, 69),
		 (NOW(), 'Поехать в NewYork', 'task.txt', TRUE, 'Отпуск', 207, 277);
		 
SELECT * FROM progect WHERE user_id = '57';

SELECT * FROM progect p
JOIN task t
ON p.progect_id = t.task_id;

SELECT * FROM task WHERE progect_id = '75';

UPDATE task SET task_completed = 'TRUE'
WHERE task_name = 'Собеседование в IT компанию';

UPDATE task SET task_name = 'Заказать пиццу и съесть её =)'
WHERE task_id = '25';