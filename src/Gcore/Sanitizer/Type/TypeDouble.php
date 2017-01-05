<?php

namespace Gcore\Sanitizer;

use Gcore\Sanitizer\TypeString;
use Gcore\Sanitizer\TypeInterface;

/**
 * Class to sanitize double data
 */
class TypeDouble implements TyeInterface
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

			if ($test !== '' && is_double($test))
			{
				return $test;
			}
		}

		return null;
	}
}
