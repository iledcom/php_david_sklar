<?php

//Пример 10.11. Сохранение данных из формы в сеансе
require 'FormHelper.php';
session_start();

$main_dishes = array('cuke' => 'Braised Sea Cucumber',
	'stomach' => "Sauteed Pig's Stomach",
	'tripe' => 'Sauteed Tripe with Wine Sauce',
	'taro' => 'Stewed Pork with Taro',
	'giblets' => 'Baked Giblets with Salt',
	'abalone' => 'Abalone with Marrow and Duck Feet'
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	list($errors, $input) = validate_form();
	if ($errors) {
		show_form($errors);
	} else {
		process_form($input);
	}
} else {
	show_form();
}

function show_form($errors = array()) {
	// Собственные значения, устанавливаемые по умолчанию,
	// отсутствуют, поэтому и нечего передавать конструктору
	// класса FormHelper
	$form = new FormHelper();
	// построить HTML-таблицу из сообщений об ошибках для
	// последующего применения
	if ($errors) {
		$errorHtml = '<ul><li>';
		$errorHtml .= implode('</li><li>', $errors);
		$errorHtml .= '</li></ul>';
	} else {
		$errorHtml = '';
	}
	// Это небольшая форма, поэтому ниже выводятся ее составляющие
print <<<_FORM_
<form method="POST" action=
"{$form->encode($_SERVER['PHP_SELF'])}">
$errorHtml
Dish: {$form->select($GLOBALS['main_dishes'],
['name' => 'dish'])} <br/>
Quantity: {$form->input('text',
['name' => 'quantity'])} <br/>
{$form->input('submit',['value' => 'Order'])}
</form>
_FORM_;
}

function validate_form() {
	$input = array();
	$errors = array();
	// Блюдо, выбранное из списка, должно быть достоверным
	$input['dish'] = $_POST['dish'] ?? '';
	if (! array_key_exists($input['dish'],
	$GLOBALS['main_dishes'])) {
	$errors[] = 'Please select a valid dish.';
	}
	$input['quantity'] = filter_input(INPUT_POST, 'quantity',
	FILTER_VALIDATE_INT,
	array('options' =>
	array('min_range' => 1)));
	if (($input['quantity'] === false) ||
	($input['quantity'] === null)) {
	$errors[] = 'Please enter a quantity.';
	}
	return array($errors, $input);
}


function process_form($input) {
	$_SESSION['order'][] = array('dish' => $input['dish'], 'quantity' => $input['quantity']);
	print 'Thank you for your order.';
}


//Пример 10.12. Вывод данных сеанса на экран
session_start();
$main_dishes = array('cuke' => 'Braised Sea Cucumber',
	'stomach' => "Sauteed Pig's Stomach",
	'tripe' => 'Sauteed Tripe with Wine Sauce',
	'taro' => 'Stewed Pork with Taro',
	'giblets' => 'Baked Giblets with Salt',
	'abalone' =>
	'Abalone with Marrow and Duck Feet');
if (isset($_SESSION['order']) && (count($_SESSION['order']) > 0)) {
	print '<ul>';
	foreach ($_SESSION['order'] as $order) {
	$dish_name = $main_dishes[ $order['dish'] ];
	print "<li> $order[quantity] of $dish_name </li>";
	}
	print "</ul>";
} else {
	print "You haven't ordered anything.";
}


//Пример 10.13. Изменение допустимого времени простоя для сеансов
ini_set('session.gc_maxlifetime',600); // 600 секунд == 10 минут
session_start();

//Пример 10.14. Изменение вероятности очистки истекших сеансов
ini_set('session.gc_probability',100); // значение 100% означает
// полную очистку истекших сеансов при каждом запросе
session_start();

/*
Если сеансы активизируются с помощью директивы session.auto_start конфигурации сервера и 
требуется изменить значение в директиве session.gc_maxlifetime или session.gc_probability, 
то сделать это с помощью функции ini_set() нельзя. Для этого придется внести коррективы 
непосредственно в конфигурацию сервера.

У cookie-файла, применяемого для хранения идентификатора пользовательского сеанса, имеются
свои свойства, корректируемые в том числе и с помощью параметров конфигурации. Корректируемые
свойства отражают настройки, которые можно производить в обычном cookie-файле посредством
различных аргументов функции setcookie(), за исключением, разумеется, значений, хранящихся
в cookie-файле. В табл. 10.1 перечислены различные параметры конфигурации сеансов в cookie-
файле.

Таблица 10.1. Параметры конфигурации сеансов в cookie-файле
Параметр конфигурации Значение поумолчанию Описание
session.name PHPSESSID Имя cookie-файла, где допускается указывать буквы и цифры, причем не меньше одной буквы
session.cookie_lifetime 0 Количество секунд, которые должны пройти после 1 января 1970 года для истечения срока действия cookie-файла, где нулевое значение обозначает срок действия cookie-файла до тех пор, пока существует браузер
session.cookie_path / Путевой префикс в URL, пригодный для отправки cookie-файла
session.cookie_domain Отсутствует Суффикс домена, пригодный для отправки cookie-файла. Отсутствие значения означает, что cookie-файл отправляется обратно только по полностью указанному имени хоста
session.cookie_secure Off Чтобы отправить cookie-файл по URL через соединение по сетевому протоколу HTTPS, следует установить значение On данного параметра
session.cookie_httponly Off Чтобы дать браузеру команду предотвратить чтение cookie-файла из сценария JavaScript, следует установить значение On данного параметра
*/	

