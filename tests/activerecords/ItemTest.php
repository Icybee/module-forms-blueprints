<?php

namespace Icybee\Modules\Forms\Blueprints;

class ItemTest extends \PHPUnit_Framework_TestCase
{
	static private $options = array(1 => 'one', 2 => 'two');

	/**
	 * @dataProvider provide_test_options
	 */
	public function test_options($item)
	{
		$options = self::$options;
		$serialized_options = serialize($options);

		$this->assertSame($options, $item->options);
		$this->assertSame($serialized_options, $item->serialized_options);
		$this->assertArrayHasKey('serialized_options', $item->to_array());
		$this->assertArrayHasKey('serialized_options', $item->__sleep());
		$this->assertArrayNotHasKey('options', $item->to_array());
		$this->assertArrayNotHasKey('options', $item->__sleep());

		$item->options = null;
		$this->assertNull($item->options);
		$this->assertSame(serialize(null), $item->serialized_options);
	}

	public function provide_test_options()
	{
		$options = self::$options;
		$serialized_options = serialize($options);

		$item_1 = new Item;
		$item_1->options = $options;

		$item_2 = new Item;
		$item_2->serialized_options = $serialized_options;

		return array
		(
			array($item_1),
			array(Item::from(array('options' => $options))),
			array(unserialize(serialize($item_1))),

			array($item_2),
			array(Item::from(array('serialized_options' => $serialized_options))),
			array(unserialize(serialize($item_2)))
		);
	}

	/**
	 * @dataProvider provide_test_validation_options
	 */
	public function test_validation_options($item)
	{
		$options = self::$options;
		$serialized_options = serialize($options);

		$this->assertSame($options, $item->validation_options);
		$this->assertSame($serialized_options, $item->serialized_validation_options);
		$this->assertArrayHasKey('serialized_validation_options', $item->to_array());
		$this->assertArrayHasKey('serialized_validation_options', $item->__sleep());
		$this->assertArrayNotHasKey('validation_options', $item->to_array());
		$this->assertArrayNotHasKey('validation_options', $item->__sleep());

		$item->validation_options = null;
		$this->assertNull($item->validation_options);
		$this->assertSame(serialize(null), $item->serialized_validation_options);
	}

	public function provide_test_validation_options()
	{
		$options = self::$options;
		$serialized_options = serialize($options);

		$item_1 = new Item;
		$item_1->validation_options = $options;

		$item_2 = new Item;
		$item_2->serialized_validation_options = $serialized_options;

		return array
		(
			array($item_1),
			array(Item::from(array('validation_options' => $options))),
			array(unserialize(serialize($item_1))),

			array($item_2),
			array(Item::from(array('serialized_validation_options' => $serialized_options))),
			array(unserialize(serialize($item_2)))
		);
	}
}