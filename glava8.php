<?php
/*
abstract class Lesson {
	protected $duration;
	const FIXED = 1;
	const TIMED = 2;
	private $costtype;

	function __construct($duration, $costtype = 1) {
		$this->duration = $duration;
		$this->costtype = $costtype;
	}

	function cost() {
		switch ($this->costtype) {
		CASE self::TIMED :
			return (5 * $this->duration);
			break;
		CASE self::FIXED :
			return 30;
			break;
		default:
			$this->costtype = self::FIXED;
			return 30;
		}
	}

	function chargeType() {
		switch ($this->costtype) {
			CASE self::TIMED :
				return "Почасовая оnлата";
				break;
			CASE self::FIXED :
				return "Фиксированная ставка";
				break;
			default :
				$this->costtype = self::FIXED;
				return "Фиксированная ставка";
		}
	}
	// Другие методы класса lesson...
}

class Lecture extends Lesson {
	// Специфичные для Lecture реализации ...
}

class Seminar extends Lesson {
// Специфичные для Seminar реализации ...
}

// А вот как я должен работать с этими классами.

$lecture = new Lecture(5, Lesson::FIXED);
print "{$lecture->cost()} ({$lecture->chargeType()}) \n";

$seminar = new Seminar(3, Lesson::TIMED);
print "{$seminar->cost()} ({$seminar->chargeType()}) \n";
*/
/*
На выходе получим следующее.
30 (Фиксированная ставка) 
30 (Фиксированная ставка)

Использование композиции

Для решения данной проблемы я могу воспользоваться шаблоном Strategy. Этот шаблон используется для перемещения набора алгоритмов в отдельный тип. Перемещая код для вычисления стоимости, я могу упростить тип Lesson (рис. 8.4).

Я создал еще один абстрактный класс CostStrategy, в котором определены абстрактные методы cost() и chargeType(). Методу cost() нужно передать экземпляр класса Lesson, который он будет использовать для расчета стоимости занятия. Мы обеспечиваем две реализации класса CostStrategy. Объекты Lesson работают только с типом CostStrategy, а не с конкретной реализацией, поэтому мы в любое время можем добавить новые алгоритмы расчета стоимости, создавая подклассы на основе CostStrategy. При этом не понадобится вносить вообще никаких изменений в классы Lesson.

*/

abstract class Lesson {
	private $duration;
	private $costStrategy;
	
	function __construct($duration, CostStrategy $strategy) {
		$this->duration = $duration;
		$this->costStrategy = $strategy;
	}
	function cost() {
		return $this->costStrategy->cost($this);
	}
			
	function chargeType() {
		return $this->costStrategy->chargeType();
	}

	function getDuration() {
		return $this->duration;
	}
	// Другие методы класса lesson...
	}
	
	class Lecture extends Lesson {
	// Специфичные для Lecture реализации ...
	}
	class Seminar extends Lesson {
	// Специфичные для Seminar реализации ...
	}

/*
Конструктору класса Lesson передается объект типа CostStrategy, который он сохраняет в виде свойства. Метод Lesson::cost() просто вызывает CostStrategy::cost(). Точно так же Lesson::chargeType() вызывает CostStrategy::chargeType().
Такой явный вызов метода другого объекта для выполнения запроса называется делегированием. В нашем примере объект типа CostStrategy - делегат класса Lesson. Класс Lesson снимает с себя ответственность за расчет стоимости занятия и возлагает эту задачу на реализацию класса CostStrategy. Вот как осуществляется делегирование.
*/

function cost() {
	return $this->costStrategy->cost($this);
}
/*
Ниже приведено определение иласса CostStrategy вместе с реализующими его дочерними массами.
*/

abstract class CostStrategy {
	abstract function cost (Lesson $lesson);
	abstract function chargeType();
}

class TimedCostStrategy extends CostStrategy {
	function cost(Lesson $lesson ) {
		return ($lesson->getDuration() * 5);
	}

	function chargeType() {
		return " Почасовая оплата ";
	}
}

class FixedCostStrategy extends CostStrategy {
	function cost (Lesson $lesson) {
		return 30;
	}

	function chargeType() {
		return " Фиксированная ставка ";
	}
}

/*
Во время выполнения программы я легко могу изменить способ расчета стоимости занятий, выполняемый любым объектом типа Lesson, передав ему другой объект типа CostStrategy. Этот подход способствует созданию очень гибкого кода. Вместо того чтобы статично встраивать функциональность в структуры кода, я могу комбинировать объекты и менять их сочетания динамически.
*/

$lessons[] = new Seminar ( 4, new TimedCostStrategy() );
$lessons[] = new Lecture ( 4, new FixedCostStrategy() );

foreach ( $lessons as $lesson ) {
	print " Плата за занятие " . $lesson->cost();
	print " Тип оплаты: " . $lesson->chargeType();
}

/*
Плата за занятие 20 Тип оплаты: Почасовая оплата 
Плата за занятие 30 Тип оплаты: Фиксированная ставка

Как видите, одно из следствий принятия этой структуры состоит в том, что мы рассредоточили обязанности наших классов. Объекты CostStrategy ответственны только за расчет стоимости занятия, а объекты Lesson управляют данными занятия. Итак, композиция позволяет сделать код намного более гибким, поскольку можно комбинировать объекты и решать задачи динамически намного большим количеством способом, чем при использовании одной лишь иерархии наследования. Однако при этом могут возникнуть проблемы с читабельностью кода. В результате композиции, как правило, создается больше типов, причем с отношениями, которые не настолько предсказуемы, как в отношениях наследования. Поэтому понять отношения в такой системе немного труднее.

Разделение
*/