INSERT INTO user (user_add, user_email, user_name, user_password)
VALUES (NOW(), 'john@gmail.com', 'John', 'qwerty12345'),
		 (NOW(), 'logan@gmail.com', 'Logan', 'qwerty23456'),
		 (NOW(), 'michael@gmail.com', 'Michael', 'qwerty34567');
		 
INSERT INTO progect (progect_name, user_id)
VALUES ('Входящие', 1), ('Учеба', 2), ('Работа', 3), ('Домашние дела', 2), ('Авто', 1), ('Отпуск', 3);

INSERT INTO task (task_name, task_category, task_file, task_create, task_deadline, task_completed, user_id, progect_id) 
VALUES ('Собеседование в IT компанию', 'Работа', 'task.txt', NOW(), NOW(), 0,  3, 3), 
		 ('Выполнить тестовое задание', 'Работа', 'task.txt', NOW(), NOW(), 0, 3, 3),
		 ('Сделать задание первого раздела', 'Учеба', 'task.txt', NOW(), NOW(), 1, 2, 2),
		 ('Встреча с другом', 'Входящие', 'task.txt', NOW(), NOW(), 0, 1, 1),
		 ('Купить корм для кота', 'Домашние дела', 'task.txt', NOW(), NOW(), 0, 2, 4),
		 ('Заказать пиццу', 'Домашние дела', 'task.txt',  NOW(), NOW(), 0, 2, 4),
		 ('Поехать в NewYork', 'Отпуск', 'task.txt',  NOW(), NOW(), 1, 3, 6);
		 
SELECT progect_name FROM progect WHERE user_id = '3';

SELECT * FROM progect p
JOIN task t
ON p.progect_id = t.task_id;

SELECT * FROM task WHERE progect_id = '3';

UPDATE task SET task_completed = 1
WHERE task_name = 'Собеседование в IT компанию';

