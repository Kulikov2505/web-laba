<?php

namespace Lib\View;

use Exception;

class ViewManager
{
	protected const VIEW_DIR = '/app/View/';

	/**
	 * @throws Exception
	 */
	public static function show(string $viewName, array $params = []): void
	{
		$pathToModel = $_SERVER['DOCUMENT_ROOT'] . self::VIEW_DIR . $viewName . '.php';

		if (!file_exists($pathToModel))
		{
			throw new Exception("Модель ${viewName} не найдена");
		}

		include $pathToModel;
	}
}