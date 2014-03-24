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

class ControlFactory
{
	protected $types = array
	(
		'input:text'        => 'Icybee\Modules\Forms\Blueprints\TextControl',
		'input:scale'       => 'Icybee\Modules\Forms\Blueprints\ScaleControl',
		'input:radio'       => 'Icybee\Modules\Forms\Blueprints\RadioControl',
		'input:checkbox'    => 'Icybee\Modules\Forms\Blueprints\CheckboxControl',
		'layout:page_break' => 'Icybee\Modules\Forms\Blueprints\PageBreakControl'
	);

	public function __construct(array $types=array())
	{
// 		$this->resolvers = $resolvers;
	}

	public function __invoke(Item $item)
	{
		$type = $item->type;
		$class = $this->types[$type];

		return new $class($item);
	}
}