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

class ItemModel extends \ICanBoogie\ActiveRecord\Model
{
	public function save(array $properties, $key=null, array $options=array())
	{
		if (!$key && empty($properties['uuid']))
		{
			$properties['uuid'] = $this->generate_uuid();
		}

		return parent::save($properties, $key, $options);
	}

	public function generate_uuid()
	{
		for (;;)
		{
			$uuid = \ICanBoogie\generate_uuid_v4();

			if (!$this->filter_by_uuid($uuid)->count)
			{
				return $uuid;
			}
		}
	}
}