<?php

namespace Icybee\Modules\Forms\Blueprints;

class ValidatorListTest extends \PHPUnit_Framework_TestCase
{
	static private $instance;

	static public function setupBeforeClass()
	{
		self::$instance = new ValidatorList(array(

			new TextMinLengthValidator(array('value' => 3)),
			new TextMaxLengthValidator(array('value' => 32))

		));
	}

	public function test_ok()
	{
		$validator = self::$instance;
		$errors = $validator(str_repeat('#', 12));
		$this->assertEmpty($errors);
	}

	public function test_error_text_min()
	{
		$validator = self::$instance;
		$errors = $validator(str_repeat('#', 1));
		$this->assertNotEmpty($errors);
		$this->assertEquals("Text length must be more than 2 characters long.", implode($errors));
	}

	public function test_error_text_max()
	{
		$validator = self::$instance;
		$errors = $validator(str_repeat('#', 100));
		$this->assertNotEmpty($errors);
		$this->assertEquals("Text length must be less than 33 characters long.", implode($errors));
	}
}