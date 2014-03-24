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
 * Text length must be less than :value characters long.
 */
class TextMaxLengthValidator extends Validator
{
	protected function normalize_options(array $options)
	{
		return parent::normalize_options($options + array(

			'custom_error_text' => "Text length must be less than :value characters long."

		));
	}

	public function __invoke($value)
	{
		if (strlen($value) > $this->options['value'])
		{
			return $this->format
			(
				$this->options['custom_error_text'], array
				(
					'value' => $this->options['value'] + 1
				)
			);
		}
	}

	public function get_element_attributes()
	{
		$attributes = array();
		$max_length = $this->options['value'];

		if ($max_length)
		{
			$attributes['maxlength'] = $max_length;
			$attributes['data-max-length'] = $max_length;
			$attributes['data-max-length-error-text'] = $this->format($this->options['custom_error_text'], array('value' => $max_length + 1));
		}

		return $attributes;
	}
}