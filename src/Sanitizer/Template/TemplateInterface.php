<?php namespace Gcore\Sanitizer\Template;

use Gcore\Sanitizer\Type\TypeInterface;

/**
 * Interface to define templates
 */
interface TemplateInterface
{
	/**
	 * Get the proper sanitizer type class for the type of value
	 *
	 * @param  mixed       $type   Rule definition
	 * @throws \InvalidArgumentException if the type is not allowed
	 * @return \Gcore\Sanitizer\Type\TypeInterface
	 */
	public function getType($type, string $fieldName = '') : TypeInterface;

	/**
	 * Get array with all the sanitizers using the template as bassis
	 *
	 * @param  array       $template  Temlate with the sanitization rules
	 * @return array
	 */
	public function initSanitizers(array $template) : array;
}
