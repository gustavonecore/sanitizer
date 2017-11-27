<?php require __DIR__ . '/../vendor/autoload.php';

// Define your template using the different types
$filter = new Gcore\Sanitizer\Template\TemplateSanitizer([
	'first_name' => 'string',
	'dob' => 'int',
	'numbers' => 'int[]',
	'fixed' => ['foo', 'bar'],
	'test' => 'int',
	'email' => 'email',
	'email_wrong' => 'email',
	'double' => 'double',
	'boolean' => 'bool',
	'datetime' => 'datetime',
	"persons[]" => [
		'name' => 'string',
		'eyes' => 'int',
		'address' => 'string[]',
		'commits[]' => [
			'hash' => 'string',
			'n_comments' => 'int',
			'users' => 'string[]'
		],
	],
	'not_filled' => 'int',
]);

// This will be your inut body from an user
$input = [
	'first_name' => 'Gustavo',
	'dob' => '10',
	'fixed' => 'foo',
	'numbers' => [1,2,3,'4','5'],
	'foo' => [1,2,4],
	'email' => 'gustavo.uach@gmail.com',
	'email_wrong' => 'gustavo.uachgmail.com',
	'double' => '7876',
	'boolean' => true,
	'datetime' => '2017-11-11 13:50:10',
	'persons' => [
		[
			'name' => 'jhon',
			'eyes' => 2,
			'address' => ['foo', 'bar', 'text'],
			'commits' => [
				'hash' => '2221321n3kj12n3kj12n32j1',
				'n_comments' => 900,
				'users' => ['jhon', 'doe'],
			],
		],
				[
			'name' => 'albert',
			'eyes' => 'wrong int here',
			'address' => ['a', 'b', 1],
			'commits' => null,
		],
	]
];

// All your data is clean now! awesome!
$cleanOutput = $filter->sanitize($input);

// Uncomment this if you want to test the requireFields feature
//$filter->requireFields(['first_name', 'not_filled']);

print_r($cleanOutput);