<?php

namespace Gcore\Sanitizer;

use Gcore\Sanitizer\TypeString;
use Gcore\Sanitizer\TypeInterface;

/**
 * Class to sanitize array data
 */
class TypeArray implements TyeInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function sanitize($value)
	{
		if (is_array($value))
		{
			return $value;
		}
		else if (is_object($value))
		{
			$newArray = [];

			foreach ($value as $key => $value)
			{
				$newArray[$key] = $value;
			}

			return $newArray;
		}

		return null;
	}
}
