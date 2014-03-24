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
use Brickrouge\Group;

abstract class Control
{
	protected $item;

	public function __construct(Item $item)
	{
		$this->item = $item;
	}

	protected function get_options()
	{
		return $this->item->options + $this->get_default_options();
	}

	protected function get_default_options()
	{
		return array();
	}

	protected function get_validation_attributes()
	{
		$validator_factory = new ValidatorFactory;
		$validator_list = $validator_factory($this->item);

		return $validator_list->get_element_attributes();
	}

	/**
	 * Creates an {@link Element} instance.
	 *
	 * @param array $attributes
	 *
	 * @return Element
	 */
	abstract public function to_element(array $attributes=array());

	/**
	 * Formats a response into a string suitable for a CSV export.
	 *
	 * @param string $response
	 *
	 * @return string
	 */
	public function format_response($response)
	{
		return (string) $response;
	}
}