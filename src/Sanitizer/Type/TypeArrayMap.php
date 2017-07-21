<?php

namespace Gcore\Sanitizer\Type;

use Gcore\Sanitizer\Type\TypeInterface;
use InvalidArgumentException;
use RuntimeException;

/**
 * Class to sanitize array values of different types
 */
class TypeArrayMap implements TypeInterface
{
	protected $sanitizers;

	/**
	 * Constructs the class
	 * @param  array  $sanitizerss  List of different sanitizerss that implements TypeInterface
	 *                              The sanitizer will be in the form:
	 *                              [
	 *                                'foo' => Gcore\sanitizers\Type\TypeInterface,
	 *                                ...
	 *                              ],
	 */
	public function __construct(array $sanitizers)
	{
		$this->sanitizers = $sanitizers;
	}

	/**
	 * {@inheritDoc}
	 */
	public function sanitize($values) : array
	{
		if (!is_array($values))
		{
			return [];
		}

		$sanitized = [];

		foreach ($this->sanitizers as $key => $sanitizer)
		{
			$sanitized[$key] = isset($values[$key]) ? $sanitizer->sanitize($values[$key]) : null;
		}

		return $sanitized;
	}
}
