<?php

/*
Соединения устанавливаются автоматически при создании объекта PDO от его базового класса. 
Не имеет значения, какой драйвер вы хотите использовать; вы всегда используете имя базового 
класса. Конструктор класса принимает аргументы для задания источника данных (DSN), а также 
необязательные имя пользователя и пароль (если есть).

В случае ошибки при подключении будет выброшено исключение PDOException. Его можно перехватить 
и обработать, либо оставить на откуп глобальному обработчику ошибок, который вы задали функцией 
set_exception_handler().
*/

//Пример 8.4. Отправка запроса SQL с командой CREATE TABLE программе базы данных
//создать конкретную таблицу в базе данных

/*
try {
	$db = new PDO('mysql:host=localhost; dbname=test_db', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$q = $db->exec("CREATE TABLE dishes (
		dish_id INT,
		dish_name VARCHAR(255),
		price DECIMAL(4,2),
		is_spicy INT
	)");
} catch (PDOException $e) {
	print "Couldn't connect to the database: " . $e->getMessage();
}
*/

//Пример на удаление таблицы dishes

/*
try {
	$db = new PDO('mysql:host=localhost; dbname=test_db', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$q = $db->exec("DROP TABLE dishes");
} catch (PDOException $e) {
	print "Couldn't connect to the database: " . $e->getMessage();
}
*/

//Пример 8.6. Ввод информации в базу данных с помощью метода ехес()
/*
try {
	$db = new PDO('mysql:host=localhost; dbname=test_db', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$count = $db->exec("UPDATE dishes SET price = price + 5 WHERE price > 3");
	print 'Changed the price of ' . $count . ' rows.';

} catch (PDOException $e) {
	print "Couldn't connect to the database: " . $e->getMessage();
}
*/

//Пример 8.8. Работа с базой данных в негласном режиме выдачи ошибок
/*
try {
	$db = new PDO('mysql:host=localhost; dbname=test_db', 'root', '');
} catch (PDOException $e) {
	print "Couldn't connect: " . $e->getMessage();
}

$result = $db->exec("INSERT INTO dishes (dish_size, dish_name, price, is_spicy)
VALUES ('large', 'Sesame Seed Puff', 2.50, 0)");
if (false === $result) {
	$error = $db->errorInfo();
	print "Couldn't insert!\n";
	print "SQL Error={$error[0]}, DB Error={$error[1]},
	Message={$error[2]}\n";
}
*/
//Пример 8.9. Работа с базой данных в режиме предупреждения об ошибках
/*
try {
	$db = new PDO('mysql:host=localhost; dbname=test_db', 'root', '');
} catch (PDOException $e) {
	print "Couldn't connect: " . $e->getMessage();
}
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$result = $db->exec("INSERT INTO dishes (dish_size, dish_name, price, is_spicy)
VALUES ('large', 'Sesame Seed Puff', 2.50, 0)");
if (false === $result) {
	$error = $db->errorInfo();
	print "Couldn't insert!\n";
	print "SQL Error={$error[0]}, DB Error={$error[1]},
	Message={$error[2]}\n";
}
*/

//Пример 8.15. Изменение данных в таблице с помощью метода ехес()
/*
try {
	$db = new PDO('mysql:host=localhost; dbname=test_db', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// Кабачок под соусом, приправленным красным стручковым
	// перцем, считается блюдом со специями. Если не имеет
	// значения, сколько строк таблицы затронет данный запрос,
	// то сохранять значение, возвращаемое методом ехес(),
	// совсем не обязательно
	$db->exec("UPDATE dishes SET is_spicy = 1 WHERE dish_name = 'Eggplant with Chili Sauce'");
	// Омар под соусом, приправленным красным стручковым
	// перцем, считается дорогим блюдом со специями
	$db->exec("UPDATE dishes SET is_spicy = 1, price=price * 2 WHERE dish_name = 'Lobster with Chili Sauce'");
} catch (PDOException $e) {
	print "Couldn't insert a row: " . $e->getMessage();
}
*/

//Пример 8.16. Удаление данных из таблицы с помощью метода ехес()
/*
try {
	$db = new PDO('mysql:host=localhost; dbname=test_db', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// удалить дорогие блюда из таблицы
	if ($make_things_cheaper) {
		$db->exec("DELETE FROM dishes WHERE price > 19.95");
	} else {
		// или же удалить из нее все блюда
		$db->exec("DELETE FROM dishes");
	}
} catch (PDOException $e) {
	print "Couldn't delete rows: " . $e->getMessage();
}
*/

