<?php

require __DIR__ . '/../vendor/autoload.php';

$filter = new Gcore\Sanitizer\Type\TypeTemplate([
	'first_name' => 'string',
	'dob' => 'int',
	'numbers' => 'int[]',
	'test' => 'int',
	'email' => 'email',
	'double' => 'double',
	'boolean' => 'bool',
	'datetime' => 'datetime',
	"persons[]" => [
		'name' => 'string',
		'dob' => 'int',
		'address' => 'string[]',
		'commits[]' => [
			'hash' => 'string',
			'date' => 'int',
			'users' => 'string[]'
		],
	],
]);

//print_r($filter);

print_r($filter->sanitize([
	'first_name' => 'juan',
	'dob' => '10',
	'numbers' => [1,2,3,'4','5'],
	'foo' => [1,2,4],
	'email' => 'gustavo.uach@gmail.com',
	'double' => '7.876',
	'boolean' => 'true',
	'datetime' => '2017-11-11 13:50:10',
	'persons' => [
		[
			'name' => 'jhon',
			'dob' => 127,
			//'address' => ['foo', 'bar', 'text'],
			'commits' => [
				'hash' => '2221321n3kj12n3kj12n32j1',
				'date' => 900,
				'users' => ['jhon', 'doe'],
			],
		],
				[
			'name' => 'albert',
			//'dob' => 2,
			'address' => ['a', 'b', 1],
			'commits' => null,
		],
	]
]));