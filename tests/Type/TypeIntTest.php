<?php namespace Test\Type;

use Gcore\Sanitizer\Type\TypeInt;
use Gcore\Sanitizer\Type\TypeInterface;
use Test\AbstractUnitTest;

/**
 * @coversDefaultClass \Gcore\Sanitizer\Type\TypeInt
 */
class TypeIntTest extends AbstractUnitTest
{
	/**
	 * Test boolean sanitizer
	 * @covers ::sanitize
	 * @uses \Gcore\Sanitizer\Type\TypeString::sanitize
	 */
	public function testSanitizer()
	{
		$sanitizer = new TypeInt;
		
		$this->assertEquals(10, $sanitizer->sanitize("10"));
		$this->assertEquals(10, $sanitizer->sanitize(10));
		$this->assertEquals(null, $sanitizer->sanitize("wrong integer"));
	}
}