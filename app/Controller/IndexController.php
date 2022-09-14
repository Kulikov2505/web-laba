<?php

namespace App\Controller;

use Lib\DataBase\DB;

class IndexController extends \Lib\Controller\BaseController
{
	/**
	 * Отображает страницу с сущностями
	 *
	 * @throws \Exception
	 */
	public function exec()
	{
		$pages = [
			[
				'url' => '/shooting-style/',
				'name' => 'Стили съёмки'
			],
			[
				'url' => '/photographers/',
				'name' => 'Фотографы'
			]
		];

		self::includeView('index', $pages);
	}
}