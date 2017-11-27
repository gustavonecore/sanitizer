GCore Sanitizer
===============

## PHP sanitizer and validator
This is a library to sanitize your input from any source, using a predefined template of native types.

**Why another sanitizer?**
Well, this is because I really want to maintain my toolset pretty small, and not depending on big libraries/frameworks. 

### Requirements

- PHP >= v7.0

### Install it with composer

    composer require gustavonecore/php-sanitizer

### Example of usage

**Template definition**
First, you must define your template


    $filter = new Gcore\Sanitizer\Template\TemplateSanitizer([
    	'first_name' => 'string',
    	'dob' => 'int',
    	'numbers' => 'int[]',
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
    ]);


**Sanitize!**
After that, you are good to sanitize any input

    // This will be your inut body from an user
    $input = [
    	'first_name' => 'Gustavo',
    	'dob' => '10',
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
    
    print_r($cleanOutput);




**Clean Output**

Output of the previous call

    php examples/index.php 
    Array
    (
        [first_name] => Gustavo
        [dob] => 10
        [numbers] => Array
            (
                [0] => 1
                [1] => 2
                [2] => 3
                [3] => 4
                [4] => 5
            )
    
        [test] => 
        [email] => gustavo.uach@gmail.com
        [email_wrong] => 
        [double] => 7876
        [boolean] => 1
        [datetime] => DateTimeImmutable Object
            (
                [date] => 2017-11-11 13:50:10.000000
                [timezone_type] => 3
                [timezone] => America/Santiago
            )
    
        [persons] => Array
            (
                [0] => Array
                    (
                        [name] => jhon
                        [eyes] => 2
                        [address] => Array
                            (
                                [0] => foo
                                [1] => bar
                                [2] => text
                            )
    
                        [commits] => Array
                            (
                                [hash] => 2221321n3kj12n3kj12n32j1
                                [n_comments] => 900
                                [users] => Array
                                    (
                                        [0] => jhon
                                        [1] => doe
                                    )
    
                            )
    
                    )
    
                [1] => Array
                    (
                        [name] => albert
                        [eyes] => 
                        [address] => Array
                            (
                                [0] => a
                                [1] => b
                                [2] => 1
                            )
    
                        [commits] => 
                    )
    
            )
    
    )



**Notes**

 - Not defined keys in the template will be **ignored** by the sanitizer.
 - If a value doesn't match the desired type, will be returned as **null**


**TODO**

 - [x] Add unit tests. #1 (In progress)
 - [x] Create a new template method to define **required** fields.
   - [ ] Improve this method to allow nested fields
 - [ ] Modularize a bit more the Strategy selector to allow extending the library with new types of data.
