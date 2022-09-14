<?php

namespace App\Controller;

use App\Models\PhotographersModel;
use App\Models\ShootingStyleModel;

class PhotographersController extends \Lib\Controller\BaseController
{
	public function show()
	{
		$result = [];

		$result['columns'] = ['ID', 'ФИО', 'Фотография', 'Краткая биография', 'Стиль съёмки', 'Дата рождения'];
		if (isset($this->params['request']['get']['SHORTING_STYLE_ID']) && intval($this->params['request']['get']['SHORTING_STYLE_ID']))
		{
			$result['items'] = PhotographersModel::read('photographers.SHORTING_STYLE_ID = :shooting_style_id', [':id' => $this->params['request']['get']['SHORTING_STYLE_ID']]);
		} else
		{
			$result['items'] = PhotographersModel::read();
		}

		foreach ($result['items'] as &$item)
		{
			$item['BITRH_DATE']['value'] = date('d.m.Y', strtotime($item['BITRH_DATE']['value']));

			$item['SHOOTING_NAME']['type'] = 'link';
			$item['SHOOTING_NAME']['link'] = '/shooting-style/edit/?id=' . $item['SHOOTING_STYLE_ID']['value'];
		}

		foreach ($result['items'] as &$itm)
		{
			unset($itm['SHOOTING_STYLE_ID']);
		}

		if (isset($_SESSION['msg']))
		{
			$result['alert']['text'] = $_SESSION['msg'];
			unset($_SESSION['msg']);
		}

		self::includeView('table', $result);
	}

	public function showEditPage()
	{
		$styles = [];

		foreach (ShootingStyleModel::read() as $style)
		{
			$temp = [];

			foreach ($style as $fieldName => $field)
			{
				$temp[mb_strtolower($fieldName)] = $field['value'];
			}

			$styles[] = $temp;
		}

		if (!intval($this->params['request']['get']['id']))
		{
			header('Location: /photographers/');
		}
		$result = [];

		$db = PhotographersModel::read(
			'photographers.ID = :id',
			[':id' => $this->params['request']['get']['id']]
		);

		$result['items'] = [
			[
				'name' => 'Фото фотографа',
				'code' => 'photo',
				'type' => 'file'
			],
			[
				'name' => 'ФИО фотографа',
				'code' => 'name',
				'type' => 'text',
				'value' => $db[$this->params['request']['get']['id']]['NAME']['value']
			],
			[
				'name' => 'Краткая биография',
				'code' => 'biography',
				'type' => 'text',
				'value' => $db[$this->params['request']['get']['id']]['BIOGRAPHY']['value']
			],
			[
				'name' => 'Дата рождения',
				'code' => 'bitrh_date',
				'type' => 'date',
				'value' => $db[$this->params['request']['get']['id']]['BITRH_DATE']['value'],
			],
			[
				'name' => 'Стиль съёмки',
				'code' => 'shooting_style_id',
				'type' => 'list',
				'list_values' => $styles,
				'value' => $db[$this->params['request']['get']['id']]['SHOOTING_STYLE_ID']['value']
			],
			[
				'code' => 'id',
				'value' => $this->params['request']['get']['id']
			]
		];

		unset($_SESSION['fields_msg']);

		$this->params['title'] = str_replace('!ID!', $this->params['request']['get']['id'], $this->params['title']);

		$result['action'] = '/photographers/edit/';

		self::includeView('record', $result);
	}

