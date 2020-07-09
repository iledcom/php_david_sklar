<?php

require 'restaurant-functions.php';
/* Счет на 25 долларов США плюс налог на добавленную
стоимость (8,875%) и чаевые (20%) */
$total_bill = restaurant_check(25, 8.875, 20);
/* Имеется 30 долларов США наличными */
$cash = 30;
print "I need to pay with " . payment_method($cash, $total_bill);

echo '</br></br>';

/*

// создать экземпляр и присвоить его переменной $soup
$soup = new Entree;
// установить свойства экземпляра в переменной $soup
$soup->name = 'Chicken Soup';
$soup->ingredients = array('chicken', 'water');
// создать отдельный экземпляр и присвоить его
// переменной $sandwich
$sandwich = new Entree;
// установить свойства экземпляра в переменной $sandwich
$sandwich->name = 'Chicken Sandwich';
$sandwich->ingredients = array('chicken', 'bread');

foreach (['chicken','lemon','bread','water'] as $ing) {
	if ($soup->hasIngredient($ing)) {
		print "Soup contains $ing".'</br>';
	}
	if ($sandwich->hasIngredient($ing)) {
		print "Sandwich contains $ing".'</br>';
	}
}
echo '</br></br>';


$sizes = Entree::getSizes();

print $sizes[1];


$soup = new Entree('Chicken Soup', array('chicken', 'water'));
$sandwich = new Entree('Chicken Sandwich', array('chicken', 'bread'));

//print $sandwich->name;

print_r($sandwich);
echo '</br></br>';
print $sandwich->name;
echo '</br></br>';

try {
	$drink = new Entree('Glass of Milk', 'milk');
	if ($drink->hasIngredient('milk')) {
			print "Yummy!";
		}
} catch (Exception $e) {
	print "Couldn't create the drink: " . $e->getMessage();
}

echo '</br></br>';

// Суп, его название и ингредиенты
$soups = 'грибной суп';
$soup = new Entree('Chicken Soup', array('chicken', 'water'));
// Сендвич, его название и ингредиенты
$sandwich = new Entree('Chicken Sandwich', array('chicken', 'bread'));
// Составное блюдо
$combo = new ComboMeal('Soup + Sandwich', array($soups, $sandwich));
foreach (['chicken','water','pickles'] as $ing) {
if ($combo->hasIngredient($ing)) {
print "Something in the combo contains $ing.\n";
}
}
*/
echo '</br></br>';

$chicken = new Ingredient('chicken', 2.5);
$water = new Ingredient('water', 0.1);
$bread = new Ingredient('bread', 0.5);


$lanch_price = new PricedEntree('Chicken Soup',array($chicken, $water));
print 'lanch price total:' . $lanch_price->getCost();

echo '</br></br>';

print $chicken->getCost();

$chicken->setCost(2.75);

echo '</br></br>';

print $chicken->getCost();

echo '</br></br>';

if ('POST' == $_SERVER['REQUEST_METHOD']) {
print "Hello, ". $_POST['my_name'];
} else {
print<<<_HTML_
<form method="post" action="$_SERVER[PHP_SELF]">
Your name: <input type="text" name="my_name" >
<br>
<input type="submit" value="Say Hello">
</form>
_HTML_;
}

echo '</br></br>';
?>

<form method="POST" action="index.php">
<input type="text" name="product_id">
<select name="category">
<option value="ovenmitt">Pot Holder</option>
<option value="fryingpan">Frying Pan</option>
<option value="torch">Kitchen Torch</option>
</select>
<input type="submit" name="submit">
</form>


<form method="POST" action="index.php">
<input type="text" name="product_id">
<select name="category">
<option value="ovenmitt">Pot Holder</option>
<option value="fryingpan">Frying Pan</option>
<option value="torch">Kitchen Torch</option>
</select>
<input type="submit" name="submit">
</form>
Here are the submitted values:
product_id: <?php print $_POST['product_id'] ?? '' ?>
<br/>
category: <?php print $_POST['category'] ?? '' ?>

</br></br>

<form method="POST" action="index.php">
<select name="lunch[]" multiple>
<option value="pork">BBQ Pork Bun</option>
<option value="chicken">Chicken Bun</option>
<option value="lotus">Lotus Seed Bun</option>
<option value="bean">Bean Paste Bun</option>
<option value="nest">Bird-Nest Bun</option>
</select>
<input type="submit" name="submit">
</form>

</br></br>


<form method="POST" action="index.php">
	<select name="lunch[]" multiple>
	<option value="pork">BBQ Pork Bun</option>
	<option value="chicken">Chicken Bun</option>
	<option value="lotus">Lotus Seed Bun</option>
	<option value="bean">Bean Paste Bun</option>
	<option value="nest">Bird-Nest Bun</option>
	</select>
	<input type="submit" name="submit">
