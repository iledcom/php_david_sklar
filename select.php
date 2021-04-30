<?php


$query = 'SELECT dish_name, price, is_spicy FROM dishes WHERE price >= ?';
$params = ['5'];

function getQuery($query, $params) {
		$db_host = "localhost";
		$db_user = "root";
		$db_password = "";
		$db_name = "test_db";

		$sq = "?";


		$mysqli = @new mysqli($db_host, $db_user, $db_password, $db_name);
		if ($params) {
			$offset = 0;
			$len_sq = strlen($sq); 
			//strlen — Возвращает длину строки
			for ($i = 0; $i < count($params); $i++) {
				//count — Подсчитывает количество элементов массива или что-то в объекте
				$pos = strpos($query, $sq, $offset);
				//strpos — Ищет позицию первого вхождения подстроки $this->sq в строку $query. $offset - если этот параметр указан, то поиск будет начат с указанного количества символов с начала строки. Если задано отрицательное значение, отсчет позиции начала поиска будет произведен с конца строки.
				if (is_null($params[$i])) $arg = "NULL";
				//is_null — Проверяет, является ли значение переменной равным NULL
				else $arg = "'".$mysqli->real_escape_string($params[$i])."'";
				//mysqli::real_escape_string — Экранирует специальные символы в строке для использования в SQL-выражении, используя текущий набор символов соединения
				$query = substr_replace($query, $arg, $pos, $len_sq);
				//substr_replace() заменяет часть строки $query, начинающуюся с символа с порядковым номером $pos и (необязательной) длиной $len_sq, строкой $arg и возвращает результат.
				$offset = $pos + strlen($arg);
			}
		}
		return $query;
	}

print getQuery($query, $params);