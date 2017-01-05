<?php

namespace Gcore\Sanitizer;

use Gcore\Sanitizer\TypeInterface;

/**
 * Class to sanitize string data
 */
class TypeString implements TyeInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function sanitize($value)
	{
		return strval($value);
	}
}
