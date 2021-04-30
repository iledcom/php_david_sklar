<?php

date_default_timezone_set('Europe/Kiev');

/*

//Пример 9.2. Чтение, видоизменение и вывод шаблона страницы на экран
// загрузить файл шаблона из предыдущего примера
$page = file_get_contents('page-template.html');
// ввести заглавие страницы
$page = str_replace('{page_title}', 'Welcome', $page);
// окрасить страницу голубым цветом после полудня и
// зеленым цветом с утра
if (date('H') >= 12) {
	$page = str_replace('{color}', 'blue', $page);
	echo date('H');
} else {
	$page = str_replace('{color}', 'green', $page);
}
// взять имя пользователя из переменной сохраненного
// предыдущего сеанса
$page = str_replace('{name}', $_SESSION['username'], $page);
// вывести полученные результаты на экран
print $page;


//Пример 9.3. Запись в файл с помощью функции file_put_contents()
// загрузить файл шаблона из предыдущего примера
$page = file_get_contents('page-template.html');
// ввести заглавие страницы
$page = str_replace('{page_title}', 'Welcome', $page);
// окрасить страницу голубым цветом после полудня и
// зеленым цветом с утра
if (date('H') >= 12) {
	$page = str_replace('{color}', 'blue', $page);
	echo date('H');
} else {
	$page = str_replace('{color}', 'green', $page);
}
// взять имя пользователя из переменной сохраненного
// предыдущего сеанса
$page = str_replace('{name}', $_SESSION['username'], $page);
// записать полученные результаты в файл page.html
file_put_contents('page.html', $page);


//Пример 9.4. Доступ к каждой строке в файле
foreach (file('people.txt') as $line) {
	$line = trim($line);
	$info = explode('|', $line);
	print '<li><a href="mailto:' . $info[0] . '">' . $info[1] ."</li>\n";
}


//Пример 9.8. Запись данных в файл
try {
 $db = new PDO('mysql:host=localhost; dbname=test_db', 'root', '');
} catch (Exception $e) {
print "Couldn't connect to database: " . $e->getMessage();
exit();
}
// открыть файл dishes.txt для записи
$fh = fopen('dishes.txt','wb');
$q = $db->query("SELECT dish_name, price FROM dishes");

while($row = $q->fetch()) {
// записать каждую строку (с завершающим знаком перевода
// строки) в файл dishes.txt
	fwrite($fh, "The price of $row[0] is $row[1] \n");
}
fclose($fh);


//Пример 9.10. Ввод данных формата CSV в таблицу базы данных
try {
	$db = new PDO('mysql:host=localhost; dbname=test_db', 'root', '');
} catch (Exception $e) {
	print "Couldn't connect to database: " . $e->getMessage();
exit();
}

$fh = fopen('dishes.csv','rb');
$stmt = $db->prepare('INSERT INTO dishes (dish_name, price, is_spicy) VALUES (?,?,?)');
while ((! feof($fh)) && ($info = fgetcsv($fh))) {
// Элемент массива $info[0] содержит наименование блюда
// из первого поля в строке, считанной из файла dishes.csv.
// Элемент массива $info[1] содержит цену на блюдо
// из второго поля в считанной строке.
// Элемент массива $info[2] содержит состояние, обозначающее
// наличие специй в блюде, из третьего поля в считанной строке.
// Ввести упомянутое содержимое массива $info отдельной строкой
// в таблицу базы данных
$stmt->execute($info);
print "Inserted $info[0]\n";
}
// закрыть файл
fclose($fh);



//Пример 9.11. Запись данных в файл формата CSV
try {
	$db = new PDO('mysql:host=localhost; dbname=test_db', 'root', '');
} catch (Exception $e) {
	print "Couldn't connect to database: " . $e->getMessage();
exit();
}

// открыть файл формата CSV для записи
$fh = fopen('dish-list.csv','wb');

$dishes = $db->query('SELECT dish_name, price, is_spicy FROM dishes');

while ($row = $dishes->fetch(PDO::FETCH_NUM)) {
	// записать в массив $row данные в виде строки
	// формата CSV. Функция fputcsv() добавляет
	// знак перевода строки в конце записываемой строки
	fputcsv($fh, $row);
}
fclose($fh);

*/

//Пример 9.13. Отправка файла формата CSV браузеру

try {
	$db = new PDO('mysql:host=localhost; dbname=test_db', 'root', '');
} catch (Exception $e) {
	print "Couldn't connect to database: " . $e->getMessage();
exit();
}

// уведомить веб-клиента, что ему передается файл формата CSV
// под названием dishes.csv
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="dishes.csv"');
// открыть файл с дескриптором потока вывода
$fh = fopen('php://output', 'wb');
// извлечь информацию из таблицы базы данных и
// вывести ее на экран
$dishes = $db->query('SELECT dish_name, price, is_spicy FROM dishes');

while ($row = $dishes->fetch(PDO::FETCH_NUM)) {
fputcsv($fh, $row);
}