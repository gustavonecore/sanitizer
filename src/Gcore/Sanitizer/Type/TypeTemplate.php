<?php

namespace Gcore\Sanitizer\Type;

use Gcore\Sanitizer\Type\TypeInterface;
use Gcore\Sanitizer\Type\TypeInt;
use Gcore\Sanitizer\Type\TypeString;
use Gcore\Sanitizer\Type\TypeArray;
use InvalidArgumentException;

/**
 * Class to sanitize array data
 */
class TypeTemplate implements TypeInterface
{
	protected $template;
    protected $templateSanitizer;

	public function __contruct(array $template)
	{
		$this->template = $template;
        $this->templateSanitizer = $this->initSanitizers($template);
	}

    private function initSanitizers(array $template) : array
    {
        $templateSanitizer = [];

        foreach ($this->template as $fieldName => $rule)
        {
            $required = strpos($rule, '!') > 0;
            $isList = strpos($rule, '[]') > 0;
            $rule = str_replace('!', '', $rule);
            $type = null;

            if (is_string($rule))
            {
                switch ($rule)
                {
                    case 'int' : $type = new TypeInt; break;
                    case 'string' : $type = new TypeString; break;
                    // TODO: add the missing types here 
                }

                $type = $isList ? new TypeArray($type) : $type;
            }
            else if (is_array($rule))
            {
                $type = $this->initSanitizers($rule);
            }

            $templateSanitizer[$fieldName] = $type;
        }

        return $templateSanitizer;
    }

	/**
	 * {@inheritDoc}
	 */
	public function sanitize(array $values) : array
	{
        $output = [];

		foreach ($values as $fieldName => $value)
        {
            // Sanitize only the valid ones
            if (in_array($fieldName, array_keys($this->templateSanitizer)))
            {
                /*
                    $template = new Sanitizer([
                        'field1' => '!int', // required field
                        'field2' => [
                            'foo' => 'string',
                            'bar' => '!bool',
                            'var' => 'int',
                        ],
                        'field3' => 'int[]',
                        'field4' => 'string[]',
                    ]);
                */
                if (is_array($this->templateSanitizer[$fieldName]))
                {
                    $output[$fieldName] = $this->sanitize($value);
                }
                else
                {
                    $output[$fieldName] = $this->templateSanitizer[$fieldName]->sanitize($value);
                }
            }
        }

        return $output;
	}
}
