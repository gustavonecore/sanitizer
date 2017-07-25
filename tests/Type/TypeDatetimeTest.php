<?php namespace Test\Type;

use DateTimeImmutable;
use Gcore\Sanitizer\Type\TypeDatetime;
use Gcore\Sanitizer\Type\TypeInterface;
use Test\AbstractUnitTest;

/**
 * @coversDefaultClass \Gcore\Sanitizer\Type\TypeDatetime
 */
class TypeDatetimeTest extends AbstractUnitTest
{
	/**
	 * Test boolean sanitizer
	 * @covers ::sanitize
	 * @uses \Gcore\Sanitizer\Type\TypeString::sanitize
	 */
	public function testSanitizer()
	{
		$sanitizer = new TypeDatetime;

		$this->assertInstanceOf(DateTimeImmutable::class, $sanitizer->sanitize(gmdate('Y-m-d H:i:s')));
		$this->assertInstanceOf(DateTimeImmutable::class, $sanitizer->sanitize('2017-01-01 13:12:13'));
		$this->assertTrue(is_null($sanitizer->sanitize('2017-01-01wcwecwec 13:12:13')));
		$this->assertTrue(is_null($sanitizer->sanitize(200)));
	}
}