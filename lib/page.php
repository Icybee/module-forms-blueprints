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

use ICanBoogie\PropertyNotDefined;

/**
 * Representation of a blueprint page.
 *
 * @property-read PageList $page_list
 * @property-read array $item_list
 * @property-read int $position
 */
class Page implements \IteratorAggregate, \Countable
{
	/**
	 * Page list.
	 *
	 * @var PageList
	 */
	protected $page_list;

	/**
	 * A list of {@link Item} instances.
	 *
	 * @var Item[]
	 */
	protected $item_list = array();

	protected $position;

	public function __construct(PageList $page_list, array $item_list, $position)
	{
		$this->page_list = $page_list;
		$this->item_list = $item_list;
		$this->position = $position;
	}

	public function __get($property)
	{
		switch ($property)
		{
			case 'page_list':

				return $this->page_list;

			case 'item_list':

				return $this->item_list;

			case 'position':

				return $this->position;
		}

		throw new PropertyNotDefined(array($property, $this));
	}

	public function getIterator()
	{
		return new \ArrayIterator($this->item_list);
	}

	public function count()
	{
		return count($this->item_list);
	}
}