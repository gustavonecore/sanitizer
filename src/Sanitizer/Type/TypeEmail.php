<?php namespace Gcore\Sanitizer\Type;

use Gcore\Sanitizer\Type\TypeString;
use Gcore\Sanitizer\Type\TypeInterface;

/**
 * Class to sanitize email data
 */
class TypeEmail implements TypeInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function sanitize($value)
	{
		return (new TypeString)->sanitize(filter_var($value, FILTER_VALIDATE_EMAIL) === $value ? $value : null);
	}
}
