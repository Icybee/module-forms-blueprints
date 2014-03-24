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

use ICanBoogie\I18n\FormattedString;

use Brickrouge\Element;
use Brickrouge\retrieve_form;

class ScaleElement extends Element
{
	const FROM = '#scale-from';
	const FROM_LABEL = "#scale-from-label";
	const TO = '#scale-to';
	const TO_LABEL = "#scale-to-label";
	const DEFAULT_FROM = 1;
	const DEFAULT_TO = 5;

	public function __construct(array $attributes=array())
	{
		parent::__construct('div', $attributes + array(

			self::FROM => self::DEFAULT_FROM,
			self::TO => self::DEFAULT_TO,

			'class' => 'scale'

		));
	}

	protected function render_inner_html()
	{
		$head_inner_html = $this->render_scale_head_inner_html();
		$body_inner_html = $this->render_scale_body_inner_html();

		return <<<EOT
<table cellspacing="0" cellpadding="0" border="0">
	<thead>$head_inner_html</thead>
	<tbody>$body_inner_html</tbody>
</table>
EOT;
	}

	protected function render_scale_head_inner_html()
	{
		$from = $this[self::FROM];
		$to = $this[self::TO];
		$html = '';

		foreach(range($from, $to) as $i)
		{
			$html .= <<<EOT
<th class="scale-number"><label for="{$this->id}_$i">$i</label></th>
EOT;
		}

		return <<<EOT
<tr aria-hidden="true">
	<th class="scale-number empty">&nbsp;</th>
	$html
	<th class="scale-number empty">&nbsp;</th>
</tr>
EOT;
	}

	protected function render_scale_body_inner_html()
	{
		$from = $this[self::FROM];
		$from_label = $this[self::FROM_LABEL] ?: '&nbsp;';
		$to = $this[self::TO];
		$to_label = $this[self::TO_LABEL] ?: '&nbsp;';
		$html = '';
		$value = $this['value'] ?: $this[Element::DEFAULT_VALUE];

		foreach (range($from, $to) as $i)
		{
			$control = new Element('input', array(

				'id' => $this->id . "_$i",
				'required' => $this[self::REQUIRED],
				'role' => 'radio',
				'value' => $i,
				'name' => $this['name'],
				'type' => 'radio',

				'aria-label' => $i,
				'aria-required' => $this[self::REQUIRED],
				'checked' => (string) $value === (string) $i

			));

			$html .= <<<EOT
<td class="scale-row">$control</td>
EOT;
		}

		return <<<EOT
<tr>
	<td class="scale-row scale-label" aria-hidden="true">$from_label</td>
	$html
	<td class="scale-row scale-label" aria-hidden="true">$to_label</td>
</tr>
EOT;
	}

	public function validate($value, \ICanBoogie\Errors $errors)
	{
		$from = $this[self::FROM];
		$to = $this[self::TO];

		if ($from < $to ? $value < $from || $value > $to : $value > $from || $value < $to)
		{
			$errors[$this['name']] = new FormattedString
			(
				"The value should be between :from and :to, %value given.", array
				(
					'from' => $from,
					'to' => $to,
					'value' => $value
				)
			);
		}

		return parent::validate($value, $errors);
	}
}