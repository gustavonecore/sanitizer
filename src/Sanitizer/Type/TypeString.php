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
		if ($value === null) {
			return null;
		}

		$value = trim((string) $value);

		if ($value === '') {
			return null;
		}

		return $value;
	}
}
