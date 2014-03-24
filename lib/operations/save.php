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

class SaveOperation extends \Icybee\Modules\Nodes\SaveOperation
{
	// TODO-20140226: validate item properties

	protected function process()
	{
		$rc = parent::process();

		$nid = $rc['key'];

		if ($this->request['items'])
		{
			$w = 0;

			foreach ($this->request['items'] as $item_properties)
			{
				// TODO-20140226: sanitize item properties

				$item = Item::from(array('nid' => $nid, 'weight' => ++$w) + $item_properties);
				$item->save();
			}
		}

		return $rc;
	}
}