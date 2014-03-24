<?php

namespace Icybee\Modules\Forms\Blueprints;

class TextMinLengthValidatorTest extends \PHPUnit_Framework_TestCase
{
	public function test_ok()
	{
		$i = new TextMinLengthValidator(array('value' => 2));
		$this->assertNull($i(str_repeat('#', 32)));
		$this->assertNull($i(str_repeat('#', 2)));
	}

	public function test_error()
	{
		$i = new TextMinLengthValidator(array('value' => 32));
		$this->assertInstanceOf('ICanBoogie\I18n\FormattedString', $i(str_repeat('#', 2)));
		$this->assertInstanceOf('ICanBoogie\I18n\FormattedString', $i(str_repeat('#', 31)));
	}
}