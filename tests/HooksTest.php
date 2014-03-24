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

class HooksTest extends \PHPUnit_Framework_TestCase
{
	static private $blueprint;

	static public function setupBeforeClass()
	{
		global $core;

		$blueprint = $core->models['forms.blueprints']->one;

		if (!$blueprint)
		{
			throw new \Exception('Unable to retrieve a blueprint record.');
		}

		self::$blueprint = $blueprint;
	}

	public function test_get_page_list()
	{
		$this->assertInstanceOf('Icybee\Modules\Forms\Blueprints\PageList', self::$blueprint->page_list);
	}

	public function test_get_progress()
	{
		$this->assertInstanceOf('Icybee\Modules\Forms\Blueprints\Progress', self::$blueprint->progress);
	}
}