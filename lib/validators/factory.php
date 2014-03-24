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

class ValidatorFactory
{
	protected $types = array
	(
		'text:max_length' => 'Icybee\Modules\Forms\Blueprints\TextMaxLengthValidator',
		'text:min_length' => 'Icybee\Modules\Forms\Blueprints\TextMinLengthValidator'
	);

	public function __invoke(Item $item)
	{
		$options = $item->validation_options;

		if (!$options)
		{
			return new ValidatorList;
		}

		$list = array();

		foreach ($options as $type => $options)
		{
			$class = $this->types[$type];

			$list[$type] = new $class($options);
		}

		return new ValidatorList($list);
	}
}