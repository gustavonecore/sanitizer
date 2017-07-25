<?php namespace Test\Type;

use Gcore\Sanitizer\Type\TypeEmail;
use Gcore\Sanitizer\Type\TypeInterface;
use Test\AbstractUnitTest;

/**
 * @coversDefaultClass \Gcore\Sanitizer\Type\TypeEmail
 */
class TypeEmailTest extends AbstractUnitTest
{
	/**
	 * Test boolean sanitizer
	 * @covers ::sanitize
	 * @uses \Gcore\Sanitizer\Type\TypeString::sanitize
	 */
	public function testSanitizer()
	{
		$sanitizer = new TypeEmail;
		
		$this->assertEquals("email@email.com", $sanitizer->sanitize("email@email.com"));
		$this->assertEquals("", $sanitizer->sanitize("emailsdsd wrong email.com"));
	}
}