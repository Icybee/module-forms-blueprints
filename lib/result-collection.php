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
 * A collection of results for a blueprint.
 *
 * @property-read array $header The header of the rows.
 * @property-read Blueprint $blueprint The {@link Blueprint} associated with the result collection.
 */
class ResultCollection implements \IteratorAggregate
{
	protected $header;

	protected $rows;

	protected $blueprint;

	public function __construct(Blueprint $blueprint)
	{
		$this->blueprint = $blueprint;

		$items = $this->filter_items($blueprint);
		$this->header = $header = $this->collect_header($blueprint, $items);
		$this->rows = $this->collect_rows($blueprint, $items, $header);
	}

	public function __get($property)
	{
		switch ($property)
		{
			case 'header':

				return $this->header;

			case 'blueprint':

				return $this->blueprint;
		}

		throw new \PropertyNotDefined(array($property, $this));
	}

	public function getIterator()
	{
		return new \ArrayIterator($this->rows);
	}

	/**
	 * Returns filtered items.
	 *
	 * Only _input_ items are preserved.
	 *
	 * @param Blueprint $blueprint
	 *
	 * @return array An array of uuid/Item pairs.
	 */
	protected function filter_items(Blueprint $blueprint)
	{
		$items = array();

		foreach ($blueprint->items as $item)
		{
			if (strpos($item->type, 'input:') !== 0)
			{
				continue;
			}

			$uuid = $item->uuid;
			$items[$uuid] = $item;
		}

		return $items;
	}

	protected function collect_header(Blueprint $blueprint, array $items)
	{
		$header = array
		(
			'created_at' => 'Created at',
			'uid' => 'User'
		);

		foreach ($items as $item)
		{
			$header[$item->uuid] = $item->title;
		}

		return $header;
	}

	protected function collect_rows(Blueprint $blueprint, array $items, array $header)
	{
		$rows = array();
		$empty_row = array_combine(array_keys($header), array_fill(0, count($header), null));

		foreach ($blueprint->results as $result)
		{
			$row = $empty_row;
			$row['created_at'] = $result->created_at->local;
			$row['uid'] = $result->uid;

			foreach ($result->responses as $uuid => $response)
			{
				$row[$uuid] = $items[$uuid]->control->format_response($response);
			}

			$rows[] = $row;
		}

		return $rows;
	}
}