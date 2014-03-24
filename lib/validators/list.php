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
 * A list of validators.
 */
class ValidatorList implements \IteratorAggregate, ValidatorInterface
{
	protected $list = array();

	public function __construct(array $validator_list=array())
	{
		$this->list = $validator_list;
	}

	public function get_element_attributes()
	{
		$attributes = array();

		foreach ($this->list as $validator)
		{
			$attributes = array_merge($attributes, $validator->get_element_attributes());
		}

		return $attributes;
	}

	public function __invoke($value)
	{
		$errors = array();

		foreach ($this->list as $validator)
		{
			$errors[] = $validator($value);
		}

		return array_filter($errors);
	}

	public function getIterator()
	{
		return new \ArrayIterator($this->list);
	}
}