<?php

namespace Icybee\Modules\Forms\Blueprints;

class ValidatorFactoryTest extends \PHPUnit_Framework_TestCase
{
	static private $instance;

	static public function setupBeforeClass()
	{
		self::$instance = new ValidatorFactory;
	}

	public function test_instance()
	{
		$factory = self::$instance;
		$item = Item::from(array(

			'validation_options' => array
			(
				'text:min_length' => array
				(
					'value' => 3
				),

				'text:max_length' => array
				(
					'value' => 32
				)
			)
		));

		$list = $factory($item);
		$validator_list = array();

		foreach ($list as $i => $validator)
		{
			$validator_list[] = $validator;
		}

		$this->assertInstanceOf('Icybee\Modules\Forms\Blueprints\TextMinLengthValidator', $validator_list[0]);
		$this->assertInstanceOf('Icybee\Modules\Forms\Blueprints\TextMaxLengthValidator', $validator_list[1]);
	}
}