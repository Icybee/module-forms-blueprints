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

class DeleteOperation extends \Icybee\Modules\Nodes\DeleteOperation
{
	protected function process()
	{
		global $core;

		$nid = $this->record->nid;

		$core->models['forms.blueprints/items']
		->filter_by_nid($nid)
		->delete();

		$core->models['forms.blueprints/results']
		->filter_by_nid($nid)
		->delete();

		return parent::process();
	}
}