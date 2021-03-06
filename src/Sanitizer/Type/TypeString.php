<?php namespace Gcore\Sanitizer\Type;

use Gcore\Sanitizer\Type\TypeInterface;

/**
 * Class to sanitize string data
 */
class TypeString implements TypeInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function sanitize($value)
	{
		if (trim($value) === '')
		{
			return null;
		}

		return strval($value);
	}
}