/*
filter_input
(PHP 5 >= 5.2.0, PHP 7)

filter_input — Принимает переменную извне PHP и, при необходимости, фильтрует ее

Описание
filter_input ( int $type , string $variable_name [, int $filter = FILTER_DEFAULT [, mixed $options ]] ) : mixed
Список параметров ¶
type
Одна из констант INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER или INPUT_ENV.

variable_name
Имя получаемой переменной.

filter
Идентификатор (ID) применяемого фильтра. На странице Типы фильтров приведен список доступных фильтров.

Если не указан, то используется FILTER_DEFAULT, который равнозначен FILTER_UNSAFE_RAW. Это значит, что по умолчанию 
не применяется никакого фильтра.

options
Ассоциативный массив параметров или логическое ИЛИ флагов. Если фильтр принимает параметры, флаги могут быть указаны 
в элементе массива "flags".

Возвращаемые значения
Значение запрашиваемой переменной в случае успеха, FALSE, если фильтрация завершилась неудачей, или NULL, если переменная 
variable_name не определена. Если установлен флаг FILTER_NULL_ON_FAILURE, функция возвращает FALSE, если переменная не 
определена и NULL, если фильтрация завершилась неудачей.
*/

// загрузить вспомогательный класс для составления форм
require 'FormHelper.php';
// подключиться к базе данных
try {
	$db = new PDO('mysql:host=localhost; dbname=test_db', 'root', '');
} catch (PDOException $e) {
	print "Can't connect: " . $e->getMessage();
	exit();
}
// установить исключения при ошибках в базе данных
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Основная логика функционирования страницы:
// - Если форма передана на обработку, проверить достоверность
// данных, обработать их и снова отобразить форму.
// - Если форма не передана на обработку, отобразить ее снова
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
// Если функция validate_form() возвратит ошибки,
// передать их функции show_form()
	list($errors, $input) = validate_form();
	if($errors) {
		show_form($errors);
	} else {
	// Переданные данные из формы достоверны, обработать их
		process_form($input);
	}
} else {
	// Данные из формы не переданы, отобразить ее снова
	show_form();
}


function show_form($errors = array()) {
	// установить свои значения по умолчанию:
	// цена составляет 5 долларов США
	$defaults = array('price' => '5.00');
	// создать объект $form с надлежащими свойствами по умолчанию
	$form = new FormHelper($defaults);
	// Ради ясности весь код HTML-разметки и отображения
	// формы вынесен в отдельный файл
	include 'insert-form.php';
}

function validate_form() {
	$input = array();
	$errors = array();
	// обязательное наименование блюда
	$input['dish_name'] = trim($_POST['dish_name'] ?? '');
	if (! strlen($input['dish_name'])) {
		$errors[] = 'Please enter the name of the dish.';
	}
	// цена должна быть указана достоверным положительным числом
	// с плавающей точкой
	$input['price'] = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
	if ($input['price'] <= 0) {
		$errors[] = 'Please enter a valid price.';
	}
	// по умолчанию в элементе ввода is_spicy устанавливается
	// значение 'no'
	$input['is_spicy'] = $_POST['is_spicy'] ?? 'no';
	return array($errors, $input);
}

function process_form($input) {
	// получить в этой функции доступ к глобальной переменной $db
	global $db;
	// установить в переменной $is_spicy значение в зависимости
	// от состояния одноименного флажка
	if ($input['is_spicy'] == 'yes') {
		$is_spicy = 1;
	} else {
		$is_spicy = 0;
	}
	// ввести новое блюдо в таблицу базы данных
	try {
		$stmt = $db->prepare('INSERT INTO dishes (dish_name, price, is_spicy) VALUES (?,?,?)');
		$stmt->execute(array($input['dish_name'], $input['price'], $is_spicy));
		// сообщить пользователю о вводе блюда в базу данных
		print 'Added ' . htmlentities($input['dish_name']) . ' to the database.';
		show_form();
	} catch (PDOException $e) {
		print "Couldn't add your dish to the database.";
	}
}

?>