</form>
Selected buns:
<br/>

</br></br>

<?php
if (isset($_POST['lunch'])) {
	foreach ($_POST['lunch'] as $choice) {
		print "You want a $choice bun. <br/>";
	}
}

?>

<?php
/*
// Логика выполнения верных действий на
// основании метода запроса
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	process_form();
} else {
	show_form();
}
// сделать что-нибудь, когда форма передана на обработку
function process_form() {
	print "Hello, ". $_POST['my_name'];
}
// отобразить форму
function show_form() {
print<<<_HTML_
<form method="POST" action="$_SERVER[PHP_SELF]">
Your name: <input type="text" name="my_name">
<br />
<input type="submit" value="Say Hello">
</form>
_HTML_;
}

echo '</br></br>';

// Логика выполнения верных действий на
// основании метода запроса
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (validate_form()) {
		process_form();
	} else {
		show_form();
	}
} else {
	show_form();
}

// сделать что-нибудь, когда форма передана на обработку
function process_form() {
	print "Hello, ". $_POST['my_name'];
}

// отобразить форму
function show_form() {
print<<<_HTML_
<form method="POST" action="$_SERVER[PHP_SELF]">
Your name: <input type="text" name="my_name">
<br/>
<input type="submit" value="Say Hello">
</form>
_HTML_;
}

// проверить данные из формы
function validate_form() {
	// Содержит ли имя, введенное в текстовом поле my_name
	// хотя бы три символа?
	if (strlen($_POST['my_name']) < 3) {
		return false;
	} else {
		return true;
	}
}



echo '</br></br>';

//Логика выполнения верных действий на 
//основании метода запроса
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(validate_form()) {
		process_form();
	} else {
		show_form();
	}
} else {
	show_form();
}

//сделать что-нибудь, когда форма передана на обработку
function process_form() {
	print "Hello, " . $_POST['my_name'];
}


//отобразить форму
function show_form() {
print<<<_HTML_
<form method="POST"action="$_SERVER[PHP_SELF]">
You Name: <input type="text" name="my_name">
<br/>
<input type="submit" value="Say Hello">
</form>
_HTML_;
}

//проверить данные из формы
function validate_form() {
	if (strlen($_POST['my_name']) < 3) {
		return false;
	} else {
		return true;
	}
}

echo '</br></br>';

print_r($_POST);



echo '</br></br>';

// Логика выполнения верных действий на
// основании метода запроса
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Если функция validate_form() возвратит ошибки,
	// передать их функции show_form()
	if($form_errors = validate_form()) {
		show_form($form_errors);
	} else {
	process_form();
	}
} else {
	show_form();
}

// сделать что-нибудь, когда форма передана на обработку
function process_form() {
	print "Hello, ". $_POST['my_name'];
}

// отобразить форму

function show_form($errors = 0) {
// Если переданы ошибки, вывести их на экран
if ($errors) {
	print 'Please correct these errors: <ul><li>';
	print implode ('</li><li>', $errors);
	print ' </li></ul>';
}
print <<<_HTML_
<form method="POST" action="$_SERVER[PHP_SELF]">
Your name: <input type="text" name="my_name">
<br><br>
Your age:  <input type="text" name="my_age">
<br><br>
<input type="submit" value="Say Hello">
</form>
_HTML_;
}


function validate_form() {
	$ok = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
	$errors = array();
	if(strlen(trim($_POST['my_name'])) < 8) {
		$errors[ ] = 'Your name must be at least 8 letters long.';
	}
	if (is_null($ok) || ($ok === false)) {
		$errors[] = 'Please enter a valid age.';
}
	return $errors;
}
*/



echo '</br></br>';
/*
$sweets = array(
	'Sesame Seed Puff',
	'Coconut Milk Gelatin Square',
	'Brown Sugar Cake',
	'Sweet Rice and Meat'
);

function generate_options($options) {
	$html = '';
	foreach ($options as $option) {
		$html .= "<option>$option</option>\n";
	}
	return $html;
}
*/

$sweets = array(
	'puff' => 'Sesame Seed Puff',
	'square' => 'Coconut Milk Gelatin Square',
	'cake' => 'Brown Sugar Cake',
	'ricemeat' => 'Sweet Rice and Meat'
);
function generate_options_with_value ($options) {
	$html = '';
	foreach ($options as $value => $option) {
		$html .= "<option value=$value>$option</option>";
	}
	return $html;
}

