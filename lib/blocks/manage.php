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

class ManageBlock extends \Icybee\Modules\Nodes\ManageBlock
{
	public function __construct(Module $module, array $attributes=array())
	{
		parent::__construct($module, $attributes + array(

			self::T_COLUMNS_ORDER => array('title', 'url', 'is_online', 'uid', 'results', 'modified')

		));
	}

	protected function get_available_columns()
	{
		return array_merge(parent::get_available_columns(), array(

			'results' => __CLASS__ . '\ResultsColumn'

		));
	}
}

namespace Icybee\Modules\Forms\Blueprints\ManageBlock;

use Brickrouge\A;

use Icybee\ManageBlock\Column;

class ResultsColumn extends Column
{
	private $results_count = array();

	public function alter_records(array $records)
	{
		$keys = array();

		foreach ($records as $record)
		{
			$keys[] = $record->nid;
		}

		if ($keys)
		{
			$this->results_count = $this->manager->module->model('results')
			->filter_by_nid($keys)
			->count('nid');
		}

		return $records;
	}

	public function render_cell($record)
	{
		global $core;

		$nid = $record->nid;

		if (empty($this->results_count[$nid]))
		{
			return;
		}

		$count = $this->results_count[$nid];

		return new A($count, "/admin/forms.blueprints/$nid/results");
	}
}