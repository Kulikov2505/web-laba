<?php

namespace App\Controller;

use App\Models\ShootingStyleModel;

class ShootingStyleController extends \Lib\Controller\BaseController
{
	public function show()
	{
		$result = [];

		$result['columns'] = ['ID', 'Название'];
		$result['items'] = ShootingStyleModel::read();

		if (isset($_SESSION['msg']))
		{
			$result['alert']['text'] = $_SESSION['msg'];
			unset($_SESSION['msg']);
		}

		self::includeView('table', $result);
	}

	public function showEditPage()
	{
		if (!intval($this->params['request']['get']['id']))
		{
			header('Location: /shooting-style/');
		}
		$result = [];

		$db = ShootingStyleModel::read(
			'ID = :id',
			[':id' => $this->params['request']['get']['id']]
		);

		$result['items'][] = [
			'name' => 'Название',
			'code' => 'name',
			'type' => 'text',
			'value' => $db[$this->params['request']['get']['id']]['NAME']['value']
		];

		$result['items'][] = [
			'code' => 'id',
			'value' => $this->params['request']['get']['id']
		];

		$this->params['title'] = str_replace('!NAME!', $db[$this->params['request']['get']['id']]['NAME']['value'], $this->params['title']);
		$result['action'] = '/shooting-style/edit/';

		self::includeView('record', $result);
	}

	public function edit()
	{
		if (ShootingStyleModel::read('ID = :id', [':id' => $this->params['request']['post']['id']]))
		{
			ShootingStyleModel::update('name = :name', 'id = :id', [':id' => $this->params['request']['post']['id'], ':name' => $this->params['request']['post']['name']]);
			$_SESSION['msg'] = 'Стиль успешно изменён';
			header('Location: /shooting-style/');
			die();
		} else
		{
			header('Location: /shooting-style/');
			die();
		}
	}

	public function showAddPage($fields = [])
	{
		$result = [];

		if (!$fields)
		{
			$result['items'][] = [
				'name' => 'Название',
				'code' => 'name',
				'type' => 'text'
			];
		} else
		{
			$result['items'][] = [
				'name' => 'Название',
				'code' => 'name',
				'type' => 'text',
				'value' => $fields['name'],
				'error' => $fields['error']
			];
		}

		$result['action'] = '/shooting-style/add/';

		self::includeView('record', $result);
	}

	public function add()
	{
		if (!ShootingStyleModel::read('NAME = :name', [':name' => $this->params['request']['post']['name']]))
		{
			ShootingStyleModel::create($this->params['request']['post']);
			$_SESSION['msg'] = 'Стиль успешно добавлен';
			header('Location: /shooting-style/');
			die();
		} else
		{
			self::showAddPage([
				'name' => $this->params['request']['post']['name'],
				'error' => 'Такой стиль уже существует'
			]);
		}
	}

	public function delete()
	{
		if (ShootingStyleModel::read('ID = :id', [':id' => $this->params['request']['get']['id']]))
		{
			ShootingStyleModel::delete('ID = :id', [':id' => $this->params['request']['get']['id']]);
			$_SESSION['msg'] = 'Стиль успешно удалён';
			header('Location: /shooting-style/');
			die();
		} else
		{
			header('Location: /shooting-style/');
			die();
		}
	}
}