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

use ICanBoogie\HTTP\Request;

class Hooks
{
	/*
	 * Events
	 */

	/**
	 * Removes `forms_blueprints_progress` from session when the user logout.
	 *
	 * @param \ICanBoogie\Operation\ProcessEvent $event
	 * @param \Icybee\Modules\Users\LogoutOperation $target
	 */
	static public function on_user_logout(\ICanBoogie\Operation\ProcessEvent $event, \Icybee\Modules\Users\LogoutOperation $target)
	{
		global $core;

		unset($core->session->forms_blueprints_progress);
	}

	/*
	 * Prototypes
	 */

	/**
	 * Returns a {@link PageList} instance for the $blueprint.
	 *
	 * @param Blueprint $blueprint
	 *
	 * @return PageList
	 */
	static public function blueprint_get_page_list(Blueprint $blueprint)
	{
		return new PageList($blueprint);
	}

	/**
	 * Returns the {@link Progress} instance associated with the blueprint.
	 *
	 * @param Blueprint $blueprint
	 *
	 * @return Progress
	 */
	static public function blueprint_get_progress(Blueprint $blueprint)
	{
		return Progress::from($blueprint);
	}

	/**
	 * Creates a {@link \Brickrouge\Form} instance.
	 *
	 * @param Blueprint $blueprint
	 * @param Request $request
	 *
	 * @return \Brickrouge\Form
	 */
	static public function blueprint_to_element(Blueprint $blueprint, Request $request)
	{
		$form_factory = new FormFactory;

		return $form_factory($blueprint, $request);
	}

	/**
	 * Returns a matching {@link Control} instance for the item.
	 *
	 * @param Item $item
	 *
	 * @return Control
	 */
	static public function item_get_control(Item $item)
	{
		static $factory;

		if (!$factory)
		{
			$factory = new ControlFactory;
		}

		return $factory($item);
	}
}