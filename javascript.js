//Инструкция «if»
/*
let year = prompt('В каком году была опубликована спецификация ECMAScript-2015?', '');

//if(year == 2015) alert('Вы правы!');

if(year == 2015) {
	alert( "Правильно!" );
  alert( "Вы такой умный!" );
}

//Инструкция if (…) вычисляет выражение в скобках и преобразует результат к логическому типу.

if (0) { // 0 is falsy
  alert( "Hello" );
}

if (1) { // 1 is truthy
  alert( "Hello World" );
}

//Мы также можем передать заранее вычисленное в переменной логическое значение в if, например так:

let condition = (year == 2015); // преобразуется к true или false

if(condition) {
	alert( "Hello World" );
}

//Блок «else»

let year = prompt('В каком году была опубликована спецификация ECMAScript-2015?', '');

if(year == 2015) {
	alert( 'Да вы знаток!' );
} else {
	alert( 'А вот и неправильно!' );
}

//Несколько условий: «else if»

let yaer = promt('В каком году была опубликована спецификация ECMAScript-2015?', '');

if(year < 2015) {
	alert('Это слишком рано...');
} else if {
	alert( 'Это поздновато' );
} else {
	alert( 'Верно!' );
}
*/
//Условный оператор „?“
/*
let accessAllowed;
let age = prompt('Сколько вам лет?', '');

if(age > 18) {
	accessAllowed = true;
} else {
	accessAllowed = false;
}

alert(accessAllowed);	
*/
/*
//Оператор представлен знаком вопроса ?. Его также называют «тернарный», так как этот оператор, единственный в своём роде, имеет три аргумента.

//let result = условие ? значение1 : значение2;
//Сначала вычисляется условие: если оно истинно, тогда возвращается значение1, в противном случае – значение2.

accessAllowed = (age > 18) ? true : false;
alert(accessAllowed);
*/

/*
let age = prompt('Возраст?', 18);

let message = (age < 3) ? 'Здравствуй, малыш!' :
	(age < 18) ? 'Привет!' :
	(age < 99) ? 'Здравствуйте!' :
	'Какой необычный возраст!';

	alert(message);
*/

