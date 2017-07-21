<?php

namespace Gcore\Sanitizer\Type;

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
			$test = preg_replace( '/[^0-9]/', '', $value);

			if ($test !== '' && is_double(doubleval($test)))
			{
				return $test;
			}
		}

		return null;
	}
}
