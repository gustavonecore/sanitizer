<?php

namespace Gcore\Sanitizer;

use Gcore\Sanitizer\TypeString;
use Gcore\Sanitizer\TypeInterface;

/**
 * Class to sanitize email data
 */
class TypeEmail implements TyeInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function sanitize($value)
	{
		return (new TypeString)->sanitize(filter_var($value, FILTER_VALIDATE_EMAIL) === $value ? $value : null);
	}
}
