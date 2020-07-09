<?php


try {
	$db = new PDO('mysql:host=localhost; dbname=test_db', 'root', '');
} catch (PDOException $e) {
	print "Can't connect: " . $e->getMessage();
	exit();
}
// установить исключения при ошибках в базе данных
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$q = $db->query('SELECT dish_name, price FROM dishes');
while ($row = $q->fetch()) {
	print "$row[dish_name], $row[price] \n" . '<br>';
}

echo '<br>';

$cheapest_dish_info = $db->query('SELECT dish_name, price FROM dishes ORDER BY price LIMIT 1')->fetch();
print "$cheapest_dish_info[0], $cheapest_dish_info[1]";

echo '<br><br>';

$oder_by_price = $db->query('SELECT dish_name, price FROM dishes ORDER BY price');

while ($s = $oder_by_price->fetch()) {
	print "$s[0], $s[1]" . '<br>';
}

$oder_by_price_desc = $db->query('SELECT dish_name, price FROM dishes ORDER BY price DESC');

echo '<br><br>';

while ($p = $oder_by_price_desc->fetch()) {
	print "$p[0], $p[1]" . '<br>';
}


echo '<br><br>';

$select_all = $db->query('SELECT * FROM dishes')->fetchAll(PDO::FETCH_COLUMN, 1);

$str = implode(', ', $select_all);

print $str;


echo '<br><br>';

// При наличии только числовых индексов значения очень легко
// объединяются вместе
$q = $db->query('SELECT dish_name, price FROM dishes');
while ($row = $q->fetch(PDO::FETCH_NUM)) {
	print implode(', ', $row) . '<br>';
}

echo '<br><br>';

// При наличии объекта для получения значений используется
// синтаксис доступа к свойствам этого объекта
$q = $db->query('SELECT dish_name, price FROM dishes');
while ($row = $q->fetch(PDO::FETCH_OBJ)) {
	print "$row->dish_name has price $row->price" .'<br>';
}

echo '<br><br>';

$q = $db->query('SELECT dish_name, price FROM dishes');
// Теперь методу fetch() не нужно больше ничего передавать,
// т.к. обо всем позаботится метод setFetchMode()
$q->setFetchMode(PDO::FETCH_NUM);
while($row = $q->fetch()) {
	print implode(', ', $row) . '<br>';
}