Регистрация и идентификация пользователей

/*
Добавление данных регистрации пользователя к сеансам происходит в течение следующих пяти
этапов.
1. Отображение формы, в которой запрашивается имя пользователя и пароль.
2. Проверка переданной на обработку формы.
3. Ввод имени пользователя в сеанс, если передан правильный пароль.
4. Поиск имени пользователя в сеансе для выполнения задач, характерных для данного пользо-
вателя.
5. Удаление имени пользователя из сеанса при снятии пользователя с регистрации.

На первых трех этапах обработка данных происходит в контексте обработки обычной формы.
Функция validate_form() берет на себя ответственность за проверку достоверности предостав-
ляемого имени пользователя и пароля, а функция process_form() вводит имя пользователя в
сеанс. Так, в примере 10.15 демонстрируется отображение формы регистрации и ввод имени поль-
зователя, если регистрация пройдет успешно.
*/

Пример 10.15. Отображение формы, регистрации

require 'FormHelper.php';
session_start();
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	list($errors, $input) = validate_form();
	if ($errors) {
		show_form($errors);
	} else {
		process_form($input);
	}
} else {
	show_form();
}

function show_form($errors = array()) {
// Собственные значения, устанавливаемые по умолчанию,
// отсутствуют, поэтому и нечего передавать конструктору
// класса FormHelper
$form = new FormHelper();
// построить HTML-таблицу из сообщений об ошибках для
// последующего применения
if ($errors) {
	$errorHtml = '<ul><li>';
	$errorHtml .= implode('</li><li>',$errors);
	$errorHtml .= '</li></ul>';
} else {
	$errorHtml = '';
}

// Это небольшая форма, поэтому ниже выводятся ее составляющие
print <<<_FORM_
<form method="POST" action=
"{$form->encode($_SERVER['PHP_SELF'])}">
$errorHtml
Username: {$form->input('text',
['name' => 'username'])} <br/>
Password: {$form->input('password',
['name' => 'password'])} <br/>
{$form->input('submit', ['value' => 'Log In'])}
</form>
_FORM_;
}

function validate_form() {
	$input = array();
	$errors = array();
	// Некоторые образцы имен пользователей и паролей
	$users = array('alice' => 'dogl23',
	'bob' => 'my^pwd',
	'charlie' => '**fun**');
	// убедиться в достоверности имени пользователя
	$input['username'] = $_POST['username'] ?? '';
	if (! array_key_exists($input['username'], $users)) {
		$errors[] = 'Please enter a valid username and password.';
	}
	// Оператор else означает, что проверка пароля пропускается,
	// если введено недостоверное имя пользователя
	else {
		// проверить правильность введенного пароля
		$saved_password = $users[ $input['username'] ];
		$submitted_password = $_POST['password'] ?? '';
		if ($saved_password != $submitted_password) {
		$errors[] =
		'Please enter a valid username and password.';
		}
	}
	return array($errors, $input);
}
function process_form($input) {
	// ввести имя пользователя в сеанс
	$_SESSION['username'] = $input['username'];
	print "Welcome, $_SESSION[username]";
}


Пример 10.16. Выполнение специальных действий для зарегистрированного пользователя

session_start();
if (array_key_exists('username', $_SESSION)) {
	print "Hello, $_SESSION['username']."
} else {
	print 'Howdy, stranger.';
}

/*
Элемент username может быть введен в массив $_SESSION только программным способом. И
если он присутствует, значит, пользователь успешно зарегистрировался.

Более совершенный вариант функции validate_form() демонстрируется в примере 10.17.
Массив $users в этом варианте содержит пароли, хешированные с помощью встроенной в РНР
функции password_hash(). А поскольку пароли хранятся в виде хешированных символьных
строк, то их нельзя сравнивать непосредственно с паролем, введенным пользователем в незашиф-
рованном виде. Вместо этого предъявленный пароль, содержащийся в элементе массива $input
['password'], проверяется с помощью функции password_verify(). В этой функции использу-
ется информация из сохраненного в хешированном виде пароля для получения такого же хеш-кода
предъявленного пароля. Если оба хеш-кода совпадают, значит, пользователь предъявил правильный
пароль, и тогда функция password_verifу() возвратит логическое значение true.
*/

