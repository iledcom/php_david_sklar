
<?php
// Здесь предполагается, что исходный файл FormHelper.php
// находится в том же каталоге, где и данный файл
require 'FormHelper.php';
// Установить массивы с вариантами выбора из списка, размечаемого дескриптором <select>. Следующие массивы
// требуются в функциях display_form(), validate_form() и process_form(), и поэтому они объявляются в 
// глобальной области действия
$sweets = array(
	'puff' => 'Sesame Seed Puff',
	'square' => 'Coconut Milk Gelatin Square',
	'cake' => 'Brown Sugar Cake',
	'ricemeat' => 'Sweet Rice and Meat'
);

$main_dishes = array(
	'cuke' => 'Braised Sea Cucumber',
	'stomach' => "Sauteed Pig's Stomach",
	'tripe' => 'Sauteed Tripe with Wine Sauce',
	'taro' => 'Stewed Pork with Taro',
	'giblets' => 'Baked Giblets with Salt',
	'abalone' => 'Abalone with Marrow and Duck Feet'
);
// Основная логика функционирования страницы:
// - Если форма передана на обработку, проверить достоверность данных, обработать их и снова отобразить форму.
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
	$defaults = array('delivery' => 'yes', 'size' => 'medium');
	// создать объект $form с надлежащими свойствами по умолчанию
	$form = new FormHelper($defaults);
	// Ради ясности весь код HTML-разметки и отображения формы вынесен в отдельный файл
	include 'complete-form.php';
}

function validate_form() {
	$input = array();
	$errors = array();
	// обязательное имя
	$input['name'] = trim($_POST['name'] ?? '');
	if (! strlen($input['name'])) {
		$errors[] = 'Please enter your name.';
	}
	// обязательный размер блюда
	$input['size'] = $_POST['size'] ?? '';
	if (! in_array($input['size'], ['small','medium','large'])) {
		$errors[] = 'Please select a size.';
	}
	// обязательное сладкое блюдо
	$input['sweet'] = $_POST['sweet'] ?? '';
		if (! array_key_exists($input['sweet'], $GLOBALS['sweets'])) {
	$errors[] = 'Please select a valid sweet item.';
	}
	// два обязательных блюда
	$input['main_dish'] = $_POST['main_dish'] ?? array();
	if(count($input['main_dish']) != 2) {
		$errors[] = 'Please select exactly two main dishes.';
	} else {
		// Если выбрано два основных блюда, убедиться в их
		// достоверности
		if (! (array_key_exists($input['main_dish'][0], $GLOBALS['main_dishes']) &&
		array_key_exists($input['main_dish'][1], $GLOBALS['main_dishes']))) {
		$errors[] = 'Please select exactly two valid main dishes.';
		}
	}
	// Если выбрана доставка, то в комментариях должны быть
	// указаны ее подробности
	$input['delivery'] = $_POST['delivery'] ?? 'no';
	$input['comments'] = trim($_POST['comments'] ?? '');
	if (($input['delivery'] == 'yes') && (! strlen($input['comments']))) {
		$errors[] = 'Please enter your address for delivery.';
	}
	return array($errors, $input);
}

function process_form($input) {
	// найти полные наименования основных и сладких блюд
	// в массивах $GLOBALS['sweets'] и $GLOBALS['main_dishes']
	$sweet = $GLOBALS['sweets'][ $input['sweet'] ];
	$main_dish_1 = $GLOBALS['main_dishes'][ $input['main_dish'][0] ];
	$main_dish_2 = $GLOBALS['main_dishes'][ $input['main_dish'][1] ];
	if (isset($input['delivery']) && ($input['delivery'] == 'yes')) {
		$delivery = 'do';
	} else {
		$delivery = 'do not';
	}

// составить текст сообщения с заказом трапезы
$message=<<<_ORDER_
Thank you for your order, {$input['name']}.
You requested the {$input['size']} size of $sweet,
$main_dish_1, and $main_dish_2.
You $delivery want delivery.
_ORDER_;

	if (strlen(trim($input['comments']))) {
		$message .= 'Your comments: '.$input['comments'];
	}
	// отправить сообщение шеф-повару
	mail('chef@restaurant.example.com', 'New Order', $message);
	// вывести сообщение на экран, но закодировать его любыми HTML-представлениями 
	// и преобразовать знаки перевода строки в дескрипторы <br/>
	print nl2br(htmlentities($message, ENT_HTML5));
}

echo '<br><br>';
print_r($_POST);