//Нетрадиционное использование „?“
//Иногда оператор «вопросительный знак» ? используется в качестве замены if
/*
let company = prompt('Какая компания создала JavaScript?', '');

(company == 'Netscape') ?
   alert('Верно!') : alert('Неправильно.');

//Вот, для сравнения, тот же код, использующий if:

let company = prompt('Какая компания создала JavaScript?', '');

if (company == 'Netscape') {
  alert('Верно!');
} else {
  alert('Неправильно.');
}

let userName = prompt("Кто там?", '');

if (userName == 'Админ') {

  let pass = prompt('Пароль?', '');

  if (pass == 'Я главный') {
    alert( 'Здравствуйте!' );
  } else if (pass == '' || pass == null) {
    alert( 'Отменено' );
  } else {
    alert( 'Неверный пароль' );
  }

} else if (userName == '' || userName == null) {
  alert( 'Отменено' );
} else {
  alert( "Я вас не знаю" );
}


let height = null;
let width = null;

//let area = (height ?? 100) * (width ?? 50);

//let area = height ?? 100 * width ?? 50;
let area = height ?? (100 * width) ?? 50;
alert(area);



for (let i = 0; i < 3; i++) { // выведет 0, затем 1, затем 2
  console.log(i);
}



let sum = 0;

while(true) {
	let value = +prompt("Введите число", '');
	if (!value) break; 
	sum += value;
}

alert('Сумма: ' + sum);

for(let i = 0; i < 10; i++) {
	if(i % 2 == 0) continue;

	alert(i);
}

for(let i = 0; i < 10; i++) {
	if(i % 2) {
		alert(i);
	}
}


// Приведёт к ошибке
let i = 6;
if(i > 5) {
	alert(i);
} else {
	continue;
}

(i > 5) ? alert(i) : continue;



for(let i = 0; i < 3; i++) {
	for(let j = 0; j < 3; j++) {
		let input = prompt(`Значение на координатах (${i},${j})`, '');

	 	// Что если мы захотим перейти к Готово (ниже) прямо отсюда?
	}
}

alert('Готово!');

//Обычный break после input лишь прервёт внутренний цикл, но этого недостаточно. 
//Достичь желаемого поведения можно с помощью меток.
//Метка имеет вид идентификатора с двоеточием перед циклом:

labelName: for (...) {

}

//Вызов break <labelName> в цикле ниже ищет ближайший внешний цикл с такой меткой 
//и переходит в его конец.

outer: for(let i = 0; i < 3; i++) {
	for(let j = 0; j < 3; j++) {
		let input = prompt(`Значение на координатах (${i},${j})`, '');

		// если пустая строка или Отмена, то выйти из обоих циклов
		if(!input) break outer;

		// сделать что-нибудь со значениями...
	}
}

alert('Готово!');

//Можно размещать метку на отдельной строке:
outer:
for (let i = 0; i < 3; i++) { ... }

//Директива continue также может быть использована с меткой. В этом случае управление 
//перейдёт на следующую итерацию цикла с меткой.

//Метки не позволяют «прыгнуть» куда угодно
//Метки не дают возможности передавать управление в произвольное место кода.
//Например, нет возможности сделать следующее:

break label; // не прыгает к метке ниже

label: for (...)

//Вызов break/continue возможен только внутри цикла, и метка должна находиться где-то 
//выше этой директивы.


let i = 0;
while (i < 5) {
	alert( i );
	i++;
}

let i = 0;
while (i++ < 5) alert( i );

for (let i = 0; i < 3; i++) {
  alert( `number ${i}!` );
}

let i = 0;
while(i < 3) {
	alert( `namber ${i}`);
	i++;
}

let num;

do {
	num = prompt("Введите число, большее 100?", 0);

} while (num <=100 && num);


//Натуральное число, большее 1, называется простым, если оно ни на что не делится, кроме себя и 1
//Напишите код, который выводит все простые числа из интервала от 2 до n
//Для n = 10 результат должен быть 2,3,5,7

let n = 10;

nextPrime:
for(let i = 2; i <= n; i++) { // Для всех i...

	for(let j = 2; j < i; j++) { // проверить, делится ли число..
		if(i % j == 0) continue nextPrime; // не подходит, берём следующее
	}
	alert( i ); // простое число
}


//Пример использования Конструкции switch

let a = 2 + 2;

switch(a) {
	case 3:
	alert( 'Маловато' );
	break;

	case 4:
	alert( 'В точку!' );
	break;

	case 5:
	alert( 'Перебор' );
	break;

	default:
	alert('Нет таких значений');

}

let a = 2 + 2;

switch (a) {
  case 3:
    alert( 'Маловато' );
  case 4:
    alert( 'В точку!' );
  case 5:
    alert( 'Перебор' );
  default:
    alert( "Нет таких значений" );
}

//И switch и case допускают любое выражение в качестве аргумента.

let a = "1";
let b = 0;

switch(+a) {
	case b + 1:
	alert("Выполнится, т.к. значением +a будет 1, что в точности равно b+1");
	break;

	default:
	alert("Это не выполнится");
}

console.log(b + 1);

let a = 2 + 2;

switch(a) {
	case 4:
	alert('Правильно!');
	break;

	case 3: // (*) группируем оба case
	case 5:
	alert('Неправильно!');
  alert("Может вам посетить урок математики?");
  break;

  default:
	alert('Результат выглядит странновато. Честно.');

}

//Нужно отметить, что проверка на равенство всегда строгая. 
//Значения должны быть одного типа, чтобы выполнялось равенство.


let arg = prompt("Введите число?");

console.log(typeof arg);

switch(arg) {
	case '0':
	case '1':
	alert( 'Один или ноль' );
	break;

	case '2':
	alert( 'Два' );
	break;

	case 3:
	alert( 'Никогда не выполнится!' );
	break;

	default:
	alert( 'Неизвестное значение' );
}



//Объявление функции

function showMessage() {
	alert( 'Всем привет! from function showMessage' );
}

showMessage();

//Переменные, объявленные внутри функции, видны только внутри этой функции.


//Function Expression
//Существует ещё один синтаксис создания функций, который называется Function Expression

let sayHi = function() {
  alert( "Привет" );
};

function sayHi(name) {
	alert("Привет " + name);
}

let func = sayHi;


func('Mike');

sayHi('Katya');



function ask(questions, yes, no) {
	if confirm
}

*/

//Остаточные параметры (...)
//https://learn.javascript.ru/rest-parameters-spread-operator

//Вызывать функцию можно с любым количеством аргументов независимо от того, 
//как она была определена. Например:

function sum(a, b) {
	return a + b;
}

console.log( sum(1, 2, 3, 4, 5) );

/*
Лишние аргументы не вызовут ошибку. Но, конечно, посчитаются только первые два.
Остаточные параметры могут быть обозначены через три точки .... Буквально это 
значит: «собери оставшиеся параметры и положи их в массив».
Например, соберём все аргументы в массив args:
*/

function sumAll(...args) {
	let sum = 0;

	for(let arg of args) sum += arg;

	return sum;
}

console.log(sumAll(1,2,3));

/*
Мы можем положить первые несколько параметров в переменные, а остальные – собрать 
в массив.

В примере ниже первые два аргумента функции станут именем и фамилией, а третий и 
последующие превратятся в массив titles:
*/

function showName(firstName, lastName, ...titles) {
	console.log(firstName + ' ' + lastName); // Юлий Цезарь

	// Оставшиеся параметры пойдут в массив
  // titles = ["Консул", "Император"]

  console.log(titles[0]);
  console.log(titles[1]);
  console.log(titles.length);
}

showName("Юлий", "Цезарь", "Консул", "Император");