<?php namespace Gcore\Sanitizer\Template;

use Exception;

/**
 * Exception to handle required fields
 */
class RequiredFieldsException extends Exception
{
	protected $errors;

	/**
	 * Constructs the exception
	 *
	 * @param array $errors  List of errors
	 */
	public function __construct(array $errors)
	{
		parent::__construct('Required fields');

		$this->errors = $errors;
	}

	/**
	 * Get the list of errors
	 *
	 * @return array
	 */
	public function getErrors() : array
	{
		return $this->errors;
	}
}