//Namber
/*
const num = 42
const float = 42.42
const pow = 10e3
const stringInt = '42'
const stringFloat = '42.42'

const int = Number.parseInt(stringInt) + 2
const flt = Number.parseFloat(stringFloat) + 2

console.log(flt)
console.log('2 / 0 =', 2/0)
console.log(Number.NaN)
console.log(typeof NaN)
console.log(Number.isNaN(stringInt))

console.log(Number(stringInt) + 2)
console.log(+stringInt + 4)

console.log(Number.parseFloat(stringFloat) + 2)
console.log(parseFloat(stringFloat) + 2)
console.log(+stringFloat +5)


console.log(0.4 + 0.2)
console.log((0.4 + 0.2).toFixed(1))
console.log(parseFloat((0.4 + 0.2).toFixed(1)))
console.log(+((0.4 + 0.2).toFixed(1)))

console.log(1 + 0.2)

console.log(Number.MAX_SAFE_INTEGER)

// BigInt

console.log(Number.MAX_SAFE_INTEGER)
console.log(typeof 900719925474099199999n)
console.log(900719925474099199999n - 90071992547409919999n)
//console.log(900719925474099199999n - 725) //error

// Math

console.log(Math.E)
console.log(Math.PI)
console.log(Math.sqrt(25))
console.log(Math.pow(5, 3))
console.log(Math.abs(-42))
console.log(Math.max(11, 42, 27, 14, 51))
console.log(Math.min(11, 42, 27, 14, 51))
console.log(Math.floor(17.6))
console.log(Math.ceil(17.6))
console.log(Math.round(17.6))
console.log(Math.trunc(17.6))

//Урок 1. JavaScript. Что такое prototype. JavaScript Prototype (English Subs)
//https://youtu.be/aQkgUUmUJy4

const person = {
	name: 'Kostya',
	age: 39,

	greet: function() {
		console.log('Greet!')
	}
}

const person = new Object({
	name: 'Kostya',
	age: 39,

	greet: function() {
		console.log('Greet!')
	}
})

Object.prototype.sayHello = function() {
	console.log('Hello!')
}

const lena = Object.create(person);

lena.name = 'Elena';

let str = new String('I am string');
*/

//Урок 2. JavaScript. Что такое контекст this. Как работает call, bind, apply
//https://youtu.be/UGapN-hrekw

function hello() {
	console.log('Hello', this);
}

const person = {
	name: 'Kostya',
	age: 39,
	sayHello: hello,
	sayHelloWindow: hello.bind(window),
	sayHelloDocument: hello.bind(document),
	logInfo: function(job, phone) {
		console.group(`${this.name} info:`);
		console.log(`Name is ${this.name}`);
		console.log(`Age is ${this.age}`);
		console.log(`Job is ${job}`);
		console.log(`Phone is ${phone}`);
		console.groupEnd();
	}
}

const lena = {
	name: 'Elena',
	age: 32
}
/*
let setLenaInfo = person.logInfo.bind(lena);
setLenaInfo('secretar', '0957847578');
*/
// методу bind можно передать в качестве второго и третьего параметров
// значения которые мы передаём функции setLenaInfo('secretar', '0957847578')

/*
let setLenaInfo = person.logInfo.bind(lena, 'secretar', '0957847578');
setLenaInfo();
*/

// метод bind
//person.logInfo.bind(lena, 'secretar', '0957847578')();
// метод call
person.logInfo.call(lena, 'secretar', '0957847578');
// метод apply
person.logInfo.apply(lena, ['secretar', '0957847578']);

let array = [1, 2, 3, 4, 5];

/*
function multBy(arr, n) {
	return arr.map(function(i) {
		return i * n;
	})
}
*/

Array.prototype.multBy = function(n) {
	return this.map(function(i) {
		return i * n;
	})
}

console.log(array.multBy(5));


//Урок 3. JavaScript. Что такое замыкания. Как они работают (+ примеры)

function createCulcFunc(n) {
	return function() {
		console.log(`Result = ${1000 * n}`);
	}
}

createCulcFunc(5);            // Простой вызов ничего не выводит

let calc = createCulcFunc(5);
console.log(calc);

calc();

function createIncrementor(n) {
	return function(num) {
		return n + num
	}
}

let addOne = createIncrementor(1);

let addTen = createIncrementor(10);

console.log(addOne(10));
console.log(addOne(41));

console.log(addTen(10));
console.log(addTen(41));

function urlGenerator(domain) {
	return function(url) {
		return `https://${url}.${domain}`;
	}
}

const comUrl = urlGenerator('com');
const comRu = urlGenerator('ru')

console.log(comUrl('google'));
console.log(comRu('mail'));


function bind(context, fn) {
	return function(...args) {
		fn.apply(context, args)
	}
}

function logPerson() {
	console.log(`Person: ${this.name}, ${this.age}, ${this.job}`);
}

const person1 = {name: 'Micle', age: 27, job: 'Frontend'};
const person2 = {name: 'Vika', age: 23, job: 'SMM'};

bind(person1, logPerson)();
bind(person2, logPerson)();

//Урок 4. JavaScript. Асинхронность.Что такое Event Loop. JS SetTimeout 0
//https://youtu.be/vIZs5tH-HGQ

window.setTimeout(function() {
	console.log('Inside timeout');
}, 2000)

console.log('End');