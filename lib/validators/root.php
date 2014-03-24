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

interface ValidatorInterface
{
	public function __invoke($value);
	public function get_element_attributes();
}

/**
 * Validators root class.
 */
abstract class Validator implements ValidatorInterface
{
	protected $options;

	public function __construct(array $options)
	{
		$this->options = $this->normalize_options(array_filter($options));
	}

	/**
	 * Formats the error message.
	 *
	 * @param string $format
	 * @param array $args
	 * @param array $options
	 *
	 * @return \ICanBoogie\I18n\FormattedString
	 */
	public function format($format, array $args=array(), array $options=array())
	{
		return new FormattedString($format, $args, $options);
	}

	protected function normalize_options(array $options)
	{
		return $options + array
		(
			'value' => null,
			'custom_error_text' => null
		);
	}
}