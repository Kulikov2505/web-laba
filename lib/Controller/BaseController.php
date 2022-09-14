<?php

namespace Lib\Controller;

abstract class BaseController
{
	protected array $params = [];

	public function __construct($params)
	{
		$this->params = $params;
	}

	/**
	 * @throws \Exception
	 */
	protected function includeView(string $view, array $params = [])
	{
		$result = [];
		$result['result'] = $params;
		$result['currentUrl'] = $this->params['request']['url'];

		if (isset($this->params['title']))
		{

			$result['title'] = $this->params['title'];

		}
		\Lib\View\ViewManager::show($view, $result);
	}
}