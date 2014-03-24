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

use Brickrouge\Element;

/**
 * Control for the `input:checkbox` input type.
 */
class CheckboxControl extends Control
{
	public function to_element(array $attributes=array())
	{
		return new Element(Element::TYPE_CHECKBOX_GROUP, $this->get_validation_attributes() + $attributes + array(

			Element::OPTIONS => $this->get_options()

		));
	}

	public function format_response($response)
	{
		$options = $this->get_options();
		$selected = array_intersect_key($options, $response);

		return implode("|", $selected);
	}
}