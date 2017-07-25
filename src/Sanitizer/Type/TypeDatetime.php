<?php namespace Gcore\Sanitizer\Type;

use DateTimeInterface;
use DateTimeImmutable;
use Gcore\Sanitizer\Type\TypeInterface;

/**
 * Class to sanitize array data
 */
class TypeDatetime implements TypeInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function sanitize($value)
	{
		if (is_string($value) === true && $value !== '')
		{
			$value = date_create_immutable($value);

			if ($value === false)
			{
				return null;
			}

			return $value;
		}
		else if ($value instanceof DateTimeInterface)
		{
			if (!($value instanceof DateTimeImmutable))
			{
				$value = date_create_immutable($value->format('c'));

				if ($value === false)
				{
					return null;
				}

				return $value;
			}
			else
			{
				return $value;
			}
		}

		return null;
	}
}
