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

use ICanBoogie\Errors;

/**
 * @property-read Blueprint $record
 */
class SubmitOperation extends \ICanBoogie\Operation
{
	protected function get_controls()
	{
		return array
		(
			self::CONTROL_RECORD => true,
			self::CONTROL_PERMISSION => true,
			self::CONTROL_FORM => true
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

	protected function get_form()
	{
		global $core;

		$form_factory = new FormFactory;

		return $form_factory($this->record, $this->request);
	}

	protected function control_permission($permission)
	{
		// TODO-20140224: implement

		return true;
	}

	protected function validate(Errors $errors)
	{
		global $core;

		if ($core->user_id)
		{
			$result = $core->models['forms.blueprints/results']
			->filter_by_nid_and_uid($this->record->nid, $core->user_id)
			->one;

			if ($result)
			{
				$errors[] = "Vous avez déjà participé à cette enquête.";
			}
		}

		return !$errors->count();
	}

	protected function process()
	{
		global $core;

		$blueprint = $this->record;
		$progress = $blueprint->progress;
		$progress->update($this->request)->next();

		if ($progress->is_finished)
		{
			$result = Result::from(array(

				'nid' => $blueprint->nid,
				'uid' => $core->user_id,
				'responses' => $progress->responses

			));

			$result->save();
		}

		return true;
	}
}