<?php

namespace Gcore\Sanitizer\Type;

use Gcore\Sanitizer\Type\TypeInterface;
use InvalidArgumentException;

/**
 * Class to sanitize array data
 */
class TypeArray implements TypeInterface
{
	protected $typeItem;

	public function __construct(TypeInterface $typeItem)
	{
		$this->typeItem = $typeItem;
	}
	/**
	 * {@inheritDoc}
	 */
	public function sanitize($values) : array
	{
		return array_map(function($value)
		{
			return $this->typeItem->sanitize($value);
		}, $values);
	}
}