// Логика выполнения верных действий на
// основании метода запроса
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Если функции validate_form() возвращает ошибки,
	// передать их функции show_form()
	list($form_errors, $input) = validate_form();
	if ($form_errors) {
		show_form($form_errors);
	} else {
		process_form($input);
	}
} else {
	show_form() ;
}

// сделать что-нибудь, когда форма передана на обработку
function process_form() {
	print "Hello, ". $_POST['my_name'];
}

// отобразить форму

function show_form($errors = 0) {
//$sweets = generate_options($GLOBALS['sweets']);
$sweets = generate_options_with_value($GLOBALS['sweets']);
// Если переданы ошибки, вывести их на экран
if ($errors) {
	print 'Please correct these errors: <ul><li>';
	print implode ('</li><li>', $errors);
	print ' </li></ul>';
}
print <<<_HTML_
<form method="POST" action="$_SERVER[PHP_SELF]">
Your name:  <input type="text" name="my_name">
<br><br>
Your age:   <input type="text" name="my_age">
<br><br>
Your email: <input type="email" name="my_email">
Your Order: <select name="order">$sweets</select>
<input type="submit" value="Say Hello">
</form>
_HTML_;
}


function validate_form() {
	$errors = array();
	$input = array();

	// воспользоваться нулеобъединяющей операцией, если
	// значение в элементе $_POST['name'] не установлено
	$input['my_name'] = trim($_POST['my_name'] ?? '');
	// ?? ''  - нулеобъединяющая операция 
	if (strlen($input['my_name']) == 0) {
		$errors[] = "Your name is required.";
	}
	/*
	$input['my_age'] = filter_input (INPUT_POST, 'my_age', FILTER_VALIDATE_INT);
	if (is_null($input['my_age']) || ($input['my_age'] === false)) {
		$errors[] = 'Please enter a valid age.';
	}
	*/
	$input['my_age'] = filter_input(INPUT_POST, 'my_age', FILTER_VALIDATE_INT, array(
	'options' => array(
		'min_range' => 18,
		'max_range' => 65
	)));
	if (is_null($input['my_age']) || ($input['my_age'] === false)) {
		$errors[] = 'Please enter a valid age between 18 and 65.';
	}

	$input['my_email'] = filter_input(INPUT_POST, 'my_email', FILTER_VALIDATE_EMAIL);
	if (! $input['my_email']) {
		$errors[] = 'Please enter a valid email.';
	}

	$input['order'] = $_POST['order'];
	if (! array_key_exists($input['order'] , $GLOBALS['sweets'])) {
	$errors[] = 'Please choose a valid order.';
}

	return array($errors, $input);
}

echo '</br></br>';



$sweets = array(
	'puff' => 'Sesame Seed Puff',
	'square' => 'Coconut Milk Gelatin Square',
	'cake' => 'Brown Sugar Cake',
	'ricemeat' => 'Sweet Rice and Meat'
);
print '<select name="sweet">';
// Знак > обозначает значение элемента выбора,
// а переменная $lаbеl — отображаемый элемент списка
foreach ($sweets as $option => $label) {
	print '<option value="' .$option . '"';
	if ($option == $defaults['sweet']) {
	print ' selected';
	}
	print "> $label</option>\n";
}
print '</select>';



echo '</br></br>';


$main_dishes = array(
	'cuke' => 'Braised Sea Cucumber',
	'stomach' => "Sauteed Pig's Stomach",
	'tripe' => 'Sauteed Tripe with Wine Sauce',
	'taro' => 'Stewed Pork with Taro',
	'giblets' => 'Baked Giblets with Salt',
	'abalone' => 'Abalone with Marrow and Duck Feet'
);
print '<select name="main_dish[]" multiple>';
$selected_options = array();
foreach ($defaults['main_dish'] as $option) {
$selected_options[$option] = true;
}
// вывести дескрипторы <option>
foreach ($main_dishes as $option => $label) {
	print '<option value="' . htmlentities($option) . '"';
	if (array_key_exists($option, $selected_options)) {
		print ' selected';
	}
	print '>' . htmlentities($label) . '</option>';
}
print '</select>';



echo '</br></br>';

print '<input type="checkbox" name="delivery" value="yes"';
if ($defaults['delivery'] == 'yes') { print ' checked'; }
print '> Delivery?';
$checkbox_options = array(
	'small' => 'Small',
	'medium' => 'Medium',
	'large' => 'Large'
);
foreach ($checkbox_options as $value => $label) {
	print '<input type="radio" name="size" value="'.$value. '"';
	if ($defaults['size'] == $value) { print ' checked'; }
	print "> $label ";
}

echo '</br></br>';

print_r($_POST);





?>

