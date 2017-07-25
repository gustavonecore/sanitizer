<?php namespace Test\Type;

use DateTimeImmutable;
use Gcore\Sanitizer\Type\TypeArrayMap;
use Gcore\Sanitizer\Type\TypeString;
use Gcore\Sanitizer\Type\TypeInt;
use Gcore\Sanitizer\Type\TypeBoolean;
use Gcore\Sanitizer\Type\TypeDatetime;
use Gcore\Sanitizer\Type\TypeEmail;
use Gcore\Sanitizer\Type\TypeInterface;
use Test\AbstractUnitTest;

/**
 * @coversDefaultClass \Gcore\Sanitizer\Type\TypeArrayMap
 */
class TypeArrayMapTest extends AbstractUnitTest
{
	/**
	 * Tests the construction of the class.
	 *
	 * @covers ::__construct
	 * @covers ::getSanitizers
	 */
	public function testConstructor()
	{
		$typeArraySanitizer = new TypeArrayMap(
		[
			'my_string' => new TypeString,
			'my_int' => new TypeInt,
			'my_datetime' => new TypeDatetime,
		]);

		$this->assertInstanceOf(TypeInterface::class, $typeArraySanitizer);
		$this->assertInstanceOf(TypeString::class, $typeArraySanitizer->getSanitizers()['my_string']);
		$this->assertInstanceOf(TypeInt::class, $typeArraySanitizer->getSanitizers()['my_int']);
		$this->assertInstanceOf(TypeDatetime::class, $typeArraySanitizer->getSanitizers()['my_datetime']);

		return $typeArraySanitizer;
	}

	/**
	 * Test sanitize method
	 * @covers ::sanitize
	 * @uses \Gcore\Sanitizer\Type\TypeString::sanitize
	 * @uses \Gcore\Sanitizer\Type\TypeDatetime::sanitize
	 * @uses \Gcore\Sanitizer\Type\TypeInt::sanitize
	 * @depends testConstructor
	 */
	public function testSanitizeSuccess(TypeArrayMap $typeArraySanitizer)
	{
		$output = $typeArraySanitizer->sanitize([
			'my_string' => 'Hi, I\'m a beautiful string',
			'my_int' => '10',
			'my_datetime' => gmdate('Y-m-d H:i:s'),
			'not_defined_field' => 100,
		]);
		
		$this->assertTrue(is_string($output['my_string']));
		$this->assertTrue(is_int($output['my_int']));
		$this->assertInstanceOf(DateTimeImmutable::class, $output['my_datetime']);
		$this->assertTrue(!isset($output['not_defined_field']));
	}
}