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

use ICanBoogie\OffsetNotWritable;
use ICanBoogie\PropertyNotDefined;

/**
 * A list of {@link Page} instances.
 */
class PageList implements \IteratorAggregate, \Countable, \ArrayAccess
{
	protected $blueprint;

	protected $list;

	public function __construct(Blueprint $blueprint)
	{
		$this->blueprint = $blueprint;
		$this->list = $this->create_list($blueprint);
	}

	public function getIterator()
	{
		return new \ArrayIterator($this->list);
	}

	public function count()
	{
		return count($this->list);
	}

	public function offsetExists($offset)
	{
		return isset($this->list[$offset]);
	}

	public function offsetGet($offset)
	{
		return $this->list[$offset];
	}

	public function offsetSet($offset, $value)
	{
		throw new OffsetNotWritable(array($offset, $this));
	}

	public function offsetUnset($offset)
	{
		throw new OffsetNotWritable(array($offset, $this));
	}

	protected function create_list()
	{
		$groups = array();
		$i = 0;

		foreach ($this->blueprint->items as $item)
		{
			if ($item->type == 'layout:page_break')
			{
				$i++;
			}

			$groups[$i][] = $item;
		}

		$pages = array();

		foreach ($groups as $position => $items)
		{
			$pages[$position] = new Page($this, $items, $position);
		}

		return $pages;
	}
}