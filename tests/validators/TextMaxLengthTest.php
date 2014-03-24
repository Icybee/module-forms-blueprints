<?php

namespace Icybee\Modules\Forms\Blueprints;

class TextMaxLengthValidatorTest extends \PHPUnit_Framework_TestCase
{
	public function test_ok()
	{
		$i = new TextMaxLengthValidator(array('value' => 32));
		$this->assertNull($i(str_repeat('#', 2)));
		$this->assertNull($i(str_repeat('#', 32)));
	}

	public function test_error()
	{
		$i = new TextMaxLengthValidator(array('value' => 2));
		$this->assertInstanceOf('ICanBoogie\I18n\FormattedString', $i(str_repeat('#', 32)));
		$this->assertInstanceOf('ICanBoogie\I18n\FormattedString', $i(str_repeat('#', 3)));
	}
}