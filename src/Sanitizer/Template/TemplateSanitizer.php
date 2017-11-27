<?php namespace Gcore\Sanitizer\Template;

use Gcore\Sanitizer\Template\TemplateInterface;
use Gcore\Sanitizer\Type\TypeArray;
use Gcore\Sanitizer\Type\TypeArrayMap;
use Gcore\Sanitizer\Type\TypeBoolean;
use Gcore\Sanitizer\Type\TypeDatetime;
use Gcore\Sanitizer\Type\TypeDouble;
use Gcore\Sanitizer\Type\TypeEmail;
use Gcore\Sanitizer\Type\TypeInterface;
use Gcore\Sanitizer\Type\TypeInt;
use Gcore\Sanitizer\Type\TypeString;
use InvalidArgumentException;
use LogicException;
use RuntimeException;

/**
 * Class to sanitize array data
 */
class TemplateSanitizer implements TypeInterface, TemplateInterface
{
	/**
	 * @var  array  Template
	 */
	protected $template;

	/**
	 * @var  array  Generated array of sanitizers from the initial template
	 */
	protected $templateSanitizer;

	/**
	 * Output sanitized data
	 *
	 * @var array
	 */
	protected $output;

	/**
	 * Constructs the Template
	 * @param  array  $template   Template
	 */
	public function __construct(array $template)
	{
		$this->template = $template;
		$this->templateSanitizer = $this->initSanitizers($template);
		$this->output = null;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getType($rule, string $fieldName = '') : TypeInterface
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

		if ($type === null)
		{
			throw new InvalidArgumentException('Invalid sanitizer type/rule');
		}

		return $type;
	}

	/**
	 * {@inheritDoc}
	 */
	public function initSanitizers(array $template) : array
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
	public function sanitize($values) : array
	{
		if (!is_array($values))
		{
			throw new \InvalidArgumentException('TypeTemplate values must be an array');
		}

		$output = [];

		foreach ($this->templateSanitizer as $key => $sanitizer)
		{
			$output[$key] = array_key_exists($key, $values) ? $sanitizer->sanitize($values[$key]) : null;
		}

		$this->output = $output;

		return $output;
	}

	/**
	 * Get the sanitized data
	 *
	 * @return array
	 */
	public function getOutput() : array
	{
		return $this->output;
	}

	/**
	 * Iterate over the sanitized data for invalid values
	 * TODO: improve this method to allow nested fields like parent.child.chil1.child2
	 *
	 * @param array $fields  List of names to check
	 * @return array
	 */
	public function requireFields(array $fields) : array
	{
		if ($this->output === null)
		{
			throw new LogicException('You need to sanitize your data first before accesing the output');
		}

		$missingFields = [];

		foreach ($fields as $field)
		{
			if (!isset($this->output[$field]) || $this->output[$field] === null)
			{
				throw new RuntimeException('Required field ' . $field . ' was not fullfilled.');
			}
		}

		return $missingFields;
	}
}