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

class ResultsBlock
{
	protected $module;
	protected $nid;

	public function __construct(Module $module, array $attributes, array $params)
	{
		list($nid) = $params;

		$this->module = $module;
		$this->nid = $nid;
	}

	public function render()
	{
		global $core;

		$core->document->css->add(DIR . 'public/admin.css');

		$blueprint = $this->module->model[$this->nid];
		$results = new ResultCollection($blueprint);

		$head = $this->render_head($results);
		$body = $this->render_body($results);

		return <<<EOT
<h1 class="block-title">Résultats pour <q>{$blueprint->title}</q></h1>

<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
	$head
	$body
</table>

<p><a href="/api/forms.blueprints/{$blueprint->nid}/export" class="btn btn-primary"><i class="icon icon-download-alt"></i> Télécharger</a></p>
EOT;
	}

	protected function render_head(ResultCollection $results)
	{
		$cells = '';

		foreach ($results->header as $title)
		{
			$cells .= '<th>' . self::tidy_string($title) . '</th>';
		}

		return <<<EOT
<thead>$cells</thead>
EOT;
	}

	protected function render_body(ResultCollection $results)
	{
		$rows = '';

		foreach ($results as $row)
		{
			$cells = '';

			foreach ($row as $content)
			{
				$content = self::tidy_string($content);

				if (strpos($content, '|') !== false)
				{
					$lines = explode('|', $content);
					$content = '<ul><li>' . implode('</li><li>', $lines) . '</li></ul>';
				}

				$cells .= '<td>' . $content . '</td>';
			}

			$rows .= '<tr>' . $cells . '</tr>';
		}

		return <<<EOT
<tbody>$rows</tbody>
EOT;
	}

	public function __toString()
	{
		try
		{
			return (string) $this->render();
		}
		catch (\Exception $e)
		{
			return \Brickrouge\render_exception($e);
		}
	}

	static private function tidy_string($str)
	{
		$str = str_replace(" ?", "\xC2\xA0?", $str);
		$str = str_replace(" !", "\xC2\xA0!", $str);
		$str = str_replace(" »", "\xC2\xA0»", $str);
		$str = str_replace("« ", "«\xC2\xA0", $str);

		return $str;
	}
}