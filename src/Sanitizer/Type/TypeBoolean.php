<?php namespace Gcore\Sanitizer\Type;

use Gcore\Sanitizer\Type\TypeInterface;

/**
 * Class to sanitize boolean data
 */
class TypeBoolean implements TypeInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function sanitize($value)
	{
		if (is_bool($value))
		{
			return $value;
		}
		else if (is_string($value) === true && in_array($value, ['0', '1']))
		{
			return (bool) $value;
		}
		else if (is_int($value) === true && in_array($value, [0, 1]))
		{
			return (bool) $value;
		}

		return null;
	}
}
