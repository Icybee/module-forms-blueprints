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

class ExportOperation extends \ICanBoogie\Operation
{
	protected function get_controls()
	{
		return array
		(
			self::CONTROL_PERMISSION => Module::PERMISSION_ADMINISTER,
			self::CONTROL_RECORD => true
		)

		+ parent::get_controls();
	}

	protected function validate(\ICanBoogie\Errors $errors)
	{
		return true;
	}

	protected function process()
	{
		$blueprint = $this->record;

		$collection = new ResultCollection($blueprint);

		$this->response->content_type = "text/csv; charset=utf-8";
		$this->response->headers['Content-Disposition']->value = 'attachement';
		$this->response->headers['Content-Disposition']->filename = $blueprint->title . ".csv";

		return function() use ($collection) {

			$fh = fopen('php://output', 'w');

			fputcsv($fh, array_map('utf8_decode', $collection->header), ';');

			foreach ($collection as $row)
			{
				fputcsv($fh, array_map('utf8_decode', $row), ';');
			}
		};
	}
}