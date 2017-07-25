<?php namespace Test\Type;

use Gcore\Sanitizer\Type\TypeArray;
use Gcore\Sanitizer\Type\TypeString;
use Gcore\Sanitizer\Type\TypeInterface;
use Test\AbstractUnitTest;

/**
 * @coversDefaultClass \Gcore\Sanitizer\Type\TypeArray
 */
class TypeArrayTest extends AbstractUnitTest
{
	/**
	 * Tests the construction of the class.
	 *
	 * @covers ::__construct
	 * @uses \Gcore\Sanitizer\Type\TypeArray::getTypeItem
	 */
	public function testConstructor()
	{
		$sanitizer = new TypeArray(new TypeString);

		$this->assertInstanceOf(TypeInterface::class, $sanitizer);
		$this->assertInstanceOf(TypeString::class, $sanitizer->getTypeItem());

		return $sanitizer;
	}

	/**
	 * Test Type array success.
	 * @covers ::sanitize
	 * @uses \Gcore\Sanitizer\Type\TypeString::sanitize
	 * @depends testConstructor
	 */
	public function testTypeArray(TypeArray $typeArray)
	{
		$input = ['foo', 2, 'bar', 7.5];
		$output = $typeArray->sanitize($input);
		
		foreach ($output as $out)
		{
			$this->assertTrue(is_string($out));
		}

		$this->assertEquals(count($input), count($output));
	}
}