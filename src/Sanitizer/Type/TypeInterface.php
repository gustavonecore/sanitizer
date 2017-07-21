<?php

namespace Gcore\Sanitizer\Type;

/**
 * Interface to define the strategy for every sanitizer
 */
interface TypeInterface
{
	/**
	 * Sanitize the given value using the internal algorithm
	 * @param  mixed        $value  The value to sanitize
	 * @return mixed|null   The value sanitized to the proper type
	 */
	public function sanitize($value);
}
