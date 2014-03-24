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

use ICanBoogie\DateTime;

/**
 * Representation of a result.
 *
 * @property DateTime $created_at The date and time at which the record was created.
 * @property DateTime $updated_at The date and time at which the record was updated.
 */
class Result extends \ICanBoogie\ActiveRecord
{
	public $result_id;
	public $nid;
	public $uid;

	private $created_at;

	/**
	 * Returns the date and time at which the record was created.
	 *
	 * @return \ICanBoogie\DateTime
	 */
	protected function volatile_get_created_at()
	{
		$datetime = $this->created_at;

		if ($datetime instanceof DateTime)
		{
			return $datetime;
		}

		return $this->created_at = ($datetime === null) ? DateTime::none() : new DateTime($datetime, 'utc');
	}

	/**
	 * Sets the date and time at which the record was created.
	 *
	 * @param \DateTime|string $datetime
	 */
	protected function volatile_set_created_at($datetime)
	{
		$this->created_at = $datetime;
	}

	private $updated_at;

	/**
	 * Returns the date and time at which the record was updated.
	 *
	 * @return \ICanBoogie\DateTime
	 */
	protected function volatile_get_updated_at()
	{
		$datetime = $this->updated_at;

		if ($datetime instanceof DateTime)
		{
			return $datetime;
		}

		return $this->updated_at = ($datetime === null) ? DateTime::none() : new DateTime($datetime, 'utc');
	}

	/**
	 * Sets the date and time at which the record was updated.
	 *
	 * @param \DateTime|string $datetime
	 */
	protected function volatile_set_updated_at($datetime)
	{
		$this->updated_at = $datetime;
	}

	private $serialized_responses;

	public function volatile_set_serialized_responses($value)
	{
		$this->serialized_responses = $value;
	}

	public function volatile_get_serialized_responses()
	{
		return $this->serialized_responses;
	}

	protected function volatile_set_responses($value)
	{
		$this->serialized_responses = serialize($value);
	}

	protected function volatile_get_responses()
	{
		return unserialize($this->serialized_responses);
	}

	public function __construct($model='forms.blueprints/results')
	{
		if (isset($this->responses))
		{
			$this->volatile_set_responses($this->responses);

			unset($this->responses);
		}

		parent::__construct($model);
	}

	protected function alter_persistent_properties(array $properties, \ICanBoogie\ActiveRecord\Model $model)
	{
		$properties = parent::alter_persistent_properties($properties, $model);

		if (!$this->result_id && $properties['created_at']->is_empty)
		{
			$properties['created_at'] = DateTime::now();
		}

		if ($properties['updated_at']->is_empty)
		{
			$properties['updated_at'] = DateTime::now();
		}

		return $properties;
	}
}