Пример 10.17. Применение хешированных паролей
function validate_form() {
$input = array();
$errors = array();
// Образец имен пользователей с хешированными паролями
$users = array('alice' =>
'$2y$10$N47IXmT8C.sKUFXs1EBS9uJRuVV8bWxwqubcvNqYP9vcFmlSWEAbq',
'bob' =>
'$2y$10$qCczYRc7S011VRESMqUkGeWQT4V4OQ2qkSyhnxO0c.fk.LulKwUwW',
'Charlie' =>
'$2y$10$nKfkdviOBONrzZkRq5pAgOCbaTFiFI6O2xFka9yzXpEBRAXMW5mYi');
// проверить достоверность имени пользователя
if (! array_key_exists($_POST['username'], $users)) {
$errors[ ] = 'Please enter a valid username and password.';
}
else {
// проверить правильность пароля
$saved_password = $users[ $input['username'] ];
$submitted_password = $_POST['password'] ?? '';
if (! password_verify($submitted_password,
$saved_password)) {
$errors[ ] =
'Please enter a valid username and password.';
}
}
return array($errors, $input);
}

/*
Применение функций password_hash() и password_verify() гарантирует, что пароли хе-
шируются достаточно надежным способом, и дает возможность усилить хеширование в дальнейшем
по мере надобности. Если вы хотите узнать подробнее о том, как действуют эти функции, обратитесь
за справкой к страницам документации на них по адресу http://www.php.net/password_hash
и http://www.php.net/password_verify соответственно в оперативно доступном руководстве
РНР или к рецепту 18.7, который дается в книге РНР Cookbook Дэвида Скляра (David Sklar) и
Адама Трахтенберга (Adam Trachtenberg; издательство O’Reilly; 3-е издание этой книги в русском
переводе вышло под названием РНР. Рецепты программирования в издательстве “Питер”, 2015 г.).


Функции password_hash() и password_verify() появились в версии РНР
5.5.0. Если вы пользуетесь более ранней версией РНР, обратитесь к библиотеке
password_compat (по адресу https://github.com/ircmaxell/password
_compat), в которой предоставляются аналоги этих функций.

Благодаря размещению имен пользователей и паролей в функции validate_form() програм-
мы в приведенных выше примерах оказываются автономными. Но зачастую имена пользователей
и пароли хранятся в таблице базы данных. Так, в примере 10.18 демонстрируется версия функции
validate_form(), где имя пользователя и хешированный пароль извлекаются из базы данных.
При этом предполагается, что подключение к базе данных уже осуществлено вне данной функции
и доступно в глобальной переменной $db.

Так, в примере 10.18 демонстрируется версия функции validate_form(), где имя пользователя 
и хешированный пароль извлекаются из базы данных.
При этом предполагается, что подключение к базе данных уже осуществлено вне данной функции
и доступно в глобальной переменной $db.
*/

Пример 10.18. Извлечение имени пользователя и пароля из базы данных
function validate_form() {
	global $db;
	$input = array();
	$errors = array();
	// В этой переменной устанавливается логическое значение true
	// только в том случае, если предъявленный пароль подходит
	$password_ok = false;
	$input['username'] = $_POST['username'] ?? '';
	$submitted_password = $_POST['password'] ?? '';
	$stmt = $db->prepare('SELECT password FROM users WHERE username = ?');
	$stmt->execute($input['username']);
	$row = $stmt->fetch();
	// Если в таблице отсутствует искомая строка, имя
	// пользователя не найдено ни в одной из строк таблицы
	if ($row) {
		$password_ok = password_verify($submitted_password, $row[0]);
	}
	if (! $password_ok) {
		$errors[] = 'Please enter a valid username and password.';
	}
		return array($errors, $input);
}

/*
По запросу, составляемому функцией prepare() и посылаемому функцией execute() в базу
данных, возвращается хешированный пароль пользователя с идентифицированным именем в эле-
менте массива $input['username']. Если предъявленное имя пользователя не найдено ни в одной
из строк таблицы базы данных, то в переменной $row устанавливается логическое значение false.
А если строка с таким именем пользователя найдена, то в функции password_verify() проверя-
ется предъявленный пароль относительно хешированного пароля, извлеченного из базы данных.
И только если в возвращаемой строке таблицы содержится правильный хешированный пароль, в пере-
менной $password_ok устанавливается логическое значение true. В противном случае сообщение
об ошибке вводится в массив $errors.
Чтобы удалить ключ и значение из массива $_SESSION, как из любого другого массива, следует
воспользоваться функцией unset(). Именно таким образом пользователь снимается с регистрации.
В примере 10.19 демонстрируется снятие с регистрации на странице.
*/

