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

class PageListTest extends \PHPUnit_Framework_TestCase
{
	static private $blueprint;
	static private $page_list;

	static public function setupBeforeClass()
	{
		global $core;

		$blueprint = $core->models['forms.blueprints']->one;

		self::$blueprint = $blueprint;
		self::$page_list = new PageList($blueprint);
	}

	public function test_array_iterator()
	{
		$page_list = self::$page_list;

		foreach ($page_list as $position => $page)
		{
			$this->assertInstanceOf(__NAMESPACE__ . '\Page', $page);
			$this->assertEquals($position, $page->position);
			$this->assertSame($page_list, $page->page_list);

			foreach ($page as $item)
			{
				$this->assertInstanceOf(__NAMESPACE__ . '\Item', $item);
			}
		}
	}
}