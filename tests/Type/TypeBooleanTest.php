<?php namespace Test\Type;

use Gcore\Sanitizer\Type\TypeBoolean;
use Gcore\Sanitizer\Type\TypeInterface;
use Test\AbstractUnitTest;

/**
 * @coversDefaultClass \Gcore\Sanitizer\Type\TypeBoolean
 */
class TypeBooleanTest extends AbstractUnitTest
{
	/**
	 * Test boolean sanitizer
	 * @covers ::sanitize
	 * @uses \Gcore\Sanitizer\Type\TypeString::sanitize
	 */
	public function testSanitizer()
	{
		$sanitizer = new TypeBoolean;
		
		$this->assertTrue(is_bool($sanitizer->sanitize("1")));
		$this->assertTrue(is_bool($sanitizer->sanitize(1)));
		$this->assertTrue(is_bool($sanitizer->sanitize(0)));
		$this->assertTrue(is_null($sanitizer->sanitize("wrong")));
	}
}