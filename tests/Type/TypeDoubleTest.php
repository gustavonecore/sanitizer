<?php namespace Test\Type;

use Gcore\Sanitizer\Type\TypeDouble;
use Gcore\Sanitizer\Type\TypeInterface;
use Test\AbstractUnitTest;

/**
 * @coversDefaultClass \Gcore\Sanitizer\Type\TypeDouble
 */
class TypeDoubleTest extends AbstractUnitTest
{
	/**
	 * Test boolean sanitizer
	 * @covers ::sanitize
	 * @uses \Gcore\Sanitizer\Type\TypeString::sanitize
	 */
	public function testSanitizer()
	{
		$sanitizer = new TypeDouble;
		
		$this->assertTrue(is_double($sanitizer->sanitize("197987")));
		$this->assertTrue(is_double($sanitizer->sanitize(100)));
		$this->assertTrue(is_double($sanitizer->sanitize(0.9876)));
		$this->assertTrue(is_null($sanitizer->sanitize("wrong")));
	}
}