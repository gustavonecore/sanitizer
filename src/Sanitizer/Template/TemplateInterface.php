<?php

namespace Gcore\Sanitizer\Template;

use Gcore\Sanitizer\Type\TypeInterface;

/**
 * Interface to define templates
 */
interface TemplateInterface
{
	/**
	 * Get the proper type class for the type of value
	 *
	 * @param  string       $type  Name of the type class
	 * @throws \InvalidArgumentException if the type is not allowed
	 * @return \Gcore\Sanitizer\Type\TypeInterface
	 */
	public function getType(string $type) : TypeInterface;
}
