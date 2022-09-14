<?php

namespace App\Models;

class ShootingStyleModel extends \Lib\Model\BaseModel
{
	public static function create($fields)
	{
		$sql = 'insert into shooting_style (NAME) values (:name)';

		self::query($sql, [':name' => $fields['name']]);
	}

	public static function read($filter = '', $params = [])
	{
		$sql = 'select ID, NAME from shooting_style';

		if ($filter)
		{
			$sql .= ' where ' . $filter;
		}

		$ob = self::query($sql, $params);

		$result = [];

		while ($itm = $ob->fetch(\PDO::FETCH_ASSOC))
		{
			$temp = [];

			foreach ($itm as $columnName => $item)
			{
				$temp[$columnName] = [
					'value' => $item,
					'type' => 'text'
				];
			}
			$result[$itm['ID']] = $temp;
		}

		return $result;
	}

	public static function update($set, $filter, $fields)
	{
		$sql = 'update shooting_style set ' . $set . ' where ' . $filter;

		self::query($sql, $fields);
	}

	public static function delete($filter, $fields)
	{
		$sql = 'delete from shooting_style where ' . $filter;

		self::query($sql, $fields);
	}
}