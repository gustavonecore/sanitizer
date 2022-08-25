<?php namespace Gcore\Sanitizer\Type;

use Gcore\Sanitizer\Type\TypeString;
use Gcore\Sanitizer\Type\TypeInterface;

/**
 * Class to sanitize double data
 */
class TypeDouble implements TypeInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function sanitize($value)
	{
		if (is_double($value))
		{
			return $value;
		}
		else if (is_int($value))
		{
			return (doubleval($value));
		}
		else if (is_string($value))
		{
			if (is_numeric($value) && is_double(doubleval($value)))
			{
				return doubleval($value);
			}
		}

		return null;
	}
}
