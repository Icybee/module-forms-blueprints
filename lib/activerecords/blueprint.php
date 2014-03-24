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

use ICanBoogie\ActiveRecord;

/**
 * A blueprint of a form.
 *
 * @method \Brickrouge\Form to_element() to_element(\ICanBoogie\HTTP\Request $request) Creates a {@link \Brickrouge\Form} instance.
 *
 * @property-read array $items
 * @property-read array $results
 * @property PageList $page_list The page list of the blueprint.
 * @property Progress $progress The progress of the user through the blueprint.
 */
class Blueprint extends \Icybee\Modules\Nodes\Node
{
	public $uuid;
	public $description;
	public $has_progress_bar;

	protected function get_items()
	{
		return ActiveRecord\get_model('forms.blueprints/items')
		->filter_by_nid($this->nid)
		->order('weight')
		->all;
	}

	protected function get_results()
	{
		return ActiveRecord\get_model('forms.blueprints/results')
		->filter_by_nid($this->nid)
		->order('created_at')
		->all;
	}
}