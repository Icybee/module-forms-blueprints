<?php

/*
 * This file is part of the Icybee package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Icybee\Modules\Forms\Blueprints;

/**
 * Representation of a blueprint item.
 *
 * Validation options:
 *
 * - text:length_max    [ value, custom_error_text ]
 * - text:length_min    [ value, custom_error_text ]
 * - pattern:contains   [ value, custom_error_text ]
 * - pattern:!contains  [ value, custom_error_text ]
 * - pattern:matches    [ value, custom_error_text ]
 * - pattern:!matches   [ value, custom_error_text ]
 *
 * @property array $options
 * @property string $serialized_options
 * @property array $validation_options
 * @property string $serialized_validation_options
 * @property Control $control Returns the control for the item type.
 */
class Item extends \ICanBoogie\ActiveRecord
{
	public $item_id;
	public $nid;
	public $uuid;
	public $type;
	public $title;
	public $description;

	private $serialized_options;

	public function volatile_set_serialized_options($value)
	{
		$this->serialized_options = $value;
	}

	public function volatile_get_serialized_options()
	{
		return $this->serialized_options;
	}

	private $serialized_validation_options;

	public function volatile_set_serialized_validation_options($value)
	{
		$this->serialized_validation_options = $value;
	}

	public function volatile_get_serialized_validation_options()
	{
		return $this->serialized_validation_options;
	}

	public $is_required;

	protected function volatile_set_options($value)
	{
		$this->serialized_options = serialize($value);
	}

	protected function volatile_get_options()
	{
		return unserialize($this->serialized_options);
	}

	protected function volatile_set_validation_options($value)
	{
		$this->serialized_validation_options = serialize($value);
	}

	protected function volatile_get_validation_options()
	{
		return unserialize($this->serialized_validation_options);
	}

	/**
	 * If the `options` or `validation_options` magic properties are defined they are mapped
	 * to their serialized conterparts and unset. This allows the developper to defined
	 * options and validation options using unserialized data.
	 *
	 * @param string $model Default: "forms.blueprints/items".
	 */
	public function __construct($model='forms.blueprints/items')
	{
		if (isset($this->options))
		{
			$this->volatile_set_options($this->options);
		}

		unset($this->options);

		if (isset($this->validation_options))
		{
			$this->volatile_set_validation_options($this->validation_options);
		}

		unset($this->validation_options);

		parent::__construct($model);
	}
}