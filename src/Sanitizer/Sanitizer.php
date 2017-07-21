<?php

use Gcore\Sanitizer\Type\TypeInt;
use Gcore\Sanitizer\Type\TypeString;
use Gcore\Sanitizer\Type\TypeArray;

class Sanitizer
{
	protected $template;
	protected $typeSanitizer;
	protected $templateSanitizer;

	/*
	$template = new Sanitizer([
		'field1' => '!int', // required field
		'field2' => [
			'foo' => 'string',
			'bar' => '!bool',
			'var' => 'int',
		],
		'field3' => 'int[]',
		'field4' => 'string[]',
	]);
	*/
	public function __construct(array $template)
	{
		$this->template = $template;
	}

	public function getSanitizerType(array $template)
	{
		foreach ($template as $fieldName => $rule)
		{
			$required = strpos($rule, '!') > 0;
			$isList = strpos($rule, '[]') > 0;
			$rule = str_replace('!', '', $rule);
			$type = null;

			if (is_string($rule))
			{
				switch ($rule)
				{
					case 'int' : $type = new \Gcore\Sanitizer\Type\TypeInt; break;
					case 'string' : $type = new \Gcore\Sanitizer\Type\TypeString; break;
				}

				$type = $isList ? new TypeArray($type) : $type;
			}
			else if (is_array($rule))
			{
				$type = new TypeTemplate($rule);
			}

			$this->templateSanitizer[$fieldName] = $type;
		}
	}

	public function sanitize(array $input) : array
	{

	}
}