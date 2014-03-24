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

class ScaleControl extends Control
{
	const DEFAULT_FROM = 1;
	const DEFAULT_TO = 5;

	protected function get_default_options()
	{
		return array
		(
			'from' => 1,
			'to' => 5,
			'from_label' => null,
			'to_label' => null
		);
	}

	public function to_element(array $attributes=array())
	{
		extract($this->get_options(), EXTR_PREFIX_ALL, 'option');

		return new ScaleElement($this->get_validation_attributes() + array(

			ScaleElement::FROM => $option_from,
			ScaleElement::FROM_LABEL => $option_from_label,
			ScaleElement::TO => $option_to,
			ScaleElement::TO_LABEL => $option_to_label

		) + $attributes);
	}

	public function format_response($response)
	{
		$options = $this->get_options();

		if (isset($options['from']) && isset($options['from_label']) && $options['from'] == $response)
		{
			$response = "$response ({$options['from_label']})";
		}
		else if (isset($options['to']) && isset($options['to_label']) && $options['to'] == $response)
		{
			$response = "$response ({$options['to_label']})";
		}

		return $response;
	}
}