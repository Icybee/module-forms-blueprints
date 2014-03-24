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

class BacktrackOperation extends \ICanBoogie\Operation
{
	protected function get_controls()
	{
		return array
		(
			self::CONTROL_RECORD => true,
			self::CONTROL_PERMISSION => true
		)

		+ parent::get_controls();
	}

	protected function get_record()
	{
		global $core;

		$uuid = $this->request['uuid'];

		if (!$uuid)
		{
			return;
		}

		return $core->models['forms.blueprints']
		->filter_by_uuid($uuid)
		->one;
	}

	protected function control_permission($permission)
	{
		// TODO-20140224: implement

		return true;
	}

	protected function validate(\ICanBoogie\Errors $errors)
	{
		return true;
	}

	protected function process()
	{
		$this->record->progress->previous();

		return;
	}
}