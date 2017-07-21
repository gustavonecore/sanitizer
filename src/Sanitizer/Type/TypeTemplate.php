<?php namespace Gcore\Sanitizer\Type;

use Gcore\Sanitizer\Type\TypeInterface;
use Gcore\Sanitizer\Type\TypeInt;
use Gcore\Sanitizer\Type\TypeString;
use Gcore\Sanitizer\Type\TypeArray;
use Gcore\Sanitizer\Type\TypeArrayMap;
use Gcore\Sanitizer\Type\TypeBoolean;
use Gcore\Sanitizer\Type\TypeDatetime;
use Gcore\Sanitizer\Type\TypeDouble;
use Gcore\Sanitizer\Type\TypeEmail;
use InvalidArgumentException;

/**
 * Class to sanitize array data
 */
class TypeTemplate implements TypeInterface
{
	protected $template;
	protected $templateSanitizer;

	public function __construct(array $template)
	{
		$this->template = $template;
		$this->templateSanitizer = $this->initSanitizers($template);
	}

	private function getType($rule, string $fieldName = '') : TypeInterface
	{
		$type = null;

		if (is_string($rule))
		{
			$isList = strpos($rule, '[]') > 0;
			$rule = str_replace('!', '', $rule);
			$rule = str_replace('[]', '', $rule);

			switch ($rule)
			{
				case 'int' : $type = new TypeInt; break;
				case 'string' : $type = new TypeString; break;
				case 'bool' : $type = new TypeBoolean; break;
				case 'datetime' : $type = new TypeDatetime; break;
				case 'double' : $type = new TypeDouble; break;
				case 'email' : $type = new TypeEmail; break;
				default: throw new InvalidArgumentException('Invalid type ' . $rule);
			}
			
			$type = $isList ? new TypeArray($type) : $type;
		}
		else if (is_array($rule))
		{
			$isList = strpos($fieldName, '[]') > 0;

			$sanitizers = array_map(function($ruleItem)
			{
				return $this->getType($ruleItem);
			}, $rule);

			$cleanSanitizers = [];

			foreach ($sanitizers as $key => $value)
			{
				$key = str_replace('!', '', $key);
				$key = str_replace('[]', '', $key);
				$cleanSanitizers[$key] = $value;
			}

			$type = new TypeArrayMap($cleanSanitizers);
			$type = $isList ? new TypeArray($type) : $type;
		}
		else
		{
			throw new InvalidArgumentException('Invalid sanitizer type');
		}

		if ($type === null)
		{
			throw new InvalidArgumentException('Sanitizer was not created properly');
		}

		return $type;
	}

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
			'field5[]' => [
				'foo' => 'string',
				'bar' => '!bool',
				'var' => 'int',
			],
		]);
	*/
	private function initSanitizers(array $template) : array
	{
		$templateSanitizer = [];

		foreach ($template as $fieldName => $rule)
		{
			$fieldNameKey = str_replace('!', '', $fieldName);
			$fieldNameKey = str_replace('[]', '', $fieldNameKey);
			$templateSanitizer[$fieldNameKey] = $this->getType($rule, $fieldName);
		}

		return $templateSanitizer;
	}

	/**
	 * {@inheritDoc}
	 */

	 /*
		$values = [
			'field1' => 10,
			'field2' => [
				'foo' => 'test string',
				'bar' => true,
				'var' => 100,
			],
			'field3' => [],
			'field4' => 'string[]',
			'field5[]' => [
				'foo' => 'string',
				'bar' => '!bool',
				'var' => 'int',
			],
		]);
	*/
	public function sanitize($values) : array
	{
		if (!is_array($values))
		{
			throw new \InvalidArgumentException('TypeTemplate values must be an array');
		}

		$output = [];

		foreach ($this->templateSanitizer as $key => $sanitizer)
		{
			$output[$key] = isset($key, $values) ? $sanitizer->sanitize($values[$key]) : null;
		}

		return $output;
	}
}