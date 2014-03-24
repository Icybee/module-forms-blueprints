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
use ICanBoogie\HTTP\Request;

/**
 * Representation of the progress of the user through the blueprint.
 *
 * @property-read Page $page The current page.
 * @property-read int $position_min The value of the minimal position.
 * @property-read int $position_max The value of the maximal position.
 * @property-read bool $is_starting `true` if the progression is at the start, `false` otherwise.
 * @property-read bool $is_finished `true` if the progression is at the finish, `false` otherwise.
 * @property-read bool $is_first_page `true` if the current page is the the first page.
 * @property-read bool $is_last_page `true` if the current page is the the last page.
 */
class Progress
{
	static public function from(Blueprint $blueprint)
	{
		global $core;

		$nid = $blueprint->nid;
		$progress = &$core->session->forms_blueprints_progress[$nid];

		if (!$progress)
		{
			$progress = new static;
		}

		$progress->blueprint = $blueprint;

		return $progress;
	}

	public $responses = array();
	public $position = 0;

	/**
	 *
	 * @var Blueprint
	 */
	private $blueprint;

	public function __get($property)
	{
		switch ($property)
		{
			case 'is_starting':
			case 'is_first_page':

				return $this->position == 0;

			case 'is_finished':

				return $this->position == $this->position_max;

			case 'is_last_page':

				return $this->position == $this->position_max - 1;

			case 'position_min':

				return 0;

			case 'position_max':

				return $this->blueprint->page_list->count();

			case 'page':

				$page_list = $this->blueprint->page_list;

				return $page_list[$this->position];
		}

		throw new PropertyNotDefined(array($property, $this));
	}

	/**
	 * Discards {@link $blueprint} from the exported properties.
	 *
	 * @return array
	 */
	public function __sleep()
	{
		return array
		(
			'responses' => 'responses',
			'position' => 'position'
		);
	}

	/**
	 * Go to the next page.
	 *
	 * @return Progress
	 */
	public function next()
	{
		$this->position = min($this->position_max, $this->position + 1);

		return $this;
	}

	/**
	 * Go to the previous page.
	 *
	 * @return Progress
	 */
	public function previous()
	{
		$this->position = max($this->position_min, $this->position - 1);

		return $this;
	}

	/**
	 * Update the progress responses with the specified responses.
	 *
	 * Note: Only the responses for the _input_ items of the current page are updated
	 *
	 * @param Request|array $values
	 *
	 * @return Progress
	 */
	public function update($responses)
	{
		foreach ($this->page as $item)
		{
			if (strpos($item->type, 'input:') !== 0)
			{
				continue;
			}

			$uuid = $item->uuid;

			if (!isset($responses[$uuid]))
			{
				continue;
			}

			$this->responses[$uuid] = $responses[$uuid];
		}

		return $this;
	}
}