<?php

namespace Icybee\Modules\Forms\Blueprints;

use Icybee\Modules\Forms\Blueprints\ResultTest\AlterPeristentPropertiesCase;
use ICanBoogie\DateTime;

class ResultTest extends \PHPUnit_Framework_TestCase
{
	public function test_alter_persistent_properties()
	{
		$responses = array
		(
			\ICanBoogie\generate_uuid_v4() => 1,
			\ICanBoogie\generate_uuid_v4() => 2,
			\ICanBoogie\generate_uuid_v4() => 3
		);

		$result = AlterPeristentPropertiesCase::from(array(

			'nid' => 1,
			'uid' => 1,
			'responses' => $responses

		));

		$properties = $result->save();

		$this->assertArrayNotHasKey('responses', $properties);
		$this->assertArrayHasKey('serialized_responses', $properties);
		$this->assertSame($properties['serialized_responses'], serialize($responses));
		$this->assertArrayHasKey('created_at', $properties);
		$this->assertArrayHasKey('updated_at', $properties);
		$this->assertInstanceOf('ICanBoogie\DateTime', $properties['created_at']);
		$this->assertInstanceOf('ICanBoogie\DateTime', $properties['updated_at']);
		$this->assertFalse($properties['created_at']->is_empty);
		$this->assertFalse($properties['updated_at']->is_empty);
	}

	public function test_created_at()
	{
		$created_at = new DateTime('-10 day');

		$result = AlterPeristentPropertiesCase::from(array(

			'nid' => 1,
			'uid' => 1,
			'created_at' => $created_at

		));

		$this->assertEquals($created_at, $result->created_at);

		$properties = $result->save();
		$this->assertArrayHasKey('created_at', $properties);
		$this->assertInstanceOf('ICanBoogie\DateTime', $properties['created_at']);
		$this->assertEquals($created_at, $properties['created_at']);
	}

	public function test_updated_at()
	{
		$updated_at = new DateTime('-10 day');

		$result = AlterPeristentPropertiesCase::from(array(

			'nid' => 1,
			'uid' => 1,
			'updated_at' => $updated_at

		));

		$this->assertEquals($updated_at, $result->updated_at);

		$properties = $result->save();
		$this->assertArrayHasKey('updated_at', $properties);
		$this->assertInstanceOf('ICanBoogie\DateTime', $properties['updated_at']);
		$this->assertEquals($updated_at, $properties['updated_at']);
	}
}

namespace Icybee\Modules\Forms\Blueprints\ResultTest;

use Icybee\Modules\Forms\Blueprints\Result;

class AlterPeristentPropertiesCase extends Result
{
	public function save()
	{
		$model = $this->volatile_get_model();
		$schema = $model->extended_schema;

		$properties = $this->to_array();

		return $this->alter_persistent_properties($properties, $model);
	}
}
