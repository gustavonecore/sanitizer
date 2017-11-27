<?php namespace Gcore\Sanitizer\Type;

use Gcore\Sanitizer\Type\TypeInterface;

/**
 * Class to sanitize fixed values
 */
class TypeFixedValues implements TypeInterface
{
	/**
	 * @var array  List of allowed values
	 */
	protected $fixedValues;

	/**
	 * Construct the sanitizer
	 * @param  array  $fixedValues   List of allowed values
	 */
	public function __construct(array $fixedValues)
	{
		$this->fixedValues = $fixedValues;
	}

	/**
	 * {@inheritDoc}
	 */
	public function sanitize($values)
	{
		return in_array($values, $this->fixedValues) ? $values : null;
	}
}
