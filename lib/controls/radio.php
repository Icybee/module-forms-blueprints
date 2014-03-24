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

class RadioControl extends Control
{
	public function to_element(array $attributes=array())
	{
		$options = $this->get_options();

		return new Element(Element::TYPE_RADIO_GROUP, $this->get_validation_attributes() + $attributes + array(

			Element::OPTIONS => $options

		));
	}

	public function format_response($response)
	{
		$options = $this->get_options();

		return isset($options[$response]) ? $options[$response] : '';
	}
}