	public function edit()
	{
		if (PhotographersModel::read('photographers.id = :id', [':id' => $this->params['request']['post']['id']]))
		{
			$sql = 'PHOTO = :photo, NAME = :name, BIOGRAPHY = :biography, BITRH_DATE = :bitrh_date, SHOOTING_STYLE_ID = :shooting_style_id';
			$sqlParams = [
				':id' => $this->params['request']['post']['id'],
				':photo' => $this->params['request']['post']['photo'],
				':name' => $this->params['request']['post']['name'],
				':biography' => $this->params['request']['post']['biography'],
				':bitrh_date' => $this->params['request']['post']['bitrh_date'],
				':shooting_style_id' => $this->params['request']['post']['shooting_style_id']
			];

			if ($this->params['request']['files']['photo']['name'])
			{
				$filePath = '/files/' . $this->params['request']['files']['photo']['name'];

				move_uploaded_file($this->params['request']['files']['photo']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $filePath);

				$sql .= ', photo = :photo';
				$sqlParams[':photo'] = $filePath;
			}


			PhotographersModel::update(
				$sql,
				'ID = :id',
				$sqlParams
			);
			$_SESSION['msg'] = 'Фотограф успешно изменена';
			header('Location: /photographers/');
			die();
		} else
		{
			header('Location: /photographers/');
			die();
		}
	}

	public function showAddPage($fields = [])
	{
		$clients = [];

		foreach (ShootingStyleModel::read() as $client)
		{
			$temp = [];

			foreach ($client as $fieldName => $field)
			{
				$temp[mb_strtolower($fieldName)] = $field['value'];
			}

			$clients[] = $temp;
		}

		$result = [];

		if (!$fields)
		{
			$result['items'] = [
				[
					'name' => 'Фото фотографа',
					'code' => 'photo',
					'type' => 'file'
				],
				[
					'name' => 'ФИО фотографа',
					'code' => 'name',
					'type' => 'text'
				],
				[
					'name' => 'Краткая биография',
					'code' => 'biography',
					'type' => 'text'
				],
				[
					'name' => 'Дата рождения',
					'code' => 'bitrh_date',
					'type' => 'date'
				],
				[
					'name' => 'Стиль съёмки',
					'code' => 'shooting_style_id',
					'type' => 'list',
					'list_values' => $clients
				]
			];
		} else
		{
			$result['items'] = [
				[
					'name' => 'Фото фотографа',
					'code' => 'photo',
					'type' => 'file',
					'value' => $fields['photo']['name'] ?? '',
					'error' => $fields['photo']['error'] ?? ''
				],
				[
					'name' => 'ФИО фотографа',
					'code' => 'name',
					'type' => 'text',
					'value' => $fields['name']['name'] ?? '',
					'error' => $fields['name']['error'] ?? ''
				],
				[
					'name' => 'Краткая биография',
					'code' => 'biography',
					'type' => 'text',
					'value' => $fields['biography']['name'] ?? '',
					'error' => $fields['biography']['error'] ?? ''
				],
				[
					'name' => 'Дата рождения',
					'code' => 'bitrh_date',
					'type' => 'text',
					'value' => $fields['bitrh_date']['name'] ?? '',
					'error' => $fields['bitrh_date']['error'] ?? ''
				],
				[
					'name' => 'Стиль съёмки',
					'code' => 'shooting_style_id',
					'type' => 'list',
					'list_values' => $clients,
					'value' => $fields['shooting_style_id']['name'] ?? '',
					'error' => $fields['shooting_style_id']['error'] ?? ''
				]
			];
		}

		$result['action'] = '/photographers/add/';

		self::includeView('record', $result);
	}

	public function add()
	{
		$filePath = '/files/' . $this->params['request']['files']['photo']['name'];

		if ($this->params['request']['files']['photo']['name'] && move_uploaded_file($this->params['request']['files']['photo']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $filePath))
		{
			$this->params['request']['post']['photo'] = $filePath;
			PhotographersModel::create($this->params['request']['post']);
			$_SESSION['msg'] = 'Фотограф успешно добавлен';
			header('Location: /photographers/');
			die();
		} else
		{
			self::showAddPage([
				'photo' => [
					'error' => 'Не удалось загрузить файл'
				]
			]);
		}
	}

	public function delete()
	{
		if (PhotographersModel::read('photographers.ID = :id', [':id' => $this->params['request']['get']['id']]))
		{
			PhotographersModel::delete('ID = :id', [':id' => $this->params['request']['get']['id']]);
			$_SESSION['msg'] = 'Фотограф успешно удалён';
			header('Location: /photographers/');
			die();
		} else
		{
			header('Location: /photographers/');
			die();
		}
	}

}