Пример 10.19. Снятие с регистрации
session_start();
unset($_SESSION['username']);
print 'Bye-bye.';

/*
В конце обработки запроса, когда вызывается функция unset() и сохраняется массив $_SESSION,
элемент username не включается в сохраняемые данные. А при последующей загрузке данных се-
анса в массив $_SESSION элемент username в нем отсутствует, и пользователь снова становится
анонимным.

Причины для размещения вызовов функций setcookie()
session_start() вначале страницы
Когда веб-сервер посылает ответ веб-клиенту, большую часть этого ответа составляет HTML-
документ, воспроизводимый браузером на веб-странице, отображаемой на экране и состоящей из
совокупности дескрипторов и фрагментов текста, которые браузер Safari или Firefox форматирует в
таблицы, изменяет их цвет или размер. Но в таком ответе HTML-документу предшествуют заго-
ловки, которые не отображаются на экране, но состоят из команд или информации, передаваемой
из сервера веб-клиенту. В этих заголовках сообщается, в частности, о том, что данная страница
была сформирована в такой-то момент, ее не следует кешировать, а если она подходит, то нужно
запомнить cookie-файл под именем userid и со значением ralph.
Все заголовки должны непременно располагаться вначале ответа, посылаемого из сервера веб-
клиенту, предшествуя телу ответа, которое составляет HTML-разметка, управляющая тем, что
браузер фактически отображает. Как только тело ответа будет отправлено (даже в виде единственной
строки), никаких заголовков больше отправлять нельзя.
Заголовки вводятся в ответ с помощью функций setcookie() и session_start(). Чтобы
заголовки были отправлены надлежащим образом, они должны быть введены в ответ прежде любой
выводимой информации. Именно поэтому упомянутые выше функции следует вызывать прежде
любых операторов print или HTML-разметки, оказывающейся за пределами дескрипторов <?php
?> разметки кода РНР.

Если попытаться отправить любые выводимые результаты прежде вызова функции setcookie()
или session_start(), то интерпретатор РНР выдаст сообщение об ошибке, аналогичное следу-
ющему:
Warning: Cannot modify header information - headers already sent by
(output started at /www/htdocs/catalog.php:2)
in /www/htdocs/catalog.php on line 4
[ Предупреждение: видоизменить информацию в заголовке нельзя —
заголовки уже отправлены
(вывод начат по адресу /www/htdocs/catalog.php:2)
в строке кода 4 из исходного файла /www/htdocs/catalog.php ]
Это означает, что в строке 4 кода из исходного файла catalog.php вызвана функция, посыла-
ющая заголовок. Но прежде в строке 2 кода из того же самого исходного файла уже была выведена
какая-то информация.
Если появится сообщение об ошибке, где извещается, что заголовки уже отправлены, тщательно
проверьте исходный код своей программы на наличие ошибочного вывода, убедившись в отсутствии
операторов print перед вызовом функции setcookie() или session_start(). В частности, ни
перед начальным дескриптором <?php на странице, ни за пределами дескрипторов <?php и ?> во
включаемых или обязательных файлах не должно быть ничего — даже пробелов.
Альтернативой выявлению неуместных пустых строк в исходных файлах может служить буфери-
зация вывода, предписывающая интерпретатору РНР задержать отправку любой выводимой инфор-
мации до тех пор, пока не завершится обработка всего запроса. И только после этого посылаются
любые заданные заголовки, а вслед за ними — все обычно выводимые результаты. Чтобы активи-
зировать буферизацию вывода, следует установить значение On в директиве output_buffering
конфигурации. Веб-клиентам придется подождать несколько дополнительных миллисекунд, чтобы
получить содержимое страницы из сервера, но в то же время удастся сэкономить немало времени
на выявление в исходном коде всего вывода, происходящего прежде вызова функции setcookie()
или session_start().
Если буферизация вывода активизирована, операторы print, функции манипулирования cookie-
файлами и сеансами, HTML-разметку за пределами дескрипторов <?php и ?> и обычный код РНР
можно употреблять в любом сочетании и где угодно на странице, не боясь получить сообщение
об ошибке, где извещается, что заголовки уже отправлены. Так, программа из примера 10.20 будет
работоспособной лишь в том случае, если активизирована буферизация вывода. В противном случае
HTML- документ выводится в ней прежде начального дескриптора <?php, запускающего отправку
заголовков, что помешает надлежащему выполнению функции setcookie().
*/