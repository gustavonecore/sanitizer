<?php

require __DIR__ . '/../vendor/autoload.php';

$filter = new Gcore\Sanitizer\Type\TypeTemplate([
	'first_name' => 'string',
	//'dob' => 'int',
	//'numbers' => 'int[]',
	"persons[]" => [
		'name' => 'string',
		'dob' => 'int',
		'address' => 'string[]',
	],
]);

print_r($filter);

/*
var_dump($filter->sanitize([
	'first_name' => 'juan',
	'dob' => '10',
	'numbers' => [1,2,3,'4','5'],
]));
*/
//echo "filter: " . print_r($filter);
/*

*/