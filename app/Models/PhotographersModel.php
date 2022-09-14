<?php

namespace App\Models;

class PhotographersModel extends \Lib\Model\BaseModel
{
	public static function create($fields)
	{
		$sql = 'insert into photographers (NAME, PHOTO, BIOGRAPHY, SHOOTING_STYLE_ID, BITRH_DATE) values  (:name, :photo, :biography, :shooting_style_id, :bitrh_date)';

		self::query($sql, [':name' => $fields['name'],
			':photo' => $fields['photo'],
			':biography' => $fields['biography'],
			':shooting_style_id' => $fields['shooting_style_id'],
			':bitrh_date' => $fields['bitrh_date']]
		);
	}

	public static function read($filter = '', $params = [])
	{
		$sql = 'select photographers.ID, photographers.NAME, photographers.PHOTO, photographers.BIOGRAPHY, photographers.SHOOTING_STYLE_ID, shooting_style.NAME as SHOOTING_NAME, photographers.BITRH_DATE from photographers
 			join shooting_style on photographers.SHOOTING_STYLE_ID = shooting_style.ID';

		if ($filter)
		{
			$sql .= ' where ' . $filter;
		}

		$sql .= ' order by photographers.ID';

		$ob = self::query($sql, $params);

		$result = [];

		while ($itm = $ob->fetch(\PDO::FETCH_ASSOC))
		{
			$temp = [];

			foreach ($itm as $columnName => $item)
			{
				$temp[$columnName] = [
					'value' => $item,
					'type' => $columnName == 'PHOTO' ? 'photo' : 'text'
				];
			}
			$result[$itm['ID']] = $temp;
		}

		return $result;
	}

	public static function update($set, $filter, $fields)
	{
		$sql = 'update photographers set ' . $set . ' where ' . $filter;

		self::query($sql, $fields);
	}

	public static function delete($filter, $fields)
	{
		$sql = 'delete from photographers where ' . $filter;

		self::query($sql, $fields);
	}
}