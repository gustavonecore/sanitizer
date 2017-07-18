<?php

namespace Gcore\Sanitizer\Type;

use Gcore\Sanitizer\Type\TypeInterface;

/**
 * Class to sanitize integer data
 */
class TypeInt implements TypeInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function sanitize($value)
	{
		if (is_int($value) === true)
		{
			return $value;
		}
		else if (is_string($value) === true)
		{
			if (preg_match('/^-?(0|[1-9][0-9]*)$/', $value))
			{
				return (int) $value;
			}
		}
		else if (is_bool($value))
		{
			return (int) $value;
		}

		return null;
	}
}
